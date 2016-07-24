<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IndexTest extends TestCase
{

    public function testRoute()
    {
        $response = $this->call('GET', '/');

        $this->assertEquals(200, $response->status());
    }

    public function testPageIndex()
    {
        $this->visit('/')
            ->seeElement('header', ['id' => 'nav-bar'])
            ->seeElement('form', ['class' => 'form-inline'])
            ->seeElement('label', ['for' => 'text'])
            ->see('Input text to search the photos')
            ->seeElement('input', ['type' => 'text', 'name' => 'text', 'placeholder' => 'search'])
            ->seeElement('button', ['type' => 'submit'])
            ->see('Search')
            ->seeElement('img', ['alt' => 'Flickr'])
            ->see('Designed and built by Jianyi (Jerry) LU');
    }

    public function testHomeLinkForLogo()
    {
        $this->visit('/')
            ->click('Flickr Search')
            ->seePageIs('/');
    }

    public function testHomeLinkForNav()
    {
        $this->visit('/')
            ->click('Home')
            ->seePageIs('/');
    }

    public function testSearchText()
    {
        $this->visit('/')
            ->type('plane', 'text')
            ->press('Search')
            ->seePageIs('/photos/search?text=plane');
    }

    public function testSearchValidation()
    {
        $this->visit('/')
            ->type('', 'text')
            ->press('Search')
            ->seePageIs('/')
            ->see('The field is required. Please input proper value.');
    }
}
