<?php

/*
 * This file is part of PHP CS Fixer Dev.
 *
 * (c) Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

set_error_handler(function ($severity, $message, $file, $line) {
    if ($severity & error_reporting()) {
        throw new ErrorException($message, 0, $severity, $file, $line);
    }
});

require_once __DIR__.'/vendor/autoload.php';

use PhpCsFixer\Tokenizer\Tokens;

$file = __DIR__.'/src/Console/Application.php';
$source = file_get_contents($file);

$tokens = Tokens::fromCode($source);

// echo $tokens->toJson();
// echo $tokens->generateCode();
