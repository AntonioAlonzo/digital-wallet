<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Http\Request;
use Tests\TestCase;
use Response;
use JWTAuth;
use App\Http\Requests\Authenticate;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{

 use DatabaseTransactions;


 public function testCategoryListSuccess(){

     $url = '/api/v1/categories';
     $statusExpect=200;

      // Test authenticated access.
     $response=$this->get($url, $this->headers(User::first()));
         $response->assertStatus($statusExpect);
 }
    public function testCategoryGetDetailSuccess(){

        $url = '/api/v1/categories/1';
        $statusExpect=200;
        // Test authenticated access.
        $response=$this->get($url, $this->headers(User::first()));

        $response->assertStatus($statusExpect);
    }

    public function testCategoryListFail(){

        $url = '/api/v1/categories';
        $statusExpect=400;
        // Test unauthenticated access.
        $response=$this->get($url, $this->headers());

        $response->assertStatus($statusExpect);
    }

    public function testCategoryGetDetailFail(){

        $url = '/api/v1/categories/1';
        $statusExpect=400;

        // Test unauthenticated access.
       $response=$this->get($url, $this->headers());
        $response->assertStatus($statusExpect);
    }

}
