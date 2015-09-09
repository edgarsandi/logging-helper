<?php

namespace Dafiti\Tests\Log;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        vfsStreamWrapper::register();
        $root = vfsStream::setup('logs');
        $mockFile = vfsStream::newFile('logging_helper.log')
            ->at($root);
        $root->addChild($mockFile);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The $applicationName and $stream
     *     parameters are required
     */
    public function testShouldThrowExceptionWithInvalidApplicationName()
    {
        $log = (new \Dafiti\Log\Factory())->createInstance(null, null);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Level "999" is not defined, use one of: 100,
     *     200, 250, 300, 400, 500, 550, 600
     */
    public function testShouldThrowExceptionWithInvalidLogLevel()
    {
        $logger = (new \Dafiti\Log\Factory())->createInstance(
            'logging_helper',
            vfsStream::url('logs/logging_helper.log')
        );
        $logger->log(999, null);
    }

    public function testShouldCreateAnLoggerHandler()
    {
        $expected = json_decode('{"@timestamp":"2015-09-09T02:50:16.504087+00:00",
            "@version":1,"host":"sake","message":"any message","type":"alice",
            "channel":"alice","level":"INFO"}');
        unset($expected->{'@timestamp'}, $expected->{'host'});
        $logger = (new \Dafiti\Log\Factory())->createInstance(
            'alice',
            vfsStream::url('logs/logging_helper.log')
        );
        $logger->log(\Monolog\Logger::INFO, 'any message');
        $actual = json_decode(file_get_contents(vfsStream::url('logs/logging_helper.log')));
        unset($actual->{'@timestamp'}, $actual->{'host'});
        $this->assertEquals($expected, $actual);
    }

    public function testShouldCreateTagProcessorWhenRequestIdExists()
    {
        $expected = json_decode('{"@timestamp":"2015-09-09T03:09:05.653923+00:00","@version":1,"host":"sake","message":"any message","type":"logging_helper","channel":"logging_helper","level":"INFO","tags":{"request-id":"1234567890"}}');
        unset($expected->{'@timestamp'}, $expected->{'host'});
        putenv('MESSAGE_ID=1234567890');
        $logger = (new \Dafiti\Log\Factory())->createInstance('logging_helper', vfsStream::url('logs/logging_helper.log'));
        $logger->log(\Monolog\Logger::INFO, 'any message');
        $actual = json_decode(file_get_contents(vfsStream::url('logs/logging_helper.log')));
        unset($actual->{'@timestamp'}, $actual->{'host'});
        $this->assertEquals($expected, $actual);
    }
}
