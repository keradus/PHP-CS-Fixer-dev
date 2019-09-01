<?php

/*
 * This file is part of PHP CS Fixer Dev.
 *
 * (c) Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Keradus\PhpCsFixerDev\Console;

use Keradus\PhpCsFixerDev\Console\Command\DecodeIdCommand;
use Keradus\PhpCsFixerDev\Console\Command\TokenizeCommand;
use Symfony\Component\Console\Application as BaseApplication;

/**
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 */
final class Application extends BaseApplication
{
    public function __construct()
    {
        parent::__construct('PHP CS Fixer Dev', 'dev');

        $this->add(new DecodeIdCommand());
        $this->add(new TokenizeCommand());
    }
}
