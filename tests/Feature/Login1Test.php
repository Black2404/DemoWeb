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

        $user = User::where('email', 'userx@gmail.com')->first();
    
        $this->assertNotNull($user,'User X không tồn tại trong database');
        $this->actingAs($user);

        $response = $this->post('/login', [
            'email' => 'userx@gmail.com',
            'password' => '112233',
        ]);
        $this->assertAuthenticated();

        // Kiểm tra có chuyển hướng đến trang đăng nhập
        $response->assertRedirect('/user/dashboard');

    }
}


