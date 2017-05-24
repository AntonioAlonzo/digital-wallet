<?php
/**
 * Created by PhpStorm.
 * User: MiguelAngel
 * Date: 24/05/2017
 * Time: 06:14 PM
 */

namespace Tests\Feature;

use App\Transfer;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TransferTest extends TestCase
{
    use DatabaseTransactions;


    public function testTransfersListSuccess(){

        $url = '/api/v1/transfers';
        $statusExpect=200;

        // Test authenticated access.
        $response=$this->get($url, $this->headers(User::first()));
        $response->assertStatus($statusExpect);
    }

    public function testTransfersDetailSuccess(){

        $url = '/api/v1/transfers/1';
        $statusExpect=200;

        // Test authenticated access.
        $response=$this->get($url, $this->headers(User::first()));
        $response->assertStatus($statusExpect);
    }


    public function testTransfersListFail(){

        $url = '/api/v1/transfers';
        $statusExpect=400;

        // Test authenticated access.
        $response=$this->get($url, $this->headers());
        $response->assertStatus($statusExpect);
    }

    public function testTransfersDetailFail(){

        $url = '/api/v1/transfers/1';
        $statusExpect=400;

        // Test authenticated access.
        $response=$this->get($url, $this->headers());
        $response->assertStatus($statusExpect);
    }
}
