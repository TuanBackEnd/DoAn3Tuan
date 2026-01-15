<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    public function index()
    {
        $contactInfo = ContactInfo::first(); // Retrieve the first (or only) record from the database
        return view('admin.contact.index', compact('contactInfo'));
    }

    public function update(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'ten_cua_hang' => 'required|string|max:255',   // Tên cửa hàng: bắt buộc, chuỗi, tối đa 255 ký tự
            'dia_chi' => 'required|string|max:255',         // Địa chỉ: bắt buộc, chuỗi, tối đa 255 ký tự
            'so_dien_thoai' => 'required|string|max:20',    // Số điện thoại: bắt buộc, chuỗi, tối đa 20 ký tự
            'email' => 'required|email',                     // Email: bắt buộc, phải đúng định dạng email
            'fax' => 'nullable|string|max:20',               // Fax: không bắt buộc, chuỗi, tối đa 20 ký tự
            'gio_lam_viec' => 'required|string|max:255',     // Giờ làm việc: bắt buộc, chuỗi, tối đa 255 ký tự
            'link_mang_xa_hoi' => 'nullable|string|max:255', // Liên kết mạng xã hội: không bắt buộc, chuỗi, tối đa 255 ký tự
            'ban_do' => 'nullable|string',                   // Bản đồ: không bắt buộc, chuỗi
        ]);

        // Update the contact info (assuming there's only one row in the database)
        $contactInfo = ContactInfo::first();
        $contactInfo->update($validated);

        return redirect()->back()->with('success', 'Thông tin liên hệ đã được cập nhật.');
    }
}
