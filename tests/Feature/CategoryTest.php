<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{

 use DatabaseTransactions;

    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function testStatusIndex()
    {
        $response = $this->get('api/v1/categories');
        $response->assertStatus(200);
    }
    public function testStatusIndex2()
    {
        $response = $this->get('categories');
        $response->assertStatus(200);
    }


 public function testCategoryGetDetails(){

 }


}
