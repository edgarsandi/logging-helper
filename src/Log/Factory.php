<?php

namespace Dafiti\Log;

use Dafiti\Log\Processor\RequestIdProcessor;
use Dafiti\Log\Handler\NewRelicHandler;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Factory
{
    /**
     * @param string $logName
     * @param string $stream
     *
     * @return \Monolog\Logger $logger
     */
    public function createInstance($logName, $stream, $logLevel = \Monolog\Logger::ERROR)
    {
        if (!isset($logName, $stream)) {
            throw new \InvalidArgumentException('The $logName and $stream
             parameters are required');
        }

        $logger = new Logger($logName);

        $logger->pushHandler(new NewRelicHandler());
        $logger->pushProcessor(new RequestIdProcessor());

        $streamHandler = new StreamHandler($stream, $logLevel);
        $formatter = new Formatter\LogstashFormatter($logName);
        $streamHandler->setFormatter($formatter);
        $logger->pushHandler($streamHandler);

        return $logger;
    }
}
