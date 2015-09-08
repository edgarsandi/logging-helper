<?php

namespace Dafiti\Monolog\Handler;

class StreamHandler extends \Monolog\Handler\AbstractProcessingHandler
{
	public function write(array $record)
	{
		var_dump($record);
	}
}