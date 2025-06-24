<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class Register1Test extends TestCase
{

    public function test_user_can_register_successfully()
    {
        // Gửi request POST để đăng ký
        $response = $this->post('/register', [
            'name' => 'User Y',
            'email' => 'usery@gmail.com',
            'password' => '112233',
        ]);

        // Kiểm tra người dùng được chuyển hướng đến trang đăng nhập
        $response->assertRedirect('/login');

        // Kiểm tra dữ liệu đã lưu vào bảng users
        $this->assertDatabaseHas('users', [
            'email' => 'userx@gmail.com',
            'name' => 'User X',
        ]);
    }
}



