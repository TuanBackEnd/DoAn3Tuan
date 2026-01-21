# HƯỚNG DẪN XỬ LÝ ẢNH SẢN PHẨM

## Vấn đề
Ảnh sản phẩm không hiển thị vì file ảnh chưa được đặt đúng vị trí.

## Giải pháp

### 1. Vị trí lưu ảnh
Ảnh sản phẩm cần được lưu trong thư mục:
```
storage/app/public/images/
```

### 2. Cách copy ảnh vào đúng vị trí

**Cách 1: Copy thủ công**
- Copy các file ảnh (giay1.jpg, giay2.jpg, ...) vào thư mục:
  - `storage/app/public/images/`

**Cách 2: Sử dụng script**
- Chạy file `copy-images-to-storage.ps1` đã được tạo sẵn

**Cách 3: Upload qua admin**
- Vào trang admin, chỉnh sửa sản phẩm và upload ảnh mới
- Ảnh sẽ tự động được lưu vào đúng vị trí

### 3. Kiểm tra
- Truy cập: `http://your-domain/storage/images/giay1.jpg`
- Nếu hiển thị được thì đã đúng

### 4. Lưu ý
- Đảm bảo đã chạy lệnh: `php artisan storage:link`
- Symbolic link đã được tạo từ `public/storage` đến `storage/app/public`
