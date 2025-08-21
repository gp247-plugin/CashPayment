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