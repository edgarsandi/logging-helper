<?php

namespace Dafiti\Log\Formatter;

class LogstashFormatter extends \Monolog\Formatter\LogstashFormatter
{
    public function __construct($applicationName, $systemName = null, $extraPrefix = null, $contextPrefix = 'ctxt_')
    {
        parent::__construct($applicationName, $systemName = null, $extraPrefix = null, $contextPrefix = 'ctxt_', $version = self::V1);
    }
}
