<?php

namespace Hostville\Modulo\Tests;

use GuzzleHttp\Client;
use Hostville\Modulo\Exception\ModuloException;
use Hostville\Modulo\Manifest;
use Hostville\Modulo\Sdk;
use Hostville\Modulo\UrlRegistry;
use PHPUnit\Framework\TestCase;

class SdkTest extends TestCase
{
    /** @var Sdk */
    protected $sdk;

    public function setUp()
    {
        $this->sdk = new Sdk(['credentials' => ['id' => 1, 'secret' => 'fake-secret-code']]);
    }

    public function testCheckCredentialsFails()
    {
        $this->expectException(ModuloException::class);
        $sdk = new Sdk();
    }

    public function testCheckCredentialsPasses()
    {
        $this->assertInstanceOf(Sdk::class, $this->sdk);
    }

    public function testGetClientId()
    {
        $this->assertEquals(1, $this->sdk->getClientId());
    }

    public function testGetClientSecret()
    {
        $this->assertEquals('fake-secret-code', $this->sdk->getClientSecret());
    }

    public function testGetHttpClient()
    {
        $this->assertInstanceOf(Client::class, $this->sdk->getHttpClient());
    }

    public function testGetManifest()
    {
        $this->assertInstanceOf(Manifest::class, $this->sdk->getManifest());
        $this->assertNotEmpty($this->sdk->getManifest()->data());
    }

    public function testGetUrlRegistry()
    {
        $this->assertInstanceOf(UrlRegistry::class, $this->sdk->getUrlRegistry());
        $this->assertEquals(UrlRegistry::ENVIRONMENTS['staging'], (string) $this->sdk->getUrlRegistry()->getUrl());
    }

    public function testGetAuthorizationToken()
    {
        $this->assertEmpty($this->sdk->getAuthorizationToken());
    }

    public function testSetAuthorizationToken()
    {
        $this->sdk->setAuthorizationToken('fake-token-value');
        $this->assertEquals('fake-token-value', $this->sdk->getAuthorizationToken());
    }

    /**
     * @dataProvider resourceProvider
     */
    public function testCreateResource($name, $expected)
    {
        $method = 'create' . $name . 'Resource';
        $resource = $this->sdk->{$method}();
        $this->assertInstanceOf($expected, $resource);
    }

    public function resourceProvider()
    {
        return [
            ['Advert', \Hostville\Modulo\Resources\ECommerce\Advert::class],
            ['AppStore', \Hostville\Modulo\Resources\Developers\AppStore::class],
            ['Blog', \Hostville\Modulo\Resources\ECommerce\Blog::class],
            ['Company', \Hostville\Modulo\Resources\Company::class],
            ['Coupon', \Hostville\Modulo\Resources\Coupon::class],
            ['Country', \Hostville\Modulo\Resources\Common\Country::class],
            ['ContactField', \Hostville\Modulo\Resources\Crm\ContactField::class],
            ['Customer', \Hostville\Modulo\Resources\Crm\Customer::class],
            ['Deal', \Hostville\Modulo\Resources\Crm\Deal::class],
            ['Department', \Hostville\Modulo\Resources\Common\Company\Department::class],
            ['Developer', \Hostville\Modulo\Resources\Developers\Developer::class],
            ['DeveloperApplication', \Hostville\Modulo\Resources\Developers\Application::class],
            ['Directory', \Hostville\Modulo\Resources\Common\Directory::class],
            ['Domain', \Hostville\Modulo\Resources\ECommerce\Domain::class],
            ['Employee', \Hostville\Modulo\Resources\Common\Company\Employee::class],
            ['Finance', \Hostville\Modulo\Resources\Finance\Finance::class],
            ['Integration', \Hostville\Modulo\Resources\Common\Company\Integration::class],
            ['Invite', \Hostville\Modulo\Resources\Invite::class],
            ['Location', \Hostville\Modulo\Resources\Common\Company\Location::class],
            ['Order', \Hostville\Modulo\Resources\Invoicing\Order::class],
            ['Partner', \Hostville\Modulo\Resources\Partner::class],
            ['Plan', \Hostville\Modulo\Resources\Plan::class],
            ['Product', \Hostville\Modulo\Resources\Invoicing\Product::class],
            ['ProductCategory', \Hostville\Modulo\Resources\Invoicing\ProductCategory::class],
            ['State', \Hostville\Modulo\Resources\Common\State::class],
            ['Team', \Hostville\Modulo\Resources\Common\Company\Team::class],
            ['User', \Hostville\Modulo\Resources\Users\User::class]
        ];
    }

    /**
     * @dataProvider serviceProvider
     */
    public function testCreateService($name, $expected)
    {
        $method = 'create' . $name . 'Service';
        $resource = $this->sdk->{$method}();
        $this->assertInstanceOf($expected, $resource);
    }

    public function serviceProvider()
    {
        return [
            ['Authorization', \Hostville\Modulo\Services\Identity\Authorization::class],
            ['Company', \Hostville\Modulo\Services\Identity\Tenant::class],
            ['Metrics', \Hostville\Modulo\Services\Metrics::class],
            ['PasswordLogin', \Hostville\Modulo\Services\Identity\PasswordLogin::class],
            ['Profile', \Hostville\Modulo\Services\Identity\Profile::class],
            ['Registration', \Hostville\Modulo\Services\Identity\Registration::class],
            ['Store', \Hostville\Modulo\Services\Store::class]
        ];
    }
}