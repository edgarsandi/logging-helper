<?php

namespace Dafiti\Log\Formatter;

class LogstashFormatter extends \Monolog\Formatter\LogstashFormatter
{
    public function __construct($applicationName, $systemName = null, $extraPrefix = null, $contextPrefix = '')
    {
        parent::__construct($applicationName, $systemName = null, $extraPrefix = null, $contextPrefix = '', $version = self::V1);
    }
}
