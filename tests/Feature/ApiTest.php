<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    public function testPropertyCreation()
    {
        $response = $this->postJson('/api/properties', [
            'suburb'    => 'Parramatta',
            'state'     => 'NSW',
            'country'   => 'Australia'
        ])->assertStatus(200);
    }

    public function testAnalyticCreationFail()
    {
        $response = $this->postJson('/api/properties/10000/', [
            'analytic_type_id'  => 1,
            'value'             => 40
        ])->assertStatus(404);
    }

    public function testAnalyticCreation()
    {
        $response = $this->postJson('/api/properties/101/', [
            'analytic_type_id'  => 1,
            'value'             => 40
        ])->assertStatus(200);
    }

    public function testGettingPropertyAnalytics()
    {
        $response = $this->getJson('/api/properties/101/')->assertStatus(200);
    }


    public function testGettingSummaryAnalyticsByRuburb()
    {
        $response = $this->getJson('/api/summary/suburb/Parramatta/')->assertStatus(200);
    }

    public function testGettingSummaryAnalyticsByState()
    {
        $response = $this->getJson('/api/summary/state/NSW/')->assertStatus(200);
    }


    public function testGettingSummaryAnalyticsByCountry()
    {
        $response = $this->getJson('/api/summary/country/Australia/')->assertStatus(200);
    }
}
