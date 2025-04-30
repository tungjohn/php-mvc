# php-mvc
Base PHP MVC model

## Project Structure

```
├── app
│   ├── controllers    # Chứa các controller xử lý logic của ứng dụng
│   ├── core           # Chứa các file cốt lõi như Router, Controller base, Model base
│   ├── models         # Chứa các model đại diện cho dữ liệu và logic nghiệp vụ
│   └── views          # Chứa các file giao diện (HTML, PHP) hiển thị cho người dùng
├── public
│   ├── css            # Chứa các file CSS phục vụ giao diện
│   ├── js             # Chứa các file JavaScript phục vụ tương tác
│   └── index.php      # Điểm vào chính của ứng dụng, xử lý tất cả các request
├── .htaccess          # File cấu hình Apache, dùng để rewrite URL
├── composer.json      # File cấu hình Composer, khai báo các dependency của project
├── composer.lock      # File khóa phiên bản dependency, đảm bảo tính nhất quán
└── README.md          # File tài liệu mô tả project
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
- **`composer.json`**: Định nghĩa các dependency của dự án được quản lý bởi Composer.
- **`composer.lock`**: Khóa phiên bản của các dependency để đảm bảo tính nhất quán.
- **`README.md`**: Cung cấp tài liệu và tổng quan về dự án.

## Cách sử dụng

1. Clone repository về máy.
2. Chạy lệnh `composer install` để cài đặt các dependency.
3. Cấu hình máy chủ web của bạn để trỏ đến thư mục `public`.
4. Bắt đầu xây dựng ứng dụng của bạn bằng cách thêm các controller, model, và view.
