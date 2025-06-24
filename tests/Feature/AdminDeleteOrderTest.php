<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminDeleteOrderTest extends TestCase
{

    public function test_admin_can_delete_temp_order()
    {
        // Lấy admin và user đã có sẵn trong DB
        $admin = User::where('email', 'admin@gmail.com')->first();
        $user = User::where('email', 'user1@gmail.com')->first();
        $this->assertNotNull($admin, 'Admin chưa tồn tại trong DB');

        // Tạo đơn hàng tạm thời gắn với user1
        $order = Order::create([
            'user_id' => $user->id, 
            'total_price' => 150000,
            'status' => 'pending',
            'name' => 'Nguyễn Test',
            'address' => '123 Test Street',
            'customer_name' => 'Nguyễn Test',
        ]);
        // Đăng nhập với admin
        $this->actingAs($admin);
        // Gửi DELETE request để xóa đơn hàng vừa tạo
        $response = $this->delete("/admin/manageo/{$order->id}");
        // Kiểm tra redirect về trang quản lý đơn
        $response->assertRedirect('/admin/manageo');
        // Kiểm tra đơn hàng không còn trong DB
        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
        ]);
    }
}
