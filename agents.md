# agents.md

## Agent Guidance — laravel-telemetry

### Package Purpose
Integrates OpenTelemetry (OTLP) into Laravel for distributed tracing, metrics, and structured logging. Wraps the OpenTelemetry PHP SDK and exposes it via a Laravel facade.

### Before Making Changes
- Read `src/Telemetry.php` — the main facade target with span/trace/metric methods
- Read `src/TelemetryServiceProvider.php` — how the SDK is initialized and bound
- Read `config/config.php` — exporter endpoint, service name, enabled flag, sampling
- Note: `src/Skeleton.php` / `src/SkeletonServiceProvider.php` are legacy — treat them as dead code unless tests reference them

### Common Tasks

**Adding a new span helper**
1. Add the method to `src/Telemetry.php`
2. Ensure spans are properly started and ended (use try/finally to end spans on exception)
3. Accept context propagation headers as optional parameters for distributed tracing
4. Add tests using an in-memory span exporter

**Adding metrics**
- Use OpenTelemetry's Meter API via the registered `MeterProvider` in the service provider
- Metrics instruments (Counter, Histogram, etc.) should be created once and reused — not per-request
- Register instruments in the service provider, not in `Telemetry.php` methods

**Configuring a new exporter**
- OTLP (gRPC/HTTP) is the default — adding Zipkin or Jaeger exporters should be config-driven
- Add exporter selection to `config/config.php` with a sensible default
- Instantiate the correct exporter in the service provider based on config

### Testing
```sh
composer test:unit        # pest
composer test:types       # phpstan
composer test:lint        # pint
```

Use an in-memory exporter for tests — never send telemetry data to a real endpoint in tests:
```php
// Configure InMemoryExporter in TestCase.php for span assertions
```

### Environment Variables
```env
OTEL_SERVICE_NAME=my-app
OTEL_EXPORTER_OTLP_ENDPOINT=http://localhost:4318
TELEMETRY_ENABLED=true
TELEMETRY_SAMPLING_RATIO=1.0
```

### Safe Operations
- Adding span helper methods to `Telemetry.php`
- Adding new config keys (with defaults)
- Adding metrics instruments

### Risky Operations — Confirm Before Doing
- Changing service provider boot order (telemetry must init before app code runs)
- Changing how context propagation headers are read (breaks distributed tracing)
- Removing the `TELEMETRY_ENABLED` check (forces telemetry even in local/test environments)

### Do Not
- Send real telemetry in tests — use an in-memory exporter
- Swallow span exceptions silently — re-throw after ending the span
- Remove the legacy `Skeleton` files without first confirming no tests depend on them
- Skip `declare(strict_types=1)` in any new file
