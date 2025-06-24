<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminDeleteUserTest extends TestCase
{

    public function test_admin_can_delete_user()
    {
        // Tạo hoặc lấy admin
        $admin = User::where('email', 'admin@gmail.com')->first();

        // Xóa trước nếu user tồn tại
        User::where('email', 'user8@gmail.com')->delete();

        // Tạo user cần xóa
        $user = User::create([
            'name' => 'User Test',
            'email' => 'user8@gmail.com',
            'password' => bcrypt('password'),
        ]);

        // Đăng nhập với tư cách admin
        $this->actingAs($admin);

        // Gửi request DELETE đúng route
        $response = $this->delete("/admin/manageu/{$user->id}");

        // Kiểm tra phản hồi
        $response->assertStatus(302); // Hoặc 200 nếu bạn trả về JSON hoặc không redirect

        // Kiểm tra user đã bị xóa khỏi DB
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
