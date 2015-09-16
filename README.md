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
        "dafiti/logging-helper": "0.0.2"
    }
}
```


## Usage
### Basic
#### logging message
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<application name>', '<log path/filename>');
$logger->log(<log level>, '<log message>');
```
##### outputs
```json
{"@timestamp":"2015-09-16T13:41:15.626418-03:00","@version":1,"host":"server01","message":"<log message>","type":"<application name>","channel":"<application name>","level":"<log level>"}
```

#### Logging message and more values 
You can send an array of key value pair: 
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<application name>', '<log path/filename>');
$logger->log(<log level>, '<log message>', [<key-value-pair>]);
```

##### Example:
```php
$values = ['string' => 'value', 'int' => 10, 'float' => 10.0, 'bool' => true, 'resource' => null, 'object' => (new stdClass()), 'sub-array' => range('A', 'D')];
$logger = (new \Dafiti\Log\Factory())->createInstance('<application name>', '<log path/filename>');
$logger->log(<log level>, '<log message>', $values);
```
##### outputs
```json
{"@timestamp":"2015-09-16T14:51:42.636524-03:00","@version":1,"host":"7dd53b17bdec","message":"<log message>","type":"<application name>","channel":"<application name>","level":"<log level>","string":"value","int":10,"float":10,"bool":true,"resource":null,"object":"[object] (stdClass: {})","sub-array":["A","B","C","D","E"]}
```

### Alternative
In alternative to log method you can use the add<log level> methods:
##### addDebug
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<application name>', '<log path/filename>');
$logger->addDebug('<log message>', [<key-value-pair>]);
```
##### outputs
```json
{"@timestamp":"2015-09-16T13:41:15.626418-03:00","@version":1,"host":"server01","message":"<log message>","type":"<application name>","channel":"<application name>","level":"DEBUG"}
```
##### addInfo
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<application name>', '<log path/filename>');
$logger->addInfo('<log message>', [<key-value-pair>]);
```
##### outputs
```json
{"@timestamp":"2015-09-16T13:41:15.626418-03:00","@version":1,"host":"server01","message":"<log message>","type":"<application name>","channel":"<application name>","level":"INFO"}
```
##### addNotice
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<application name>', '<log path/filename>');
$logger->addNotice('<log message>', [<key-value-pair>]);
```
##### outputs
```json
{"@timestamp":"2015-09-16T13:41:15.626418-03:00","@version":1,"host":"server01","message":"<log message>","type":"<application name>","channel":"<application name>","level":"NOTICE"}
```
##### addWarning
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<application name>', '<log path/filename>');
$logger->addWarning('<log message>', [<key-value-pair>]);
```
##### outputs
```json
{"@timestamp":"2015-09-16T13:41:15.626418-03:00","@version":1,"host":"server01","message":"<log message>","type":"<application name>","channel":"<application name>","level":"WARNING"}
```
##### addError
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<application name>', '<log path/filename>');
$logger->addError('<log message>', [<key-value-pair>]);
```
##### outputs
```json
{"@timestamp":"2015-09-16T13:41:15.626418-03:00","@version":1,"host":"server01","message":"<log message>","type":"<application name>","channel":"<application name>","level":"ERROR"}
```
##### addCritical
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<application name>', '<log path/filename>');
$logger->addCritical('<log message>', [<key-value-pair>]);
```
##### outputs
```json
{"@timestamp":"2015-09-16T13:41:15.626418-03:00","@version":1,"host":"server01","message":"<log message>","type":"<application name>","channel":"<application name>","level":"CRITICAL"}
```
##### addAlert
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<application name>', '<log path/filename>');
$logger->addAlert('<log message>', [<key-value-pair>]);
```
##### outputs
```json
{"@timestamp":"2015-09-16T13:41:15.626418-03:00","@version":1,"host":"server01","message":"<log message>","type":"<application name>","channel":"<application name>","level":"ALERT"}
```
##### addEmergency
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<application name>', '<log path/filename>');
$logger->addEmergency('<log message>', [<key-value-pair>]);
```
##### outputs
```json
{"@timestamp":"2015-09-16T13:41:15.626418-03:00","@version":1,"host":"server01","message":"<log message>","type":"<application name>","channel":"<application name>","level":"EMERGENCY"}
```

#### \<application name\> samples:
* alice
* bob
* checkout
* payment
* mobileapi
* others

#### \<log path/filename\>:
Use the default log path

#### \<log level\> available:
| Type      | Usage                            | Log code | Alternative method | Description                                 | Example                                                                                            |
| --------- |--------------------------------- | -------- | ------------------ | ------------------------------------------- | -------------------------------------------------------------------------------------------------- |
| Debug     | ```\Monolog\Logger::DEBUG```     |  100     | addDebug()         | Detailed debug information                  |                                                                                                    |
| Info      | ```\Monolog\Logger::INFO```      |  200     | addInfo()          | Interesting events                          | User logs in, SQL logs                                                                             |
| Notice    | ```\Monolog\Logger::NOTICE```    |  250     | addNotice()        | Uncommon events                             |                                                                                                    |
| Warning   | ```\Monolog\Logger::WARNING```   |  300     | addWarning()       | Exceptional occurrences that are not errors | Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong      |
| Error     | ```\Monolog\Logger::ERROR```     |  400     | addError()         | Runtime errors                              |                                                                                                    |
| Critical  | ```\Monolog\Logger::CRITICAL```  |  500     | addCritical()      | Critical conditions                         | Application component unavailable, unexpected exception                                            |
| Alert     | ```\Monolog\Logger::ALERT```     |  550     | addAlert()         | Action must be taken immediately            | Entire website down, database unavailable, etc. This should trigger the SMS alerts and wake you up |
| Emergency | ```\Monolog\Logger::EMERGENCY``` |  600     | addEmergency()     | Urgent alert                                | This is only bumped when API breaks are done and should follow the major version of the library    |

#### \<log message\>:
Sugestion with max length? Others sugestions?

## License
MIT License
