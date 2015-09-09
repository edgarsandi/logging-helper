<?php

namespace Dafiti\Log\Formatter;

class LogstashFormatter extends \Monolog\Formatter\LogstashFormatter
{
    public function __construct($applicationName, $systemName = null, $extraPrefix = null, $contextPrefix = 'ctxt_')
    {
        parent::__construct('Y-m-d\TH:i:s.uP');

        $this->systemName = $systemName ?: gethostname();
        $this->applicationName = $applicationName;
        $this->extraPrefix = $extraPrefix;
        $this->contextPrefix = $contextPrefix;
        $this->version = 1;
    }
}
