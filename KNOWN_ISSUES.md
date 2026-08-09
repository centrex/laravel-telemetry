# Known Issues — laravel-telemetry

_Last checked: 2026-08-02_

## Failing tests

The entire Pest suite fails to boot — `composer test:unit` (`pest -p`) errors immediately with:

```
Pest\Exceptions\TestCaseClassOrTraitNotFound
The class `VendorName\Skeleton\Tests\TestCase` was not found.
```

Root cause: this package was scaffolded from `laravel-package-skeleton` and the rename from the skeleton's placeholder namespace (`VendorName\Skeleton`) to `Centrex\Telemetry` was never fully completed:

- `src/Skeleton.php` and `src/SkeletonServiceProvider.php` still exist under `namespace VendorName\Skeleton` (dead leftovers — not referenced by `composer.json`'s `extra.laravel.providers`/`aliases`, which correctly point at `Centrex\Telemetry\TelemetryServiceProvider` / `Centrex\Telemetry\Facades\Telemetry`).
- `tests/Pest.php` still does `use VendorName\Skeleton\Tests\TestCase; uses(TestCase::class)->in(__DIR__);`
- `tests/TestCase.php` still declares `namespace VendorName\Skeleton\Tests` and registers `SkeletonServiceProvider::class` (not `TelemetryServiceProvider::class`) in `getPackageProviders()`.

Because of this, none of `tests/ExampleTest.php` or `tests/ArchTest.php` can actually run — the whole suite has effectively never executed successfully since the package was created from the skeleton.

## Style / static-analysis debt

- `vendor/bin/rector --dry-run` reports **6 files** with pending refactors: `src/Facades/Telemetry.php`, `src/SkeletonServiceProvider.php`, `src/TelemetryServiceProvider.php`, `tests/ExampleTest.php`, `tests/TestCase.php` (mostly `AddOverrideAttributeToOverriddenMethodsRector`, `AddVoidReturnTypeWhereNoReturnRector`, `ClosureToArrowFunctionRector`). Run `composer refacto` to apply.
- `vendor/bin/pint --test` reports **2 files**: `src/Telemetry.php`, `src/Skeleton.php` (`single_line_empty_body`). Run `composer lint` to apply.
- PHPStan (`level: max`) reports **2 errors**, and `phpstan-baseline.neon` is empty (0 bytes) so both are live: `boot()` has no return type in both `src/SkeletonServiceProvider.php` and `src/TelemetryServiceProvider.php`.

## TODO / FIXME markers

None found (`grep -rn "TODO\|FIXME" --include="*.php" src/ config/ database/` — no matches).

## Open GitHub issues

Not checked — the `gh` CLI is not installed in this environment.
