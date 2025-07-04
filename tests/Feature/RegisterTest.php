<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;



class RegisterTest extends TestCase
{
    public function testRegisterWithExistingEmail()
{

    $response = $this->post('/register', [
        'name' => 'User X',
        'email' => 'userx@gmail.com',
        'password' => '112233',
    ]);
    $response->assertSessionHasErrors(['email']);
    $this->assertStringContainsString(
        'The email has already been taken',
        session('errors')->first('email')
    );
}


}
