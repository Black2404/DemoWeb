<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;

class SubmitBookReviewTest extends TestCase
{
    public function test_logged_in_user_can_submit_review()
    {
        // Lấy user đã có
        $user = User::where('email', 'user1@gmail.com')->first();
        $this->assertNotNull($user);
        // Lấy sách đã có
        $book = Book::where('title', 'Hoàng tử bé')->first();
        $this->assertNotNull($book);
        // Đăng nhập
        $this->actingAs($user);
        // Gửi đánh giá
        $response = $this->post("/user/books/{$book->id}/review", [
            'rating' => 5,
            'comment' => 'Cuốn sách rất hay và truyền cảm hứng!',
        ]);
        // Kiểm tra redirect
        $response->assertRedirect();
        // Kiểm tra có lưu vào DB
        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'rating' => 5,
            'comment' => 'Cuốn sách rất hay và truyền cảm hứng!',
        ]);
    }
}
