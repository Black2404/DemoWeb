<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReviewValidationTest extends TestCase
{
    public function test_user_cannot_submit_empty_review()
    {
        // Lấy user có sẵn trong DB
        $user = User::where('email', 'user1@gmail.com')->first();
        $this->assertNotNull($user, 'User user1@gmail.com không tồn tại');
        // ID sách "Nhật kí cha và con" 
        $bookId = 4; 

        // Đăng nhập
        $this->actingAs($user);
        // Gửi đánh giá trống
        $response = $this->post("/user/books/{$bookId}/review", [
            'rating' => '',
            'comment' => '',
        ]);
        // Kiểm tra redirect lại do lỗi
        $response->assertRedirect();
        // Kiểm tra lỗi validate
        $response->assertSessionHasErrors(['rating', 'comment']);
    }
}
