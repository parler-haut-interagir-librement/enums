<?php

// Until the 1.x Castor version the API may be unstable
// this script was tested with Castor 0.22.0

declare(strict_types=1);

use Castor\Attribute\AsTask;

use function Castor\context;
use function Castor\exit_code;
use function Castor\io;
use function Castor\parallel;
use function Castor\run;
use function Castor\task;

// Modify the coverage threshold here
const COVERAGE_THRESHOLD = 10;

function title(string $name): void
{
    $task = task();
    if (null !== $task && $task->getName() === $name) {
        io()->title($task->getDescription());
    }
}

function success(int $exitCode): int
{
    if (0 === $exitCode) {
        io()->success('Done!');
    } else {
        io()->error(sprintf('Failure (exit code %d returned).', $exitCode));
    }

    return $exitCode;
}

function aborted(string $message = 'Aborted'): void
{
    io()->warning($message);
}

#[AsTask(name: 'all', namespace: 'test', description: 'Run all PHPUnit tests', aliases: ['test'])]
function test_all(): int
{
    title('test:all');
    $ec = exit_code(__DIR__ . '/vendor/bin/phpunit');
    io()->writeln('');

    return $ec;
}

#[AsTask(namespace: 'test', description: 'Generate the HTML PHPUnit code coverage report (stored in var/coverage)', aliases: ['coverage'])]
function coverage(): int
{
    title('test:coverage');
    $ec = exit_code('php -d xdebug.enable=1 -d memory_limit=-1 vendor/bin/phpunit --coverage-html=var/coverage --coverage-clover=var/coverage/clover.xml',
        context: context()->withEnvironment(['XDEBUG_MODE' => 'coverage'])
    );
    if (0 !== $ec) {
        return $ec;
    }

    return success(exit_code(sprintf('php bin/coverage-checker.php var/coverage/clover.xml %d', COVERAGE_THRESHOLD)));
}

#[AsTask(namespace: 'test', description: 'Open the PHPUnit code coverage report (var/coverage/index.html)', aliases: ['cov-report'])]
function cov_report(): void
{
    title('test:cov-report');
    success(exit_code('open var/coverage/index.html'));
}

#[AsTask(namespace: 'lint', description: 'Run PHPStan', aliases: ['stan'])]
function stan(): int
{
    title('lint:stan');

    return exit_code('vendor/bin/phpstan analyse --memory-limit 1G -vv');
}

#[AsTask(namespace: 'fix', description: 'Fix PHP files with php-cs-fixer', aliases: ['fix-php'])]
function fix_php(): int
{
    title('fix:fix-php');
    $ec = exit_code('vendor/bin/php-cs-fixer fix',
        context: context()->withEnvironment(['PHP_CS_FIXER_IGNORE_ENV' => 1])
    );

    return success($ec);
}

#[AsTask(name: 'php', namespace: 'lint', description: 'Lint PHP files with php-cs-fixer (report only)', aliases: ['lint-php'])]
function lint_php(): int
{
    title('lint:php');
    $ec = exit_code('vendor/bin/php-cs-fixer fix --dry-run',
        context: context()->withEnvironment(['PHP_CS_FIXER_IGNORE_ENV' => 1])
    );
    io()->newLine();

    return success($ec);
}

#[AsTask(name: 'run', namespace: 'rector', description: 'Run Rector', aliases: ['rector'])]
function rector(): void
{
    title('rector:run');
    success(exit_code('vendor/bin/rector'));
}

#[AsTask(name: 'dry-run', namespace: 'rector', description: 'Run Rector (dry-run)')]
function rector_dry_run(): void
{
    title('rector:dry-run');
    success(exit_code('vendor/bin/rector --dry-run'));
}

#[AsTask(name: 'lint-php', namespace: 'ci', description: 'Lint PHP files with php-cs-fixer (for CI)')]
function ci_lint_php(): int
{
    title('ci:lint-php');

    $ec = exit_code('command -v cs2pr &> /dev/null');
    if (0 !== $ec) {
        aborted('cs2pr not found. Locally, Please use the "lint:php" task.');

        return 1;
    }

    return exit_code('vendor/bin/php-cs-fixer fix --allow-risky=yes --dry-run --format=checkstyle | cs2pr',
        context: context()->withEnvironment(['PHP_CS_FIXER_IGNORE_ENV' => 1])
    );
}

#[AsTask(name: 'all', namespace: 'fix', description: 'Run all CS checks', aliases: ['fix'])]
function fix_all(): int
{
    title('fix:all');
    $ec1 = fix_php();
    io()->newLine();

    return success($ec1);
}


#[AsTask(name: 'all', namespace: 'lint', description: 'Run all lints', aliases: ['lint'])]
function lint_all(): void
{
    title(__FUNCTION__, task());
    parallel(
        fn () => lint_php(),
    );
}

#[AsTask(name: 'all', namespace: 'ci', description: 'Run CI locally', aliases: ['ci'])]
function ci(): void
{
    title('ci:all');
    io()->section('Coverage');
    coverage();
    io()->section('Lints');
    lint_all();
}

#[AsTask(name: 'versions', namespace: 'helpers', description: 'Output current stack versions', aliases: ['versions'])]
function versions(): void
{
    title('helpers:versions');
    io()->note('Castor');
    run('castor --version');
    io()->newLine();

    io()->note('PHP');
    run('php -v');
    io()->newLine();

    io()->note('Composer');
    run('composer --version');
    io()->newLine();

    io()->note('PHPUnit');
    run('vendor/bin/phpunit --version');

    io()->note('PHPStan');
    run('vendor/bin/phpstan --version');
    io()->newLine();

    io()->note('php-cs-fixer');
    exit_code('vendor/bin/php-cs-fixer --version',
        context: context()->withEnvironment(['PHP_CS_FIXER_IGNORE_ENV' => 1])
    );

    io()->newLine();

    success(0);
}
