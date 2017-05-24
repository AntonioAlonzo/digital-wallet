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
//'name', 'description', 'reportable',
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreatesWallet()
    {
        /*
        $walletAttributes = [
            'name' => 'name test',
            'description'    => 'description test',
            'reportable' => false,
        ];

        $walletCreated=Wallet::create($walletAttributes);
        $this->assertEquals($walletCreated->name,$walletAttributes->name);
        $this->assertEquals($walletCreated->description,$walletAttributes->description);
        */
    }
    public function testWalletGetDetailSuccess(){
        $url = '/api/v1/wallets/1';
        $statusExpect=200;
        // Test authenticated access.
        $response=$this->get($url, $this->headers(User::first()));

        $response->assertStatus($statusExpect);
    }
    public function testWalletCreateSuccess(){
        $url = '/api/v1/wallets?name=miguel';
        $statusExpect=201;
        $wallet=array(
            'name'=> "prueba",
            'description'=>"prueba"
        );
        // Test authenticated access.
        $response=$this->post($url, $this->headers(User::first()));

        $response->assertStatus($statusExpect);
    }
    public function testWalletUpdateSuccess(){
        $url = '/api/v1/wallets/1';
        $statusExpect=200;
        // Test authenticated access.
        $response=$this->get($url, $this->headers(User::first()));

        $response->assertStatus($statusExpect);
    }
    public function testWalletDeleteSuccess(){
        $url = '/api/v1/wallets/1';
        $statusExpect=200;
        // Test authenticated access.
        $response=$this->get($url, $this->headers(User::first()));

        $response->assertStatus($statusExpect);
    }

    public function testWalletListFail(){

        $url = '/api/v1/wallets';
        $statusExpect=400;
        // Test unauthenticated access.
        $response=$this->get($url, $this->headers());

        $response->assertStatus($statusExpect);
    }

    public function testWalletCreateFail(){
        $url = '/api/v1/wallets';
        $statusExpect=400;
        $wallet=array(
            'name'=> "prueba",
            'description'=>"prueba"
        );
        // Test authenticated access.
        $response=$this->post($url, $this->headers(),$wallet);

        $response->assertStatus($statusExpect);
    }


}
