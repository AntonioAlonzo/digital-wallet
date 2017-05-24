<?php
/**
 * Created by PhpStorm.
 * User: MiguelAngel
 * Date: 24/05/2017
 * Time: 03:21 PM
 */

namespace Tests\Feature;

use App\Transaction;

class TransactionTest extends \PHPUnit_Framework_TestCase
{

    public function testListTransactionsSuccess(){

        $url = '/api/v1/transactions';
        $statusExpect=200;

        // Test authenticated access.
        $response=$this->get($url, $this->headers(User::first()));
        $response->assertStatus($statusExpect);
    }

    public function testTransactionGetDetailSuccess(){

        $url = '/api/v1/transactions/1';
        $statusExpect=200;
        // Test authenticated access.
        $response=$this->get($url, $this->headers(User::first()));
        $response->assertStatus($statusExpect);
    }


    public function testCategoryListFail(){

        $url = '/api/v1/transactions';
        $statusExpect=400;

        // Test unauthenticated access.

        $response=$this->get($url, $this->headers());
        $response->assertStatus($statusExpect);
    }
    public function testCategoryGetDetailFail(){

        $url = '/api/v1/transactions/1';
        $statusExpect=400;

        // Test unauthenticated access.
        $response=$this->get($url, $this->headers());
        $response->assertStatus($statusExpect);
    }

}
