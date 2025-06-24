<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUpdateOrderStatusTest extends TestCase
{

    public function test_admin_can_update_order_status_existing_order()
    {
        // Lấy admin từ dữ liệu có sẵn
        $admin = User::where('email', 'admin@gmail.com')->first();
        $this->actingAs($admin);

        // Gửi request PUT để đổi trạng thái đơn hàng ID = 10 thành "shipped"
        $response = $this->put('/admin/manageo/10', [
            'status' => 'shipped',
        ]);

        // Kiểm tra có chuyển hướng 
        $response->assertRedirect();

        // Kiểm tra trong database trạng thái đã được cập nhật
        $this->assertDatabaseHas('orders', [
            'id' => 10,
            'status' => 'shipped',
        ]);
    }
}
