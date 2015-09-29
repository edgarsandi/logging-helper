# Logging Helper
[![Build Status](https://img.shields.io/travis/dafiti/logging-helper/master.svg?style=flat-square)](https://travis-ci.org/dafiti/logging-helper)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/dafiti/logging-helper/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/dafiti/logging-helper/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/dafiti/logging-helper/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/dafiti/logging-helper/?branch=master)
[![HHVM](https://img.shields.io/hhvm/dafiti/logging-helper.svg?style=flat-square)](https://travis-ci.org/dafiti/logging-helper)
[![Latest Stable Version](https://img.shields.io/packagist/v/dafiti/logging-helper.svg?style=flat-square)](https://packagist.org/packages/dafiti/logging-helper)
[![Total Downloads](https://img.shields.io/packagist/dt/dafiti/logging-helper.svg?style=flat-square)](https://packagist.org/packages/dafiti/logging-helper)
[![License](https://img.shields.io/packagist/l/dafiti/logging-helper.svg?style=flat-square)](https://packagist.org/packages/dafiti/logging-helper)

## Preface
This helper should be used for all workcells, all log generated will be sent to the Newrelic (if enabled and configured) and also to file system formatted with LogstashFormatter.

## Instalation
The package is available on [Packagist](http://packagist.org/packages/dafiti/logging-helper).
Autoloading is [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) compatible.

```json
{
    "require": {
        "dafiti/logging-helper": "0.0.4"
    }
}
```

The minimal log level default is \Monolog\Logger::ERROR, when the third parameter has been omitted, this will be the minimun log level of logger instance
All messages sent with a less log level (example: \Monolog\Logger::DEBUG) will not be logged because the minimum log level is greater

## Usage
### Basic
#### logging message 
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<log name>', '<log path/filename>');
$logger->log(<log level>, '<log message>');
```
##### outputs
```json
{"@timestamp":"2015-09-16T13:41:15.626418-03:00","@version":1,"host":"server01","message":"<log message>","type":"<log name>","channel":"<log name>","level":"<log level>"}
```

#### Logging message and more values 
You can send an array of key value pair: 
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<log name>', '<log path/filename>');
$logger->log(<log level>, '<log message>', [<key-value-pair>]);
```

##### Example:
```php
$values = ['string' => 'value', 'int' => 10, 'float' => 10.0, 'bool' => true, 'resource' => null, 'object' => (new stdClass()), 'sub-array' => range('A', 'D')];
$logger = (new \Dafiti\Log\Factory())->createInstance('<log name>', '<log path/filename>');
$logger->log(<log level>, '<log message>', $values);
```
##### outputs
```json
{"@timestamp":"2015-09-16T14:51:42.636524-03:00","@version":1,"host":"7dd53b17bdec","message":"<log message>","type":"<log name>","channel":"<log name>","level":"<log level>","string":"value","int":10,"float":10,"bool":true,"resource":null,"object":"[object] (stdClass: {})","sub-array":["A","B","C","D","E"]}
```

### Alternative
In alternative to log method you can use the add<log level> methods:
##### Debug
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<log name>', '<log path/filename>');
$logger->debug('<log message>', [<key-value-pair>]);
// or
$logger->addDebug('<log message>', [<key-value-pair>]);
```
##### outputs
```json
{"@timestamp":"2015-09-16T13:41:15.626418-03:00","@version":1,"host":"server01","message":"<log message>","type":"<log name>","channel":"<log name>","level":"DEBUG"}
```
##### Info
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<log name>', '<log path/filename>');
$logger->info('<log message>', [<key-value-pair>]);
// or
$logger->addInfo('<log message>', [<key-value-pair>]);
```
##### outputs
```json
{"@timestamp":"2015-09-16T13:41:15.626418-03:00","@version":1,"host":"server01","message":"<log message>","type":"<log name>","channel":"<log name>","level":"INFO"}
```
##### Notice
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<log name>', '<log path/filename>');
$logger->notice('<log message>', [<key-value-pair>]);
// or
$logger->addNotice('<log message>', [<key-value-pair>]);
```
##### outputs
```json
{"@timestamp":"2015-09-16T13:41:15.626418-03:00","@version":1,"host":"server01","message":"<log message>","type":"<log name>","channel":"<log name>","level":"NOTICE"}
```
##### Warning or warning
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<log name>', '<log path/filename>');
$logger->warning('<log message>', [<key-value-pair>]);
// or
$logger->addWarning('<log message>', [<key-value-pair>]);
```
##### outputs
```json
{"@timestamp":"2015-09-16T13:41:15.626418-03:00","@version":1,"host":"server01","message":"<log message>","type":"<log name>","channel":"<log name>","level":"WARNING"}
```
##### Error
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<log name>', '<log path/filename>');
$logger->error('<log message>', [<key-value-pair>]);
// or
$logger->addError('<log message>', [<key-value-pair>]);
```
##### outputs
```json
{"@timestamp":"2015-09-16T13:41:15.626418-03:00","@version":1,"host":"server01","message":"<log message>","type":"<log name>","channel":"<log name>","level":"ERROR"}
```
##### Critical
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<log name>', '<log path/filename>');
$logger->critical('<log message>', [<key-value-pair>]);
// or
$logger->addCritical('<log message>', [<key-value-pair>]);
```
##### outputs
```json
{"@timestamp":"2015-09-16T13:41:15.626418-03:00","@version":1,"host":"server01","message":"<log message>","type":"<log name>","channel":"<log name>","level":"CRITICAL"}
```
##### Alert
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<log name>', '<log path/filename>');
$logger->alert('<log message>', [<key-value-pair>]);
// or
$logger->addAlert('<log message>', [<key-value-pair>]);
```
##### outputs
```json
{"@timestamp":"2015-09-16T13:41:15.626418-03:00","@version":1,"host":"server01","message":"<log message>","type":"<log name>","channel":"<log name>","level":"ALERT"}
```
##### Emergency
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<log name>', '<log path/filename>');
$logger->emergency('<log message>', [<key-value-pair>]);
// or
$logger->addEmergency('<log message>', [<key-value-pair>]);
```
##### outputs
```json
{"@timestamp":"2015-09-16T13:41:15.626418-03:00","@version":1,"host":"server01","message":"<log message>","type":"<log name>","channel":"<log name>","level":"EMERGENCY"}
```

#### \<log name\> samples:
* alice
* bob
* checkout
* payment
* mobileapi
* braspag
* adyen
* others

#### \<log path/filename\>:
Use the default log path

#### \<log level\> available:
| Type      | Usage                            | Log code |       Alternative methods       | Description                                 | When use                                                                                           |
| --------- |--------------------------------- | -------- | ------------------------------- | ------------------------------------------- | -------------------------------------------------------------------------------------------------- |
| Debug     | ```\Monolog\Logger::DEBUG```     |    100   | addDebug()      or  debug()     | Detailed debug information                  |                                                                                                    |
| Info      | ```\Monolog\Logger::INFO```      |    200   | addInfo()       or  info()      | Interesting events                          | User logs in, SQL logs                                                                             |
| Notice    | ```\Monolog\Logger::NOTICE```    |    250   | addNotice()     or  notice()    | Uncommon events                             |                                                                                                    |
| Warning   | ```\Monolog\Logger::WARNING```   |    300   | addWarning()    or  warning()   | Exceptional occurrences that are not errors | Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong      |
| Error     | ```\Monolog\Logger::ERROR```     |    400   | addError()      or  error()     | Runtime errors                              |                                                                                                    |
| Critical  | ```\Monolog\Logger::CRITICAL```  |    500   | addCritical()   or  critical()  | Critical conditions                         | Application component unavailable, unexpected exception                                            |
| Alert     | ```\Monolog\Logger::ALERT```     |    550   | addAlert()      or  alert()     | Action must be taken immediately            | Entire website down, database unavailable, etc. This should trigger the SMS alerts and wake you up |
| Emergency | ```\Monolog\Logger::EMERGENCY``` |    600   | addEmergency()  or  emergency() | Urgent alert                                | This is only bumped when API breaks are done and should follow the major version of the library    |

#### \<log message\>:
The message to be logged

## License
MIT License
