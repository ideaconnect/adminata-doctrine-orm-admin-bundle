<?php

declare(strict_types=1);

/*
 * This file is part of the adminata package.
 *
 * (c) IDCT Bartosz Pachołek <bartosz@idct.tech>
 *
 * Forked from the Sonata Project
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * The test harness adminata added when this package left the adminata repository: the database
 * extension and the two support classes the suite used to borrow from adminata's own tests/.
 * Same rules as `.php-cs-fixer.dist.php`, but with the combined header, because these files are
 * ours rather than upstream's.
 */

$header = <<<'HEADER'
    This file is part of the adminata package.

    (c) IDCT Bartosz Pachołek <bartosz@idct.tech>

    Forked from the Sonata Project
    (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>

    For the full copyright and license information, please view the LICENSE
    file that was distributed with this source code.
    HEADER;

$rules = (require __DIR__.'/.php-cs-fixer.rules.php')($header);

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__.'/tests/PHPUnit', __DIR__.'/tests/Support'])
    ->append([
        __DIR__.'/.php-cs-fixer.adminata.php',
        __DIR__.'/.php-cs-fixer.dist.php',
        __DIR__.'/.php-cs-fixer.rules.php',
        __DIR__.'/phpstan-console-application.php',
        __DIR__.'/rector.php',
    ]);

$config = new PhpCsFixer\Config();
$config
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setRules($rules)
    ->setUsingCache(true)
    ->setCacheFile(__DIR__.'/.php-cs-fixer.adminata.cache')
    ->setUnsupportedPhpVersionAllowed(true)
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect());

return $config;
