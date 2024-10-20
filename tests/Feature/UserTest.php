<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function test_register()
    {
        Artisan::call("migrate");

        $responseCharge = $this->get(route("register"));
        $responseCharge->assertStatus(200);
    }
}
