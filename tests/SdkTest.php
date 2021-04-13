<?php

namespace Hostville\Modullo\Tests;

use GuzzleHttp\Client;
use Hostville\Modullo\Exception\ModulloException;
use Hostville\Modullo\Manifest;
use Hostville\Modullo\Sdk;
use Hostville\Modullo\UrlRegistry;
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
        $this->expectException(ModulloException::class);
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
            ['Advert', \Hostville\Modullo\Resources\ECommerce\Advert::class],
            ['AppStore', \Hostville\Modullo\Resources\Developers\AppStore::class],
            ['Blog', \Hostville\Modullo\Resources\ECommerce\Blog::class],
            ['Company', \Hostville\Modullo\Resources\Company::class],
            ['Coupon', \Hostville\Modullo\Resources\Coupon::class],
            ['Country', \Hostville\Modullo\Resources\Common\Country::class],
            ['ContactField', \Hostville\Modullo\Resources\Crm\ContactField::class],
            ['Customer', \Hostville\Modullo\Resources\Crm\Customer::class],
            ['Deal', \Hostville\Modullo\Resources\Crm\Deal::class],
            ['Department', \Hostville\Modullo\Resources\Common\Company\Department::class],
            ['Developer', \Hostville\Modullo\Resources\Developers\Developer::class],
            ['DeveloperApplication', \Hostville\Modullo\Resources\Developers\Application::class],
            ['Directory', \Hostville\Modullo\Resources\Common\Directory::class],
            ['Domain', \Hostville\Modullo\Resources\ECommerce\Domain::class],
            ['Employee', \Hostville\Modullo\Resources\Common\Company\Employee::class],
            ['Finance', \Hostville\Modullo\Resources\Finance\Finance::class],
            ['Integration', \Hostville\Modullo\Resources\Common\Company\Integration::class],
            ['Invite', \Hostville\Modullo\Resources\Invite::class],
            ['Location', \Hostville\Modullo\Resources\Common\Company\Location::class],
            ['Order', \Hostville\Modullo\Resources\Invoicing\Order::class],
            ['Partner', \Hostville\Modullo\Resources\Partner::class],
            ['Plan', \Hostville\Modullo\Resources\Plan::class],
            ['Product', \Hostville\Modullo\Resources\Invoicing\Product::class],
            ['ProductCategory', \Hostville\Modullo\Resources\Invoicing\ProductCategory::class],
            ['State', \Hostville\Modullo\Resources\Common\State::class],
            ['Team', \Hostville\Modullo\Resources\Common\Company\Team::class],
            ['User', \Hostville\Modullo\Resources\Users\User::class]
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
            ['Authorization', \Hostville\Modullo\Services\Identity\Authorization::class],
            ['Company', \Hostville\Modullo\Services\Identity\Tenant::class],
            ['Metrics', \Hostville\Modullo\Services\Metrics::class],
            ['PasswordLogin', \Hostville\Modullo\Services\Identity\PasswordLogin::class],
            ['Profile', \Hostville\Modullo\Services\Identity\Profile::class],
            ['Registration', \Hostville\Modulo\Services\Identity\Registration::class],
            ['Store', \Hostville\Modulo\Services\Store::class]
        ];
    }
}