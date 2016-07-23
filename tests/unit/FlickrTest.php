<?php

use App\Flickr\Flickr;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FlickrTest extends TestCase
{
    protected $flickr;

    public function setUp(){
        $this->flickr = new Flickr();
    }

    public function testPhotoListReturnCodeMinusOneWhenTextIsEmpty(){
        $res = $this->flickr->getPhotoList(null, 1);
        $this->assertEquals('-1', $res['code']);
    }

    public function testPhotoListReturnCodeOneWhenTextIsNotEmpty(){
        $res = $this->flickr->getPhotoList('ship', 1);
        $this->assertEquals(1, $res['code']);
    }

    public function testPhotoInfoReturnCodeMinusOneWhenIdIsEmpty(){
        $res = $this->flickr->getPhotoInfo(null);
        $this->assertEquals('-1', $res['code']);
    }

    public function testPhotoInfoReturnPhotoInfoById(){
        $res = $this->flickr->getPhotoInfo(28454417696);
        $this->assertEquals('1ebfedf07e', $res['photo']->secret);
    }

    public function testPhotoSizeReturnCodeMinusOneWhenIdIsEmpty(){
        $res = $this->flickr->getPhoto(null);
        $this->assertEquals('-1', $res['code']);
    }

    public function testPhotoSizeReturnPhotoById(){
        $res = $this->flickr->getPhoto(28454417696);
        $this->assertEquals('photo', $res['photo']->media);
    }

}