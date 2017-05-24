<?php

namespace Tests\Feature;

use App\Wallet;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WalletTest extends TestCase
{

    public function testWalletGetListSuccess(){
        $url = '/api/v1/wallets';
        $statusExpect=200;
        // Test authenticated access.
        $response=$this->get($url, $this->headers(User::first()));

        $response->assertStatus($statusExpect);
    }
    public function testWalletGetDetailSuccess(){
        $url = '/api/v1/wallets/1';
        $statusExpect=200;
        // Test authenticated access.
        $response=$this->get($url, $this->headers(User::first()));

        $response->assertStatus($statusExpect);
    }
    public function testWalletCreateSuccess(){
        $url = '/api/v1/wallets';
        $statusExpect=200;
        $wallet=array(
            'name'=> "prueba",
        );
        // Test authenticated access.
        $response=$this->post($url, $this->headers(User::first()),$wallet);

        $response->assertStatus($statusExpect);
    }
    public function testWalletUpdateSuccess(){
        $url = '/api/v1/categories/1';
        $statusExpect=200;
        // Test authenticated access.
        $response=$this->get($url, $this->headers(User::first()));

        $response->assertStatus($statusExpect);
    }
    public function testWalletDeleteSuccess(){
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


}
