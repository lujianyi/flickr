<?php


class SearchTest extends TestCase
{

    protected $testUrl = '/photos/search?text=plane';

    public function testRoute()
    {
        $response = $this->call('GET', $this->testUrl);
        $this->assertEquals(200, $response->status());
    }

    public function testBindingData()
    {
        $this->call('GET', $this->testUrl);
        $this->assertViewHasAll(['photoList', 'url']);
    }

    public function testPageSearch()
    {
        $this->visit($this->testUrl)
            ->seeElement('header', ['id' => 'nav-bar'])
            ->seeElement('div', ['id' => 'breadcrumb'])
            ->see('Results')
            ->see('photos found.')
            ->seeElement('ul', ['class' => 'pagination'])
            ->seeElement('table', ['class' => 'table table-striped table-bordered'])
            ->see('Id')
            ->see('Title')
            ->seeElement('span', ['class' => 'glyphicon glyphicon-eye-open'])
            ->see('Designed and built by Jianyi (Jerry) LU');
    }

    public function testHomeLinkForLogo()
    {
        $this->visit($this->testUrl)
            ->click('Flickr Search')
            ->seePageIs('/');
    }

    public function testHomeLinkForNav()
    {
        $this->visit($this->testUrl)
            ->click('Home')
            ->seePageIs('/');
    }

}