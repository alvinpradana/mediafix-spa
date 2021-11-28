<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function landing_page_berhasil_diakses()
    {
        $this->get('/')->assertStatus(200);
    }

    /** @test */
    public function landing_page_invoice_information_berhasil_diakses()
    {
        $stripe_token = [
            'stripe_token' => ''
        ];
        
        $response = $this->get('invoice', $stripe_token);

        $response->assertStatus(200);
    }    
}
