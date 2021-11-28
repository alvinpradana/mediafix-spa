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
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->withExceptionHandling();
        $response = $this->get('dashboard');

        $response->assertStatus(200);
    }
}
