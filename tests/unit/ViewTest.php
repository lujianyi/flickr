<?php

class ViewTest extends TestCase
{
    protected $testUrl = '/photos/28454417696';
    protected $testErrorUrl = '/photos/28454417696111111';
    protected $testNonNumericUrl = '/photos/notanumber';

    public function testRoute()
    {
        $response = $this->call('GET', $this->testUrl);
        $this->assertEquals(200, $response->status());
    }

    public function testBindingData()
    {
        $this->call('GET', $this->testUrl);
        $this->assertViewHasAll(['photoInfo', 'photo']);
    }

    public function testPageView()
    {
        $this->visit($this->testUrl)
            ->seeElement('header', ['id' => 'nav-bar'])
            ->seeElement('div', ['id' => 'breadcrumb'])
            ->seeElement('table', ['class' => 'table table-striped table-bordered photo-info'])
            ->seeInElement('th', 'Title')
            ->seeInElement('td', 'bag')
            ->seeInElement('th', 'Description')
            ->seeInElement('td', 'This is a bug.')
            ->seeInElement('th', 'Owner')
            ->seeInElement('td', 'jerrylu_2006')
            ->seeInElement('th', 'Name')
            ->seeInElement('td', 'Jerry LU')
            ->seeInElement('th', 'Posted')
            ->seeInElement('td', '23/7/2016')
            ->seeElement('img', ['alt' => 'bag'])
            ->see('Designed and built by Jianyi (Jerry) LU');
    }

    public function testErrorUrlView()
    {
        $this->visit($this->testErrorUrl)
            ->seeInElement('h3', 'No result found')
            ->dontSeeElement('table', ['class' => 'table table-striped table-bordered photo-info']);
    }

    public function testNonNumericUrl()
    {
        $response = $this->call('GET', $this->testNonNumericUrl);
        $this->assertEquals(404, $response->status());
    }
}