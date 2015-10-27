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

    public function tearDown()
    {
        unlink(vfsStream::url('logs/logging_helper.log'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The $logName and $stream
     *     parameters are required
     */
    public function testShouldThrowExceptionWithInvalidLogName()
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
        $expected = json_decode('{"@timestamp":"<any>",
            "@version":1,"host":"sake","message":"ERROR message","type":"logName",
            "channel":"logName","level":"ERROR"}');
        unset($expected->{'@timestamp'}, $expected->{'host'});

        $logger = (new \Dafiti\Log\Factory())->createInstance(
            'logName',
            vfsStream::url('logs/logging_helper.log')
        );

        $logger->log(\Monolog\Logger::ERROR, 'ERROR message');
        $actual = json_decode(file_get_contents(vfsStream::url('logs/logging_helper.log')));
        unset($actual->{'@timestamp'}, $actual->{'host'});

        $this->assertEquals($expected, $actual);
    }

    public function testShouldCreateTagProcessorWhenRequestIdExists()
    {
        $expected = json_decode('{"@timestamp":"<any>",
            "@version":1,"host":"sake","message":"ERROR message",
            "type":"logging_helper","channel":"logging_helper","level":"ERROR",
            "request-id":"1234567890"}');
        unset($expected->{'@timestamp'}, $expected->{'host'});

        putenv('REQUEST_ID=1234567890');
        $logger = (new \Dafiti\Log\Factory())->createInstance('logging_helper', vfsStream::url('logs/logging_helper.log'));
        $logger->log(\Monolog\Logger::ERROR, 'ERROR message');
        $actual = json_decode(file_get_contents(vfsStream::url('logs/logging_helper.log')));
        unset($actual->{'@timestamp'}, $actual->{'host'});
        putenv('REQUEST_ID');

        $this->assertEquals($expected, $actual);
    }

    public function testShouldnotLogMessageIfLogLevelIsLessThanLogLevelDefault()
    {
        $expected = json_decode('');
        unset($expected->{'@timestamp'}, $expected->{'host'});

        $logger = (new \Dafiti\Log\Factory())->createInstance(
            'logName',
            vfsStream::url('logs/logging_helper.log')
        );

        $logger->log(\Monolog\Logger::INFO, 'INFO message');
        $actual = json_decode(file_get_contents(vfsStream::url('logs/logging_helper.log')));
        unset($actual->{'@timestamp'}, $actual->{'host'});

        $this->assertEquals($expected, $actual);
    }

    public function testShouldLogMessageIfLogLevelIsGreaterThanLogLevelDefault()
    {
        $expected = json_decode('{"@timestamp":"<any>",
            "@version":1,"host":"sake","message":"CRITICAL message","type":"logName",
            "channel":"logName","level":"CRITICAL"}');
        unset($expected->{'@timestamp'}, $expected->{'host'});

        $logger = (new \Dafiti\Log\Factory())->createInstance(
            'logName',
            vfsStream::url('logs/logging_helper.log')
        );

        $logger->log(\Monolog\Logger::CRITICAL, 'CRITICAL message');
        $actual = json_decode(file_get_contents(vfsStream::url('logs/logging_helper.log')));
        unset($actual->{'@timestamp'}, $actual->{'host'});

        $this->assertEquals($expected, $actual);
    }

    public function testShouldLogMessageWithDebugLogLevelMethodAndLogLevelAndCustomLogLevel()
    {
        $expected = json_decode('{"@timestamp":"<any>",
            "@version":1,"host":"sake","message":"DEBUG message","type":"logName",
            "channel":"logName","level":"DEBUG"}');
        unset($expected->{'@timestamp'}, $expected->{'host'});

        $logger = (new \Dafiti\Log\Factory())->createInstance(
            'logName',
            vfsStream::url('logs/logging_helper.log'),
            \Monolog\Logger::DEBUG
        );

        $logger->addDebug('DEBUG message');
        $actual = json_decode(file_get_contents(vfsStream::url('logs/logging_helper.log')));
        unset($actual->{'@timestamp'}, $actual->{'host'});

        $this->assertEquals($expected, $actual);
    }

    public function testShouldLogMessageWithInfoLogLevelMethodAndLogLevelAndCustomLogLevel()
    {
        $expected = json_decode('{"@timestamp":"<any>",
            "@version":1,"host":"sake","message":"INFO message","type":"logName",
            "channel":"logName","level":"INFO"}');
        unset($expected->{'@timestamp'}, $expected->{'host'});

        $logger = (new \Dafiti\Log\Factory())->createInstance(
            'logName',
            vfsStream::url('logs/logging_helper.log'),
            \Monolog\Logger::DEBUG
        );

        $logger->addInfo('INFO message');
        $actual = json_decode(file_get_contents(vfsStream::url('logs/logging_helper.log')));
        unset($actual->{'@timestamp'}, $actual->{'host'});

        $this->assertEquals($expected, $actual);
    }

    public function testShouldLogMessageWithNoticeLogLevelMethodAndLogLevelAndCustomLogLevel()
    {
        $expected = json_decode('{"@timestamp":"<any>",
            "@version":1,"host":"sake","message":"NOTICE message","type":"logName",
            "channel":"logName","level":"NOTICE"}');
        unset($expected->{'@timestamp'}, $expected->{'host'});

        $logger = (new \Dafiti\Log\Factory())->createInstance(
            'logName',
            vfsStream::url('logs/logging_helper.log'),
            \Monolog\Logger::DEBUG
        );

        $logger->addNotice('NOTICE message');
        $actual = json_decode(file_get_contents(vfsStream::url('logs/logging_helper.log')));
        unset($actual->{'@timestamp'}, $actual->{'host'});

        $this->assertEquals($expected, $actual);
    }

    public function testShouldLogMessageWithWarningLogLevelMethodAndLogLevelAndCustomLogLevel()
    {
        $expected = json_decode('{"@timestamp":"<any>",
            "@version":1,"host":"sake","message":"WARNING message","type":"logName",
            "channel":"logName","level":"WARNING"}');
        unset($expected->{'@timestamp'}, $expected->{'host'});

        $logger = (new \Dafiti\Log\Factory())->createInstance(
            'logName',
            vfsStream::url('logs/logging_helper.log'),
            \Monolog\Logger::DEBUG
        );

        $logger->addWarning('WARNING message');
        $actual = json_decode(file_get_contents(vfsStream::url('logs/logging_helper.log')));
        unset($actual->{'@timestamp'}, $actual->{'host'});

        $this->assertEquals($expected, $actual);
    }

    public function testShouldLogMessageWithErrorLogLevelMethodAndLogLevelAndCustomLogLevel()
    {
        $expected = json_decode('{"@timestamp":"<any>",
            "@version":1,"host":"sake","message":"ERROR message","type":"logName",
            "channel":"logName","level":"ERROR"}');
        unset($expected->{'@timestamp'}, $expected->{'host'});

        $logger = (new \Dafiti\Log\Factory())->createInstance(
            'logName',
            vfsStream::url('logs/logging_helper.log'),
            \Monolog\Logger::DEBUG
        );

        $logger->addError('ERROR message');
        $actual = json_decode(file_get_contents(vfsStream::url('logs/logging_helper.log')));
        unset($actual->{'@timestamp'}, $actual->{'host'});

        $this->assertEquals($expected, $actual);
    }

    public function testShouldLogMessageWithCriticalLogLevelMethodAndLogLevelAndCustomLogLevel()
    {
        $expected = json_decode('{"@timestamp":"<any>",
            "@version":1,"host":"sake","message":"CRITICAL message","type":"logName",
            "channel":"logName","level":"CRITICAL"}');
        unset($expected->{'@timestamp'}, $expected->{'host'});

        $logger = (new \Dafiti\Log\Factory())->createInstance(
            'logName',
            vfsStream::url('logs/logging_helper.log'),
            \Monolog\Logger::DEBUG
        );

        $logger->addCritical('CRITICAL message');
        $actual = json_decode(file_get_contents(vfsStream::url('logs/logging_helper.log')));
        unset($actual->{'@timestamp'}, $actual->{'host'});

        $this->assertEquals($expected, $actual);
    }

    public function testShouldLogMessageWithAlertLogLevelMethodAndLogLevelAndCustomLogLevel()
    {
        $expected = json_decode('{"@timestamp":"<any>",
            "@version":1,"host":"sake","message":"ALERT message","type":"logName",
            "channel":"logName","level":"ALERT"}');
        unset($expected->{'@timestamp'}, $expected->{'host'});

        $logger = (new \Dafiti\Log\Factory())->createInstance(
            'logName',
            vfsStream::url('logs/logging_helper.log'),
            \Monolog\Logger::DEBUG
        );

        $logger->addAlert('ALERT message');
        $actual = json_decode(file_get_contents(vfsStream::url('logs/logging_helper.log')));
        unset($actual->{'@timestamp'}, $actual->{'host'});

        $this->assertEquals($expected, $actual);
    }

    public function testShouldLogMessageWithEmergencyLogLevelMethodAndLogLevelAndCustomLogLevel()
    {
        $expected = json_decode('{"@timestamp":"<any>",
            "@version":1,"host":"sake","message":"EMERGENCY message","type":"logName",
            "channel":"logName","level":"EMERGENCY"}');
        unset($expected->{'@timestamp'}, $expected->{'host'});

        $logger = (new \Dafiti\Log\Factory())->createInstance(
            'logName',
            vfsStream::url('logs/logging_helper.log'),
            \Monolog\Logger::DEBUG
        );

        $logger->addEmergency('EMERGENCY message');
        $actual = json_decode(file_get_contents(vfsStream::url('logs/logging_helper.log')));
        unset($actual->{'@timestamp'}, $actual->{'host'});

        $this->assertEquals($expected, $actual);
    }
}
