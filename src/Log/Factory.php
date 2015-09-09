<?php

namespace Dafiti\Log;

use \Monolog\Logger,
    \Monolog\Handler\NewRelicHandler,
    \Monolog\Handler\StreamHandler,
    \Monolog\Processor\TagProcessor;

class Factory
{
    private $stream;

    public function createInstance($applicationName, $stream)
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

        $formatter = new Formatter\LogstashFormatter($applicationName);

        $streamHandler = new StreamHandler($stream);
        $streamHandler->setFormatter($formatter);
        $logger->pushHandler($streamHandler);

        return $logger;
    }
}