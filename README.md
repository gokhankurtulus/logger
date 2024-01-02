# Logger

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-blue.svg)
![Release](https://img.shields.io/github/v/release/gokhankurtulus/logger.svg)

A simple PHP library for logging.

## Installation

You can install the library using Composer. Run the following command:

```bash
composer require gokhankurtulus/logger
```

## Usage

* [Inheritance](#inheritance)
* [Securing the Logs](#securing-the-logs)

```php
use Logger\Logger;

Logger::setFolderPath(__DIR__ . DIRECTORY_SEPARATOR . 'Logs');
Logger::setFileName('app.log');
Logger::iniSet(true, false, E_ALL);

Logger::log('this is app log message', 'this is log title');
```

Logs/app.log output:

```php
[01-01-2024 15:00:00 - Europe/Istanbul] - this is log title
this is log message
```

## Inheritance

You can inherit from Logger class if you want to categorize your logs.
You must override the `$folderPath` and `$fileName` parameters for conflicts.

```php
class PDOLogger extends \Logger\Logger
{
    protected static string $folderPath = "";
    protected static string $fileName = "";
}
```

```php
use Logger\Logger;

Logger::setFolderPath(__DIR__ . DIRECTORY_SEPARATOR . 'Logs');
Logger::setFileName('app.log');

// for log_errors, display_errors, error_reporting and
// error_log will be Logger::getFolderPath() . DIRECTORY_SEPARATOR . Logger::getFileName()
Logger::iniSet(true, false, E_ALL);

// You can give specific path for classes,
// by default it will be Logger's folder path
PDOLogger::setFolderPath(__DIR__ . DIRECTORY_SEPARATOR . 'DBLogs');
PDOLogger::setFileName('pdo.log');

Logger::log('this is app log message', 'this is log title');
PDOLogger::log('this is pdo log message');
```

Logs/app.log output:

```php
[01-01-2024 15:00:00 - Europe/Istanbul] - this is log title
this is app log message
```

DBLogs/pdo.log output:

```php
[01-01-2024 15:00:00 - Europe/Istanbul] - 
this is pdo log message
```

Public Methods

```php
Logger::log();
Logger::iniSet();
Logger::setFolderPath();
Logger::getFolderPath();
Logger::setFileName();
Logger::getFileName();
```

### Securing the Logs

Log files may contain sensitive information such as database, credentials or other confidential data.
It is important to secure the files and restrict access to prevent unauthorized exposure of this information.
The security of your logs is your responsibility. However, please attention to the following steps;

* Place the log folder outside the public web directory or in directory that is not directly accessible by the web
  server.
* Set file permissions to ensure that only authorized users or processes can read the log files.
* Add the log folder to your project's `.gitignore` file. This ensures that the file is not included in version control
  systems, preventing accidental exposure of sensitive information in your code repository.

## License

Logger is open-source software released under the [MIT License](LICENSE). Feel free to modify and use it in your
projects.

## Contributions

Contributions to Logger are welcome! If you find any issues or have suggestions for improvements, please create
an issue or submit a pull request on the [GitHub repository](https://github.com/gokhankurtulus/logger).