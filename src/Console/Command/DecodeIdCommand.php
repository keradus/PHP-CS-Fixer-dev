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

use PhpCsFixer\Tokenizer\Token;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 */
final class DecodeIdCommand extends Command
{
    protected static $defaultName = 'decode-id';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setDefinition(
                [
                    new InputArgument('id', InputArgument::REQUIRED),
                ]
            )
            ->setDescription('Get symbolic name of token id.')
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

        $id = $input->getArgument('id');

        if (1 !== preg_match('/^\d+$/', $id)) {
            $stdErr->writeln('<error>Non-numeric "id" value.</error>');

            return 1;
        }

        $name = Token::getNameForId($id);
        if (null === $name) {
            $stdErr->writeln('<error>Unknown "id".</error>');

            return 1;
        }

        $output->writeln($name);
    }
}
