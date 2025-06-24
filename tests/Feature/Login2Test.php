<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class Login2Test extends TestCase
{

    public function test_reload_login_page_when_password_is_wrong()
    {

        // Gửi POST request với mật khẩu sai
        $response = $this->from('/login')->post('/login', [
            'email' => 'userx@gmail.com',
            'password' => bcrypt('123123'),
        ]);

        // Hệ thống redirect lại trang login
        $response->assertRedirect('/login');

        // Đảm bảo chưa đăng nhập
        $this->assertGuest();
    }
}


