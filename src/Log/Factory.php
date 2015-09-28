<?php

namespace Dafiti\Log;

use Monolog\Logger;
use Monolog\Handler\NewRelicHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\TagProcessor;

class Factory
{
    /**
     * @param string $applicationName
     * @param string $stream
     *
     * @return \Monolog\Logger $logger
     */
    public function createInstance($applicationName, $stream, $logLevel = \Monolog\Logger::ERROR)
    {
        if (!isset($applicationName, $stream)) {
            throw new \InvalidArgumentException('The $applicationName and $stream
             parameters are required');
        }

        $logger = new Logger($applicationName);

        if (extension_loaded('newrelic')) {
            $logger->pushHandler(new NewRelicHandler());
        }

        $requestId = getenv('MESSAGE_ID');
        if ($requestId != '') {
            $tag = new TagProcessor(['request-id' => $requestId]);
            $logger->pushProcessor($tag);
        }

        $streamHandler = new StreamHandler($stream, $logLevel);
        $formatter = new Formatter\LogstashFormatter($applicationName);
        $streamHandler->setFormatter($formatter);
        $logger->pushHandler($streamHandler);

        return $logger;
    }
}
