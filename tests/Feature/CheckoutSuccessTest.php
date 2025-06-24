<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class CheckoutSuccessTest extends TestCase
{
    public function test_user_can_checkout_successfully()
    {
        //Lấy user và đăng nhập
        $user = User::where('email', 'user1@gmail.com')->first();
        $this->assertNotNull($user, 'User không tồn tại');
        $this->actingAs($user);
        //Lấy sách "Đắc nhân tâm"
        $book = Book::where('title', 'Đắc nhân tâm')->first();
        $this->assertNotNull($book, 'Sách "Đắc nhân tâm" không tồn tại');
        //Thêm sách vào giỏ hàng
        $responseAdd = $this->post("/user/cart/add/{$book->id}");
        $responseAdd->assertRedirect();
        //Gửi yêu cầu thanh toán
        $responseCheckout = $this->post('/user/checkout/process', [
            'address' => '04 Nguyễn Xí, Quận 1, TP.HCM',
            'customer_name' => 'User 1',
        ]);
        // Kiểm tra redirect và thông báo
        $responseCheckout->assertRedirect();
        $responseCheckout->assertSessionHas('success', 'Thanh toán thành công! Đơn hàng của bạn đã được ghi nhận.');
        // Giỏ hàng trống
        $cartItems = DB::table('cart')->where('user_id', $user->id)->get();
        $this->assertCount(0, $cartItems, 'Giỏ hàng chưa được xóa sau thanh toán');
        // Kiểm tra đơn hàng tồn tại 
        $this->assertDatabaseHas('orders', [
            'total_price' => $book->price,
        ]);
    }
}
