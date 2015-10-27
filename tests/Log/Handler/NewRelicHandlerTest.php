<?php

namespace Dafiti\Tests\Log\Handler;

use Dafiti\Log\Handler\NewRelicHandler;

class NewRelicHandlerTest extends \PHPUnit_Framework_TestCase
{

    public function testClassMustBeInstanceOfNewRelicHandler()
    {
        $newRelicHandler = new NewRelicHandler();
        $this->assertInstanceOf('\Monolog\Handler\NewRelicHandler', $newRelicHandler);
    }
}