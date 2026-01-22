<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Phương thức xem tất cả bình luận
    public function index(Request $request)
    {
        // Lấy tất cả bình luận cùng với thông tin khách hàng và sản phẩm
        $comments = Comment::with(['customer', 'product'])->get();
        
        // Trả về view với biến $comments
        return view('admin.comment.index', compact('comments'));
    }
   
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:5000', // Validation for comment content
        ]);

        $comment = Comment::findOrFail($id);
        $comment->content = $request->input('content');
        $comment->save();

        return redirect()->route('comment.index')->with('success', 'Comment updated successfully.');
    }
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->route('comments.index')->with('success', 'Bình luận đã được xóa thành công.');
    }
        


}