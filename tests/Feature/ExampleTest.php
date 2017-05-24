<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function testCorrectTrueAssertControl()
    {
        $this->assertTrue(true);
    }
    public function testCorrectFalseAssertControl()
    {
        $this->assertFalse(false);
    }
    public function testIncorrectTrueAssertControl()
    {
        $this->assertTrue(false);
    }
    public function testIncorrectFalseAssertControl()
    {
        $this->assertFalse(true);
    }


}
