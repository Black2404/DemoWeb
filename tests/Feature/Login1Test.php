<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class Login1Test extends TestCase
{
    public function test_user_can_login_with_valid_credentials()
    {

        $user = User::create([
            'name' => 'User X',
            'email' => 'userx@gmail.com',
            'password' => bcrypt('112233'),
        ]);
        $response = $this->post('/login', [
            'email' => 'userx@gmail.com',
            'password' => '112233',
        ]);
        $this->assertAuthenticated();

        // Kiểm tra có chuyển hướng đến trang đăng nhập
        $response->assertRedirect('/user/dashboard');

    }
}


