<?php
/**
 * Xử lý request
 * 1. Method
 * 2. Body
 */
class Request
{
    private $__rules = [];
    private $__messages = [];
    private $__errors = [];
    public $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isPost()
    {
        if ($this->getMethod() == 'post') {
            return true;
        }
        return false;
    }

    public function isGet() {
        if ($this->getMethod() == 'get') {
            return true;
        }
        return false;
    }

    public function getFields()
    {
        $dataFields = [];

        if ($this->isGet()) {
            // Xử lý lấy dữ liệu với phương thức Get
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    if (is_array($value)) {
                        $dataFields[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataFields[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                        $dataFields[$key] = trim($dataFields[$key]);
                    }
                }
            }
        }

        if ($this->isPost()) {
            // Xử lý lấy dữ liệu với phương thức Post
            if (!empty($_POST)) {
                foreach ($_POST as $key => $value) {
                    if (is_array($value)) {
                        $dataFields[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        
                        $dataFields[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                        $dataFields[$key] = trim($dataFields[$key]);
                    }
                }
            }
        }

        return $dataFields;
    }

    /**
     * Set rules
     */
    public function rules($rules = []) {
        $this->__rules = $rules;
        
    }

    /**
     * Set messages
     */
    public function message($messages = []) {
        $this->__messages = $messages;
        
    }

    /**
     * Validate
     */

    public function validate() {
        // lấy các field từ form
        $dataFields = $this->getFields();
        
        // lấy các message
        $messages = $this->__messages;
        
        // lấy các rules
        $rules = $this->__rules;
        
        // xử lý rules
        if (!empty($rules)) {
            $validate = true;
            foreach ($rules as $fieldName => $rulesItem) {
                if (is_string($rulesItem)) {
                    $rulesItemArr = explode('|', $rulesItem);
                } elseif (is_array($rulesItem)) {
                    $rulesItemArr = $rulesItem;
                }
                
                if (!empty($rulesItemArr)) {
                    foreach ($rulesItemArr as $rule) {
                        switch (true) {
                            // callback: Kiểm tra xem rule có phải là 1 hàm gọi lại không
                            case $rule instanceof Closure:
                                $rule($fieldName, $dataFields[$fieldName], function ($message) use ($fieldName) {
                                    $this->__errors[$fieldName][] = $message;
                                    $validate = false;
                                });
                                break;
                            // Không có dấu :
                            case $rule == 'required':
                                if (empty($dataFields[$fieldName])) {
                                    $this->setErrors($fieldName, $rule);
                                    $validate = false;
                                }
                                break;
                            case $rule == 'email':
                                if (!filter_var($dataFields[$fieldName], FILTER_VALIDATE_EMAIL)) {
                                    $this->setErrors($fieldName, $rule);
                                    $validate = false;
                                }
                                break;
                            // có dấu :
                            case str_contains($rule, ':'):
                                $ruleArr = explode(':', $rule);
                                $ruleName = $ruleArr[0];
                                $ruleValue = $ruleArr[1];
                                switch ($ruleName) {
                                    case 'min':
                                        if (strlen($dataFields[$fieldName]) < $ruleValue) {
                                            $this->setErrors($fieldName, $ruleName);
                                            $validate = false;
                                        }
                                        break;
                                    case 'max':
                                        if (strlen($dataFields[$fieldName]) > $ruleValue) {
                                            $this->setErrors($fieldName, $ruleName);
                                            $validate = false;
                                        }
                                        break;
                                    case 'match':
                                        if ($dataFields[$fieldName] != $dataFields[$ruleValue]) {
                                            $this->setErrors($fieldName, $ruleName);
                                            $validate = false;
                                        }
                                        break;
                                    case 'unique':
                                        if (!empty($dataFields[$fieldName])) {
                                            // Phân tích $ruleValue
                                            $ruleValueArr = explode(',', $ruleValue);
        
                                            // tên bảng
                                            $table = trim($ruleValueArr[0]);
                                            // trường unique
                                            $field = !empty($ruleValueArr[1]) ? trim($ruleValueArr[1]) : null;
                                            // id ignore
                                            $id = !empty($ruleValueArr[2]) ? $ruleValueArr[2] : null;
                                            // field ignore
                                            $idColumn = null;
                                            if (!empty($id)) {
                                                $idColumn = !empty($ruleValueArr[3]) ? trim($ruleValueArr[3]) : 'id';
                                            }
        
                                            $value = trim($dataFields[$fieldName]);
                                            if (!empty($table) && !empty($field) && !empty($value)) {
                                                // check unique
                                                $sql = "SELECT $field FROM $table WHERE $field = '$value'";
                                                // check ignore
                                                if (!empty($id) && !empty($idColumn)) {
                                                    $sql .= " AND $idColumn != '$id'";
                                                }
                                                
                                                $result = $this->db->query($sql, [], true)->fetchColumn();
                                                if (!empty($result)) {
                                                    $this->setErrors($fieldName, $ruleName);
                                                    $validate = false;
                                                }
                                            } else {
                                                $this->setErrors($fieldName, $ruleName);
                                                $validate = false;
                                            }
                                            
                                        }
                                        
                                        break;
                                    
                                    // regex
                                    case 'regex':
                                        if (!preg_match($ruleValue, $dataFields[$fieldName])) {
                                            $this->setErrors($fieldName, $ruleName);
                                            $validate = false;
                                        }
                                        break;
                                    case 'not_regex':
                                        if (preg_match($ruleValue, $dataFields[$fieldName])) {
                                            $this->setErrors($fieldName, $ruleName);
                                            $validate = false;
                                        }
                                        break;    
                                    default:
                                        break;
                                }
                                break;
                            
                            default:
                                break;
                        }
                        
                    }
                }
                
            }
        }

        $sessionKey = Session::isValidSession(); // lấy session key
        Session::flash($sessionKey . '_errors', $this->errors()); // set session errors
        Session::flash($sessionKey . '_old', $dataFields); // set session errors
        
        return $validate;
    }

    /**
     * get errors
     */
    public function errors($fieldName = '') {
        if (!empty($this->__errors)) {
            if (empty($fieldName)) {
                $errorsArr = [];
                foreach ($this->__errors as $key => $error) {
                    $errorsArr[$key] = reset($error);
                }
                return $errorsArr;
            }
            return reset($this->__errors[$fieldName]);
        }
        return false;
    }

    /**
     * set errors
     */
    public function setErrors($fieldName, $ruleName) {
        $this->__errors[$fieldName][$ruleName] = $this->__messages[$fieldName . '.' . $ruleName];
    }
}