<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RemoveFromCartTest extends TestCase
{
    public function test_user17_can_remove_book_from_cart()
    {
        // Lấy user17 đã tồn tại
        $user = User::where('email', 'user17@gmail.com')->first();
        $this->assertNotNull($user, 'User17 must exist.');
        // Lấy bản ghi giỏ hàng đầu tiên của user17
        $cartItem = DB::table('cart')
            ->where('user_id', $user->id)
            ->first();
        $this->assertNotNull($cartItem, 'User17 must have at least one item in cart.');
        // Đăng nhập
        $this->actingAs($user);
        // Gửi request xóa
        $response = $this->delete('/cart/remove/' . $cartItem->id);
        $response->assertRedirect(); 
        // Kiểm tra bản ghi đã bị xóa
        $this->assertDatabaseMissing('cart', [
            'id' => $cartItem->id
        ]);
    }
}
