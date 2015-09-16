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
```php
$logger = (new \Dafiti\Log\Factory())->createInstance('<application name>', '<log path/filename>');
$logger->log(<log level>, '<log message>');
```

#### \<application name\>:
* alice
* bob
* checkout
* payment
* mobileapi
* others

#### \<log path/filename\>:
The logstash will parse the file ... (sugestion of path default instead whatever paths? (infra question?))

#### \<log level\>
| Type      | Usage                            | Log code | Description                                 | Example                                                                                            |
| --------- |--------------------------------- | -------- | ------------------------------------------- | -------------------------------------------------------------------------------------------------- |
| Debug     | ```\Monolog\Logger::DEBUG```     |  100     | Detailed debug information                  |                                                                                                    |
| Info      | ```\Monolog\Logger::INFO```      |  200     | Interesting events                          | User logs in, SQL logs                                                                             |
| Notice    | ```\Monolog\Logger::NOTICE```    |  250     | Uncommon events                             |                                                                                                    |
| Warning   | ```\Monolog\Logger::WARNING```   |  300     | Exceptional occurrences that are not errors | Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong      |
| Error     | ```\Monolog\Logger::ERROR```     |  400     | Runtime errors                              |                                                                                                    |
| Critical  | ```\Monolog\Logger::CRITICAL```  |  500     | Critical conditions                         | Application component unavailable, unexpected exception                                            |
| Alert     | ```\Monolog\Logger::ALERT```     |  550     | Action must be taken immediately            | Entire website down, database unavailable, etc. This should trigger the SMS alerts and wake you up |
| Emergency | ```\Monolog\Logger::EMERGENCY``` |  600     | Urgent alert                                | This is only bumped when API breaks are done and should follow the major version of the library    |

#### \<log message\>:
Sugestion with max length? Others sugestions?

## License
MIT License
