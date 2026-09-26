### 1. Tổng quan
Plugin thanh toán tiền mặt (Cash payment) dành cho GP247/Shop. Phù hợp cho mô hình thu tiền mặt khi giao hàng hoặc thanh toán ngoại tuyến; đơn hàng được tạo thành công và việc thanh toán diễn ra giữa người mua và người bán ngoài hệ thống.

### 2. Giới thiệu chức năng
- Thêm phương thức thanh toán "Tiền mặt khi nhận hàng" vào quy trình checkout.
- Không xử lý giao dịch trực tuyến; đơn hàng ở trạng thái chờ thanh toán cho đến khi thu tiền.
- Có thể bật/tắt trong khu vực quản trị.
- Tương thích với core từ phiên bản 1.1 trở lên; sử dụng gói `gp247/shop`.

### 3. Hướng dẫn cài đặt
Có thể cài đặt theo một trong các cách sau:

1) Cài đặt trực tuyến: mở thư viện Plugin trong trang quản trị và tìm "Cash payment" để cài đặt.
2) Cài đặt qua tệp ZIP: tải lên gói ZIP của plugin từ khu vực quản trị.
3) Cài đặt thủ công: giải nén và sao chép vào thư mục `app/GP247/Plugins/CashPayment`, sau đó vào trang quản trị và chạy lưu cấu hình cục bộ.

Tham khảo hướng dẫn cài đặt extension (tiếng Việt): `https://gp247.net/vi/docs/user-guide-extension/guide-to-installing-the-extension.html`

#### Cài bằng dòng lệnh (CLI, gp247 3.x)

Từ gp247 3.x, bạn có thể tải **CashPayment** từ thư viện GP247 và cài ngay bằng dòng lệnh mà không cần mở admin. Plugin yêu cầu website đã cài gói `gp247/shop`. Mở Terminal tại thư mục gốc website rồi chạy:

```bash
# 1) Chỉ làm 1 lần cho mỗi website: đăng ký API License (miễn phí) để kết nối thư viện GP247
php artisan gp247:ext-register-license

# 2) Tải plugin từ thư viện và cài
php artisan gp247:ext-install --type=plugin --key=CashPayment
```

- Trước bước 1, kiểm tra `APP_URL` trong `.env` là **domain thật** của website (không để `http://localhost`), vì license được gắn với domain này.
- Cài xong, plugin được **bật sẵn** và cache tự làm mới, bạn không cần thao tác gì thêm trong admin.
- Lệnh tự kiểm tra điều kiện khai báo trong `gp247.json` (phiên bản core, gói composer, plugin phụ thuộc). Nếu thiếu, lệnh dừng lại và báo rõ thiếu gì (ví dụ website chưa có `gp247/shop`).
- Nếu thư mục `app/GP247/Plugins/CashPayment` đã có sẵn trên máy (chép thủ công hoặc có sẵn theo bộ cài), lệnh sẽ **cài tại chỗ**, không tải lại.
- Nếu plugin đã được cài, lệnh sẽ từ chối. Để lên bản mới, chạy `php artisan gp247:ext-update --type=plugin --key=CashPayment`.
- Thêm `--json` vào cuối lệnh để nhận kết quả dạng máy đọc được (dùng cho script/CI).
- Chi tiết: [Hướng dẫn cài đặt Plugin & Template](https://github.com/gp247net/gp247-docs/blob/main/extension/install-extension_vi.md) · [Tra cứu lệnh](https://github.com/gp247net/gp247-docs/blob/main/system/command-line-reference_vi.md).

### 4. Cách sử dụng
- Vào trang quản trị: Plugins → Payment → bật "Cash payment".
- Không yêu cầu cấu hình thêm cho phương thức này.
- Trên trang checkout của cửa hàng, người mua chọn phương thức "Tiền mặt khi nhận hàng".
- Đơn hàng sẽ hiển thị trạng thái chờ thanh toán cho đến khi được xác nhận đã thu tiền.

### 4. Tài liệu
- Link GitHub: `https://github.com/gp247net/CashPayment`
- Link hướng dẫn: `https://gp247.net/vi/docs/user-guide-extension/guide-to-installing-the-extension.html`

### 5. Giấy phép
Được phát triển bởi GP247