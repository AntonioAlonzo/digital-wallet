<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{

 use DatabaseTransactions;

 public function testCorrectIndex(){
     //this->client->request('GET','categories');
     $response=$this->call('GET','categories');

     $this->assertEquals('200', $response->foundation->getStatusCode());

 }


}
