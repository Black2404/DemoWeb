<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;

class AddToCartTest extends TestCase
{
    

    public function test_user_can_add_book_to_cart()
    {
        $user = \App\Models\User::create([
            'name' => 'User 15',
            'email' => 'user15@gmail.com',
            'password' => bcrypt('password123'),
        ]);
        

        $this->actingAs($user); // Đăng nhập

        $book = Book::where('title', 'Hoàng tử bé')->first();
        // Gửi request thêm vào giỏ (giả sử route là /cart/add/{id})
        $response = $this->post('user/cart/add/' . $book->id);

        $response->assertRedirect(); // hoặc kiểm tra status tùy flow app


        // Mở trang giỏ hàng và kiểm tra
        $cartPage = $this->get('user/cart');

        $cartPage->assertStatus(200);
        $cartPage->assertSee('Hoàng tử bé');
        $cartPage->assertSee('1'); // số lượng mặc định
        $cartPage->assertSee('120.000 VNĐ'); // giá
    }
}
