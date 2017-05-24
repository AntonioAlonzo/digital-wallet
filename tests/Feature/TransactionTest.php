<?php
/**
 * Created by PhpStorm.
 * User: MiguelAngel
 * Date: 24/05/2017
 * Time: 03:21 PM
 */

namespace Tests\Feature;

use App\Transaction;
use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TransactionTest extends TestCase
{

    use DatabaseTransactions;

    public function testTransactionListSuccess(){
        $url = '/api/v1/transactions';
        $statusExpect=200;

        // Test authenticated access.
        $response=$this->get($url, $this->headers(User::first()));
        $response->assertStatus($statusExpect);
    }

    public function testTransactionGetDetailSuccess(){

        $url = '/api/v1/transactions/2';
        $statusExpect=200;
        // Test authenticated access.
        $response=$this->get($url, $this->headers(User::first()));
        $response->assertStatus($statusExpect);
    }

    public function testTransactionDeleteSuccess(){
        $url = '/api/v1/transactions/1';
        $statusExpect=200;
        // Test authenticated access.
        $response=$this->delete($url, $this->headers(User::first()));
        $response->assertStatus($statusExpect);
    }

    public function testTransactionListFail(){

        $url = '/api/v1/transactions';
        $statusExpect=400;

        // Test unauthenticated access.

        $response=$this->get($url, $this->headers());
        $response->assertStatus($statusExpect);
    }

    public function testTransactionGetDetailFail(){

        $url = '/api/v1/transactions/1';
        $statusExpect=400;

        // Test unauthenticated access.
        $response=$this->get($url, $this->headers());
        $response->assertStatus($statusExpect);

    }

    public function testTransactionDeleteFail(){
        $url = '/api/v1/transactions/1';
        $statusExpect=200;
        // Test authenticated access.
        $response=$this->get($url, $this->headers());
        $response->assertStatus($statusExpect);
    }
    

}
