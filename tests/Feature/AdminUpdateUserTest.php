<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminUpdateUserTest extends TestCase
{
    public function test_admin_can_update_user_info()
    {
        // Lấy admin và user từ CSDL thật
        $admin = User::where('email', 'admin@gmail.com')->first();
        $user = User::where('email', 'user4@gmail.com')->first();
        // Kiểm tra tồn tại
        $this->assertNotNull($admin, 'Admin user không tồn tại trong CSDL');
        $this->assertNotNull($user, 'User cần cập nhật không tồn tại trong CSDL');
        // Đăng nhập với admin
        $this->actingAs($admin);
        // Gửi PUT request cập nhật user
        $response = $this->put("/admin/manageu/{$user->id}", [
            'name' => 'User 20 Mới',
            'email' => $user->email, 
        ]);
        // Kiểm tra chuyển hướng
        $response->assertRedirect('/admin/manageu');
        // Kiểm tra trong database
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'User 20 Mới',
        ]);
    }
}
