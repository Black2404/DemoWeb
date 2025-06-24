<?php

namespace Tests\Feature;

use Tests\TestCase;

class BookSearch1Test extends TestCase
{
    public function test_search_book_not_found()
{
    $response = $this->get('/books?search=Sách+123');

    $response->assertStatus(200);
    $response->assertSee('Không tìm thấy sách'); 
}

}
