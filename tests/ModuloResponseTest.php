<?php

namespace Hostville\Modullo\Tests;


use Hostville\Modullo\ModulloResponse;
use PHPUnit\Framework\TestCase;

class ModulloResponseTest extends TestCase
{
    /** @var ModulloResponse */
    protected $response;

    protected $sampleSuccess = [
        'data' => ['name' => 'John', 'age' => 20],
        'status' => 'success',
        'message' => 'a message',
        'errors' => [
            ['title' => 'a title', 'source' => []]
        ]
    ];

    public function setUp()
    {
        $this->response = new ModulloResponse(json_encode($this->sampleSuccess));
    }

    public function testGetRawResponse()
    {
        $this->assertEquals(json_encode($this->sampleSuccess), $this->response->getRawResponse());
    }

    public function testIsSuccessful()
    {
        $this->assertTrue($this->response->isSuccessful());
        $response = new ModulloResponse('', 400);
        $this->assertFalse($response->isSuccessful());
    }

    public function testGetMessage()
    {
        $this->assertEquals($this->sampleSuccess['message'], $this->response->getMessage());
    }

    public function testGetData()
    {
        $this->assertEquals($this->sampleSuccess['data'], $this->response->getData());
    }

    /**
     * @dataProvider attributes
     */
    public function testGetAttributes($name)
    {
        $this->assertEquals($this->sampleSuccess[$name], $this->response->{$name});
    }

    public function attributes()
    {
        return [
            ['data'],
            ['status'],
            ['message'],
            ['errors']
        ];
    }
}