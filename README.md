# Colorized logs in interactive shells.

Quickly understand the severity of some logged actions without having to read everything line by line.

## Installation

Install this package via composer into your application and configure for the
`stderr` log channel by tapping it as described at [customizing
monolog](https://laravel.com/docs/11.x/logging#customizing-monolog-for-channels):

```sh
composer require dallyger/laravel-ansi-logger
```

```diff
  // config/logging.php

  'stderr' => [
      'driver' => 'monolog',
      'level' => env('LOG_LEVEL', 'debug'),
+     'tap' => [\Dallyger\AnsiLogger\CustomizeChannel::class],
      'formatter' => env('LOG_STDERR_FORMATTER'),
      // ...
  ],
```

Make sure to actually use the `stderr` logger by either updating your default
channel, adding it to the stack channel or setting the `LOG_CHANNEL`
environment variable.

## Source Code

The project is licensed under MIT and the source code is available at:

- <https://codeberg.org/dallyger/laravel-ansi-logger>
- <https://github.com/dallyger/laravel-ansi-logger>
