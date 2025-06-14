<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;

class BookSearchTest extends TestCase
{
    

    public function test_search_book_by_title()
    {

        // Gửi request tìm kiếm
        $response = $this->get('/books?search=Đắc+nhân+tâm');

        // Kiểm tra nội dung kết quả tìm kiếm
        $response->assertStatus(200);
        $response->assertSee('Đắc nhân tâm');
    }
}
