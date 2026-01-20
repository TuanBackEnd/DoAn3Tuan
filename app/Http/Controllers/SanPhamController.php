public function show($id)
{
    $sanPham = SanPham::findOrFail($id);
    return view('sanpham.chitiet', compact('sanPham'));
}