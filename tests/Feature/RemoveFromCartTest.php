<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;

class RemoveFromCartTest extends TestCase
{

    public function test_user_can_remove_book_from_cart()
    {
        $user = \App\Models\User::create([
            'name' => 'User 19',
            'email' => 'user19@gmail.com',
            'password' => bcrypt('password123'),
        ]);
        $this->actingAs($user);

        // Đảm bảo sách "Hoàng tử bé" tồn tại
        $book = Book::where('title', 'Hoàng tử bé')->first();
        $this->assertNotNull($book, 'Book not found');

        // Thêm sách vào giỏ hàng
        $this->post('user/cart/add/' . $book->id);

        $cartPage = $this->get('user/cart');
        $cartPage->assertSee('Hoàng tử bé');

        // Gửi request xóa sách khỏi giỏ
        $this->delete('/cart/remove/{cartId}' . $book->id);

        // Kiểm tra sách không còn trong giỏ hàng
        $cartPageAfter = $this->get('user/cart');
        $cartPageAfter->assertDontSee('Hoàng tử bé');
    }
}
