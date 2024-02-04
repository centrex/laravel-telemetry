<?php

declare(strict_types = 1);

namespace Centrex\Telemetry\Commands;

use Illuminate\Console\Command;

class TelemetryCommand extends Command
{
    public $signature = 'laravel-telemetry';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
