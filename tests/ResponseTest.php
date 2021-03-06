<?php

namespace GatherUp\Tests\SDK;

use GatherUp\SDK\Response;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

/**
 * Class ResponseTest
 *
 * @package GatherUp\Tests\SDK
 */
class ResponseTest extends TestCase
{
    function testException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Response('{efeg');
    }

    function testEmptyResponse(): void
    {
        $response = new Response('{}');
        $this->assertEquals(false, $response->isSuccess());
        $this->assertEquals(-1, $response->getCode());
        $this->assertEquals('Unknown', $response->getMessage());
        $this->assertNull($response->get('efeg'));
        $this->assertFalse($response->has('efeg'));
        $this->assertEquals([], $response->getRawData());
    }

    function testNotEmptyResponse(): void
    {
        $response = new Response(
            '{"errorCode":0,"errorMessage":"Success","demo":1}'
        );
        $this->assertEquals(true, $response->isSuccess());
        $this->assertEquals(0, $response->getCode());
        $this->assertEquals('Success', $response->getMessage());
        $this->assertEquals(1, $response->get('demo'));
        $this->assertTrue($response->has('demo'));
        $this->assertEquals(
            [
                'errorCode'    => 0,
                'errorMessage' => 'Success',
                'demo'         => 1,
            ],
            $response->getRawData()
        );
    }
}
