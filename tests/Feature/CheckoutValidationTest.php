<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;

class CheckoutValidationTest extends TestCase
{
    public function test_checkout_fails_when_required_fields_are_missing()
    {
        //Lấy user và đăng nhập
        $user = User::where('email', 'user4@gmail.com')->first();
        $this->assertNotNull($user, 'User không tồn tại');
        $this->actingAs($user);
        //Lấy sách "Start up"
        $book = Book::where('title', 'Start up')->first();
        $this->assertNotNull($book, 'Sách "Start up" không tồn tại');
        //Thêm sách vào giỏ hàng
        $responseAdd = $this->post("/user/cart/add/{$book->id}");
        $responseAdd->assertRedirect();
        //Gửi yêu cầu thanh toán thiếu dữ liệu
        $responseCheckout = $this->post('/user/checkout/process', [
            // bỏ trống để kiểm tra lỗi
        ]);
        //Kiểm tra lỗi validation
        $responseCheckout->assertSessionHasErrors(['customer_name', 'address']);

    }
}
