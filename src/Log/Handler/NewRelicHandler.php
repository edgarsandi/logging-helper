<?php

namespace Dafiti\Log\Handler;

use Monolog\Handler\NewRelicHandler as BaseHandler;

class NewRelicHandler extends BaseHandler
{
    protected function write(array $record)
    {
        if (extension_loaded('newrelic')) {
            parent::write($record);
        }
    }
}
