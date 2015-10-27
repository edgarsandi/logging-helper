<?php

namespace Dafiti\Log\Processor;

class RequestIdProcessor
{
    public function __invoke(array $record)
    {
        $requestId = getenv('REQUEST_ID');

        if ($requestId != '') {
            $record['extra']['request-id'] = $requestId;
        }

        return $record;
    }
}
