<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;

class AddToCartTest extends TestCase
{
    public function test_user17_can_add_book_to_cart()
    {
        // Tìm user1 đã tồn tại
        $user = User::where('email', 'user17@gmail.com')->first();
        $this->assertNotNull($user, 'User17 phải tồn tại.');

        // Đăng nhập
        $this->actingAs($user);

        // Tìm sách Hoàng tử bé
        $book = Book::where('title', 'Hoàng tử bé')->first();
        $this->assertNotNull($book, '"Hoàng tử bé" phải tồn tại');

        // Thêm sách vào giỏ
        $response = $this->post('user/cart/add/' . $book->id, ['quantity' => 0]);
        $response->assertRedirect(); 

        // Mở trang giỏ hàng
        $cartPage = $this->get('user/cart');

        $cartPage->assertStatus(200);
        $cartPage->assertSee('Hoàng tử bé');
        $cartPage->assertSee('1'); 
        $cartPage->assertSee('120.000 VNĐ'); 
    }
}
