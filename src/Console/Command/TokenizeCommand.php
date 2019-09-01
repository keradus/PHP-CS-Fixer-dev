<?php

/*
 * This file is part of PHP CS Fixer Dev.
 *
 * (c) Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Keradus\PhpCsFixerDev\Console\Command;

use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\Utils;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 */
final class TokenizeCommand extends Command
{
    const MODE_NATIVE = 'native';
    const MODE_FIXER = 'fixer';

    const FORMAT_DUMP = 'dump';
    const FORMAT_JSON = 'json';

    protected static $defaultName = 'tokenize';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setDefinition(
                [
                    new InputArgument('path', InputArgument::REQUIRED),
                    new InputOption('mode', null, InputOption::VALUE_REQUIRED, '', self::MODE_FIXER),
                    new InputOption('format', null, InputOption::VALUE_REQUIRED, '', self::FORMAT_JSON),
                ]
            )
            ->setDescription('Tokenize a file.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $stdErr = $output instanceof ConsoleOutputInterface
            ? $output->getErrorOutput()
            : $output
        ;

        $path = $input->getArgument('path');
        $mode = $input->getOption('mode');
        $format = $input->getOption('format');

        if (!\in_array($mode, [self::MODE_FIXER, self::MODE_NATIVE], true)) {
            $stdErr->writeln('<error>Invalid "mode" option.</error>');

            return 1;
        }
        if (!\in_array($format, [self::FORMAT_DUMP, self::FORMAT_JSON], true)) {
            $stdErr->writeln('<error>Invalid "format" option.</error>');

            return 1;
        }

        $code = @file_get_contents($path);

        if (false === $code) {
            $stdErr->writeln('<error>Cannot read file.</error>');

            return 1;
        }

        if (self::MODE_FIXER === $mode) {
            $tokens = Tokens::fromCode($code);
            $tokensJson = $tokens->toJson();
        } else {
            $tokens = \defined('TOKEN_PARSE')
                ? token_get_all($code, TOKEN_PARSE)
                : token_get_all($code);

            $options = Utils::calculateBitmask(['JSON_PRETTY_PRINT', 'JSON_NUMERIC_CHECK']);
            $tokensJson = json_encode(\SplFixedArray::fromArray($tokens), $options);
        }

        if (self::FORMAT_DUMP === $format) {
            $output->writeln(var_dump($tokens));
        } else {
            $output->writeln($tokensJson);
        }
    }
}
