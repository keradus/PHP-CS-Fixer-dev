<?php

/*
 * This file is part of PHP CS Fixer Dev.
 *
 * (c) Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

$header = <<<'EOF'
    This file is part of PHP CS Fixer Dev.

    (c) Dariusz Rumiński <dariusz.ruminski@gmail.com>

    This source file is subject to the MIT license that is bundled
    with this source code in the file LICENSE.
    EOF;

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->append([__FILE__, __DIR__.'/php-cs-fixer-dev'])
;

$config = (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PHP74Migration' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        'header_comment' => ['header' => $header],
        'list_syntax' => ['syntax' => 'long'],
    ])
    ->setFinder($finder)
;

return $config;
