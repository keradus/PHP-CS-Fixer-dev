<?php

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
