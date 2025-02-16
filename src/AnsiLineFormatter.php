<?php

declare(strict_types=1);

namespace Dallyger\AnsiLogger;

use Monolog\Formatter\LineFormatter as MonologLineFormatter;
use Monolog\Level;
use Monolog\LogRecord;

class AnsiLineFormatter extends MonologLineFormatter
{
    protected string|null $origFormat = null;

    public function format(LogRecord $record): string
    {
        $this->format = $this->getFormat($this->origFormat ??= $this->format, $record);

        return parent::format($record);
    }

    public function getFormat(string $format, LogRecord $record): string
    {
        $reset = "\033[0m";
        $bold = "\033[1m";
        $underline = "\033[4m";

        $black = "\033[30m";
        $red = "\033[31m";
        $green = "\033[32m";
        $yellow = "\033[33m";
        $blue = "\033[34m";
        $magenta = "\033[35m";
        $cyan = "\033[36m";
        $white = "\033[37m";

        $replacements = match ($record->level) {
            Level::Debug => [
                '/^/' => $black,
                '/%level_name%/' => "{$white}DBUG{$black}",
                '/%message%/' => "{$white}%message%{$black}",
                '/$/D' => $reset,
            ],
            Level::Info => [
                '/^/' => $black,
                '/%level_name%/' => "{$green}INFO{$black}",
                '/%message%/' => "{$white}%message%{$black}",
                '/$/D' => $reset,
            ],
            Level::Notice => [
                '/^/' => $black,
                '/%level_name%/' => "{$blue}NOTI{$black}",
                '/%message%/' => "{$white}%message%{$black}",
                '/$/D' => $reset,
            ],
            Level::Warning => [
                '/^/' => $black,
                '/%level_name%/' => "{$yellow}WARN{$black}",
                '/%message%/' => "{$white}%message%{$black}",
                '/$/D' => $reset,
            ],
            Level::Error => [
                '/^/' => $black,
                '/%level_name%/' => "{$red}FAIL{$black}",
                '/%message%/' => "{$white}%message%{$black}",
                '/$/D' => $reset,
            ],
            Level::Critical => [
                '/^/' => $black.$bold,
                '/%level_name%/' => "{$red}CRIT{$black}",
                '/%message%/' => "{$white}%message%{$black}",
                '/$/D' => $reset,
            ],
            Level::Alert => [
                '/^/' => $black.$bold.$underline,
                '/%level_name%/' => "{$red}ALRM{$black}",
                '/%message%/' => "{$white}%message%{$black}",
                '/$/D' => $reset,
            ],
            Level::Emergency => [
                '/^/' => $black.$bold.$underline,
                '/%level_name%/' => "{$red}EMRG{$black}",
                '/%message%/' => "{$white}%message%{$black}",
                '/$/D' => $reset,
            ],
            default => [],
        };

        return preg_replace(array_keys($replacements), array_values($replacements), $format);
    }
}
