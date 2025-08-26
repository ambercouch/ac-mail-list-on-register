<?php

/*
 * This file is part of the Fidry\Console package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare (strict_types=1);
namespace ACSB\Vendor\Fidry\Console\Application;

use ACSB\Vendor\Fidry\Console\Bridge\Command\ReversedSymfonyCommand as BridgeReversedSymfonyCommand;
use ACSB\Vendor\Fidry\Console\Command\ReversedSymfonyCommand as PreviousReversedSymfonyCommand;
use ACSB\Vendor\Fidry\Console\Deprecation;
use function class_alias;
class_alias(BridgeReversedSymfonyCommand::class, PreviousReversedSymfonyCommand::class);
Deprecation::classRenamed(PreviousReversedSymfonyCommand::class, BridgeReversedSymfonyCommand::class, '0.5');
