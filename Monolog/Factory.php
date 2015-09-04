<?php

namespace Dafiti\Monolog;

require_once ('../../bob/vendor/autoload.php');
require_once ('Handler/StreamHandler.php');
require_once ('Handler/NewRelicHandler.php');
require_once ('Formatter/LogstashFormatter.php');

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

        putenv('MESSAGE_ID=123456');
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

$teste = (new Factory())->createInstance('alice', Logger::INFO, true);
$teste->log(Logger::INFO,'testando');