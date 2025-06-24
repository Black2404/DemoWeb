<?php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminViewOrderDetailTest extends TestCase
{

    public function test_admin_can_view_order_detail()
    {
        $admin = User::where('email', 'admin@gmail.com')->first();
        $this->actingAs($admin);

        $response = $this->get('/admin/manageo/9');

        #kiểm tra các nội dung hiện ra
        $response->assertStatus(200);
        $response->assertSee('Chi tiết đơn hàng'); 
        $response->assertSee('Khách hàng');   
        $response->assertSee('Tổng tiền');         
        $response->assertSee('Trạng thái');             
    }
}
