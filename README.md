# php-mvc
Base PHP MVC model

## Project Structure

```
├── app
│   ├── controllers                 # Chứa các controller xử lý logic của ứng dụng
│   │   ├── Home.php                # Controller chính cho trang chủ
│   │   └── admin                   # Thư mục chứa các controller cho admin
│   │       └── Dashboard.php
│   ├── core                        # Chứa các file cốt lõi như Router, Controller base, Model base
│   │   ├── AppServiceProvider.php
│   │   ├── HtmlHelper.php
│   │   └── ...
│   ├── errors                      # Chứa các file hiển thị lỗi
│   │   ├── 404.php
│   │   ├── database.php
│   │   └── exception.php
│   ├── helpers                     # Chứa các file helper hỗ trợ
│   │   └── functions.php
│   ├── middlewares                 # Chứa các middleware xử lý trước khi vào controller
│   │   └── AuthMiddleware.php
│   ├── models                      # Chứa các model đại diện cho dữ liệu và logic nghiệp vụ
│   │   └── HomeModel.php
│   └── views                       # Chứa các file giao diện (HTML, PHP) hiển thị cho người dùng
│       ├── block                   # Chứa các phần giao diện tái sử dụng (header, footer)
│       │   ├── footer.php
│       │   └── header.php
│       ├── home                    # Chứa các view liên quan đến trang chủ
│       │   └── index.php
│       └── layouts                 # Chứa các layout chính
│           └── client_layouts.php
├── configs                         # Chứa các file cấu hình
│   ├── app.php
│   ├── database.php
│   └── routes.php
├── core                            # Chứa các thành phần cốt lõi của framework
│   ├── Connection.php
│   ├── Controller.php
│   ├── Database.php
│   ├── Load.php
│   ├── Middlewares.php
│   ├── Model.php
│   ├── QueryBuilder.php
│   ├── Request.php
│   ├── Response.php
│   ├── Route.php
│   ├── ServiceProvider.php
│   ├── Session.php
│   ├── Template.php
│   ├── View.php
│   └── console                     # Chứa các template cho artisan command
│       ├── controller.tpl
│       ├── middleware.tpl
│       └── model.tpl
├── guilde                          # Chứa các file hướng dẫn
│   └── validate_form.txt
├── public                          # Thư mục công khai, chứa các file có thể truy cập từ trình duyệt
│   ├── assets                      # Chứa các tài nguyên tĩnh như CSS, JS
│   │   ├── clients
│   │   │   ├── css
│   │   │   │   └── style.css
│   │   │   └── js
│   │   │       └── script.js
│   └── index.php                   # Điểm vào chính của ứng dụng
├── artisan                         # File CLI hỗ trợ tạo controller, model, middleware
├── bootstrap.php                   # File khởi tạo ứng dụng
├── .htaccess                       # File cấu hình Apache, dùng để rewrite URL
└── README.md                       # File tài liệu mô tả project
```

## Description

Dự án này là một cấu trúc cơ bản của PHP MVC (Model-View-Controller) được thiết kế để giúp các nhà phát triển nhanh chóng xây dựng các ứng dụng web. Dưới đây là giải thích ngắn gọn về từng thư mục và tệp:

### `app`
- **`controllers`**: Chứa các controller xử lý yêu cầu của người dùng và điều phối giữa models và views.
- **`core`**: Bao gồm các tệp cốt lõi như `Router.php`, `Controller.php`, và `Model.php` để triển khai kiến trúc MVC.
- **`models`**: Chứa các model đại diện cho dữ liệu và logic nghiệp vụ của ứng dụng.
- **`views`**: Chứa các tệp giao diện (HTML/PHP) được render và hiển thị cho người dùng.

### `public`
- **`css`**: Lưu trữ các tệp CSS để tạo kiểu cho ứng dụng.
- **`js`**: Chứa các tệp JavaScript phục vụ tương tác phía client.
- **`index.php`**: Điểm vào chính của ứng dụng, chịu trách nhiệm xử lý tất cả các yêu cầu đến.

### Các tệp khác
- **`.htaccess`**: Tệp cấu hình Apache để rewrite URL và các thiết lập khác.
- **`README.md`**: Cung cấp tài liệu và tổng quan về dự án.

## Cách sử dụng

1. Clone repository về máy.
3. Cấu hình máy chủ web của bạn để trỏ đến thư mục `public`.
4. Bắt đầu xây dựng ứng dụng của bạn bằng cách thêm các controller, model, và view.
