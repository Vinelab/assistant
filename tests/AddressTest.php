<?php

namespace Vinelab\Assistant\tests;

use Vinelab\Assistant\Address;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @author Charalampos Raftopoulos <harris@vinelab.com>
 */
class AddressTest extends TestCase
{
    public function setUp()
    {
        $this->ass = new Address();
    }

    public function testDomainWithOneLevelSubdomain()
    {
        $http = array('host' => 'api.najem.com');
        $this->assertEquals($this->ass->domain($http['host']), array('najem', array('api', 'najem', 'com')));
    }

    public function testDomainWithTwoLevelSubdomains()
    {
        $http = array('host' => 'test.api.najem.com');
        $this->assertEquals($this->ass->domain($http['host']), array('najem', array('test', 'api', 'najem', 'com')));
    }

    public function testDomainWithOneLevelDomain()
    {
        $http = array('host' => 'najem.com');
        $this->assertEquals($this->ass->domain($http['host']), array('najem', array('najem', 'com')));
    }

    public function testDomainWithTwoLevelDomains()
    {
        $http = array('host' => 'najem.co.uk');
        $this->assertEquals($this->ass->domain($http['host']), array('najem', array('najem', 'co', 'uk')));
    }

    public function testDomainWithOneLevelSubdomainAndOneLevelDomain()
    {
        $http = array('host' => 'api.najem.com');
        $this->assertEquals($this->ass->domain($http['host']), array('najem', array('api', 'najem', 'com')));
    }

    public function testDomainWithTwoLevelsSubdomainsAndOneLevelDomain()
    {
        $http = array('host' => 'test.api.najem.com');
        $this->assertEquals($this->ass->domain($http['host']), array('najem', array('test', 'api', 'najem', 'com')));
    }

    public function testDomainWithOneLevelSubdomainAndTwoLevelDomains()
    {
        $http = array('host' => 'api.najem.co.uk');
        $this->assertEquals($this->ass->domain($http['host']), array('najem', array('api', 'najem', 'co', 'uk')));
    }

    public function testDomainWithTwoLevelSubdomainsAndTwoLevelDomains()
    {
        $http = array('host' => 'test.api.najem.co.uk');
        $this->assertEquals($this->ass->domain($http['host']), array('najem', array('test', 'api', 'najem', 'co', 'uk')));
    }

    public function testOneLevelSubdomain()
    {
        $this->assertEquals($this->ass->subdomain('api.najem.com'), array('api'));
    }

    public function testTwoLevelSubdomains()
    {
        $this->assertEquals($this->ass->subdomain('stage.api.najem.com'), array('stage', 'api'));
    }

    public function testThreeLevelSubdomains()
    {
        $this->assertEquals($this->ass->subdomain('stage.api.trellis.vinelab.com'), array('stage', 'api', 'trellis'));
    }

    public function testOneLevelTld()
    {
        $this->assertEquals($this->ass->tld('api.najem.com'), array('com'));
    }

    public function testTwoLevelTld()
    {
        $this->assertEquals($this->ass->tld('api.najem.co.uk'), array('co', 'uk'));
    }

    public function testGetHostname()
    {
        $this->assertEquals($this->ass->hostname('api.najem.com:8000'), 'api.najem.com');
    }
}
