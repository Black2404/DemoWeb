<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{
    public function index1()
    {
    $books = Book::whereIn('id', [1, 4, 3])->get();
    foreach ($books as $book) {
        $book->formatted_price = number_format($book->price, 0, ',', '.');
    }
    return view('user/dashboard', compact('books'));
    }
    public function index2()
    {
    $books = Book::whereIn('id', [1, 4, 3])->get();
    foreach ($books as $book) {
        $book->formatted_price = number_format($book->price, 0, ',', '.');
    }
    return view('home', compact('books'));
    }
    public function index3(Request $request)
    {
    $search = $request->get('search');

    $books = Book::when($search, function ($query, $search) {
        return $query->where('title', 'like', "%{$search}%")
                     ->orWhere('author', 'like', "%{$search}%");
    })->paginate(8);

    foreach ($books as $book) {
        $book->formatted_price = number_format($book->price, 0, ',', '.');
    }
    
    return view('books', compact('books'));
    }

    public function index4(Request $request)
    {
    $search = $request->get('search');

    $books = Book::when($search, function ($query, $search) {
        return $query->where('title', 'like', "%{$search}%")
                     ->orWhere('author', 'like', "%{$search}%");
    })->paginate(8);

    foreach ($books as $book) {
        $book->formatted_price = number_format($book->price, 0, ',', '.');
    }
    
    return view('user/books', compact('books'));
    }

    public function index5()
    {
        $books = Book::paginate(5);
        return view('admin.manageb', compact('books'));
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'author' => 'required',
        'publisher' => 'required',
        'price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imageName = null;
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $imageName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images'), $imageName);
    }

    Book::create([
        'title' => $request->title,
        'author' => $request->author,
        'publisher' => $request->publisher,
        'price' => $request->price,
        'image' => $imageName, // Lưu tên file vào DB (nếu có)
    ]);

    return redirect()->route('admin.manageb.index5')->with('success', 'Thêm sách thành công!');
}

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('admin.editb', compact('book'));
    }

    public function update(Request $request, $id)
{
    // Tìm sách theo ID
    $book = Book::findOrFail($id);

    // Validate dữ liệu đầu vào
    $data = $request->validate([
        'title' => 'required',
        'author' => 'required',
        'price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'publisher' => 'nullable|string',
    ]);

    // Kiểm tra nếu có ảnh mới được tải lên
    if ($request->hasFile('image')) {
        // Xóa ảnh cũ nếu tồn tại
        if (!empty($book->image) && file_exists(public_path('images/' . $book->image))) {
            unlink(public_path('images/' . $book->image));
        }

        // Lưu ảnh mới
        $file = $request->file('image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);

        // Gán tên file ảnh mới vào $data để cập nhật
        $data['image'] = $filename;
    }

    // Cập nhật thông tin sách
    $book->update($data);

    return redirect()->route('admin.manageb.index5')->with('success', 'Sách đã được cập nhật thành công!');
}

public function destroy($id)
{
    $book = Book::findOrFail($id);

    // Xóa luôn file ảnh trong thư mục public/images (nếu cần)
    $imagePath = public_path('images/' . $book->image);
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    $book->delete();

    return redirect()->route('admin.manageb.index5')->with('success', 'Xóa sách thành công!');
}


    public function show($id)
    {
        $book = Book::findOrFail($id);
        $reviews = Review::where('book_id', $id)->get();
        return view('show', compact('book', 'reviews'));
    }

    public function userShow($id)
    {
        $book = Book::findOrFail($id);
        $reviews = Review::where('book_id', $id)->get();
        return view('user.show', compact('book', 'reviews'));
    }
}

    
    






