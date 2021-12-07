<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function dashboard_berhasil_diakses_jika_user_sudah_login()
    {
        $this->withExceptionHandling();

        $user = User::factory()->create(); 

        $this->actingAs($user);

        $response = $this->get('dashboard');

        $response->assertStatus(200);
    }

    /** @test */
    public function user_redirect_ke_halaman_login_jika_login_gagal()
    {
        $response = $this->get('dashboard');

        $response->assertRedirect(route('login'));
    }
}
