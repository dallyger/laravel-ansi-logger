<?php

namespace Dallyger\AnsiLogger;

use Illuminate\Log\Logger;

class CustomizeChannel
{
    /**
     * Customize the given logger instance.
     */
    public function __invoke(Logger $logger): void
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(
                new AnsiLineFormatter(
                    dateFormat: 'Y-m-d H:i:s',
                    allowInlineLineBreaks: true,
                    ignoreEmptyContextAndExtra: true,
                    includeStacktraces: true,
                )
            );
        }
    }
}
