<?php

namespace Dafiti\Log;

use Monolog\Logger;
use Monolog\Handler\NewRelicHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\TagProcessor;

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

        if (extension_loaded('newrelic')) {
            $logger->pushHandler(new NewRelicHandler());
        }

        $requestId = getenv('MESSAGE_ID');
        if ($requestId != '') {
            $tag = new TagProcessor(['request-id' => $requestId]);
            $logger->pushProcessor($tag);
        }

        $streamHandler = new StreamHandler($stream, $logLevel);
        $formatter = new Formatter\LogstashFormatter($logName);
        $streamHandler->setFormatter($formatter);
        $logger->pushHandler($streamHandler);

        return $logger;
    }
}
