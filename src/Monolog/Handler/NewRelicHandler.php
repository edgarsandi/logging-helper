<?php

namespace Dafiti\Monolog\Handler;

class NewRelicHandler extends \Monolog\Handler\AbstractProcessingHandler
{
    public function write(array $record)
    {
        var_dump($record);
    }
}