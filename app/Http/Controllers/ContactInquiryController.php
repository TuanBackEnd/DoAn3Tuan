<?php

namespace App\Http\Controllers;
use App\Models\ContactInquiry;

use Illuminate\Http\Request;

class ContactInquiryController extends Controller
    {
    public function showInquiries()
    {
        $inquiries = ContactInquiry::all(); // Retrieve all contact inquiries
        return view('admin.yeucaukhachhang.index', compact('inquiries'));
    }

    public function destroy(ContactInquiry $inquiry)
    {
        // Delete the inquiry
        $inquiry->delete();

        // Redirect with success message
        return redirect()->route('contact.inquiries')->with('success', 'Liên hệ đã được xóa.');
    }
}
