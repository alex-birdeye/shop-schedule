<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShopScheduleTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function isShopOpenedTest()
    {
        $response = $this->get('/api/is-opened');

        $response->assertStatus(200);
        $response->assertExactJson(['is_opened' => true]);
    }

    /**
     * @test
     */
    public function shopSettingsPageTest()
    {
        $response = $this->get('/shop-settings');

        $response->assertStatus(200);
        $response->assertSeeText('Shop settings');
    }

    /**
     * @test
     */
    public function getShopSettingsTest()
    {
        $response = $this->get('/api/settings');

        $response->assertStatus(200);
        $response->assertJson(['working_days' => []]);
    }
}
