<?php

namespace Dafiti\Monolog;

use \Monolog\Logger;
use \Monolog\Processor\TagProcessor;

class Factory
{
    public function createInstance($applicationName, $logLevel = Logger::INFO, $withNewRelic = false)
    {
        $logger = new Logger($logLevel);

        if ($withNewRelic) {
            $logger->pushHandler(new \Dafiti\Monolog\Handler\NewRelicHandler());
        }

        if (getenv('MESSAGE_ID') != '') {
            $tag = new TagProcessor(['request-id' => getenv('MESSAGE_ID')]);
            $logger->pushProcessor($tag);
        }

        $streamHandler = new \Dafiti\Monolog\Handler\StreamHandler();
        $formatter = new \Dafiti\Monolog\Formatter\LogstashFormatter($applicationName);
        $streamHandler->setFormatter($formatter);
        $logger->pushHandler($streamHandler);

        return $logger;
    }
}