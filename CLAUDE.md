# CLAUDE.md

## Package Overview

`centrex/laravel-telemetry` — OpenTelemetry support for Laravel applications.

Namespace: `Centrex\Telemetry\`  
Service Provider: `TelemetryServiceProvider`  
Facade: `Facades/`  
Main class: `Telemetry`

## Commands

Run from inside this directory (`cd laravel-telemetry`):

```sh
composer install          # install dependencies
composer test             # full suite: rector dry-run, pint check, phpstan, pest
composer test:unit        # pest tests only
composer test:lint        # pint style check (read-only)
composer test:types       # phpstan static analysis
composer test:refacto     # rector refactor check (read-only)
composer lint             # apply pint formatting
composer refacto          # apply rector refactors
composer analyse          # phpstan (alias)
composer build            # prepare testbench workbench
composer start            # build + serve testbench dev server
```

Run a single test:
```sh
vendor/bin/pest tests/ExampleTest.php
vendor/bin/pest --filter "test name"
```

## Structure

```
src/
  Telemetry.php
  TelemetryServiceProvider.php
  Facades/
  Commands/
  Skeleton.php                  # (legacy skeleton file — may be removed)
  SkeletonServiceProvider.php
config/config.php
tests/
workbench/
```

## Key Concepts

- Integrates OpenTelemetry SDK into Laravel's service container
- Provides tracing, metrics, and logging via OTLP exporters
- Configure exporter endpoint and service name via `config/telemetry.php`

## Conventions

- PHP 8.2+, `declare(strict_types=1)` in all files
- Pest for tests, snake_case test names
- Pint with `laravel` preset
- Rector targeting PHP 8.3 with `CODE_QUALITY`, `DEAD_CODE`, `EARLY_RETURN`, `TYPE_DECLARATION`, `PRIVATIZATION` sets
- PHPStan at level `max` with Larastan
