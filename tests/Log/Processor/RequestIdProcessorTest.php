<?php

namespace Dafiti\Tests\Log\Processor;

use Dafiti\Log\Processor\RequestIdProcessor;

class RequestIdProcessorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Dafiti\Log\Processor\RequestIdProcessor::__invoke
     */
    public function testShouldNotModifyRecordWhenCalledLikeAMethod()
    {
        $processor = new RequestIdProcessor();

        $record = [
            'message' => 'Dafiti'
        ];

        $result = $processor($record);

        $this->assertEquals($record, $result);
    }

    /**
     * @covers \Dafiti\Log\Processor\RequestIdProcessor::__invoke
     */
    public function testShouldModifyRecordWhenCalledLikeAMethod()
    {
        $processor = new RequestIdProcessor();

        putenv('REQUEST_ID=123456789');

        $expected = [
            'extra' => [
                'request-id' => '123456789'
            ]
        ];

        $record = [];

        $result = $processor($record);

        $this->assertEquals($expected, $result);
    }

}