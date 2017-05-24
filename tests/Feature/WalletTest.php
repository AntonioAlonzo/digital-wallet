<?php

namespace Tests\Feature;

use App\Wallet;
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

}
