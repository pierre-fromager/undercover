<?php

declare(strict_types=1);

namespace PierInfor\Undercover\Interfaces;

/**
 * IChecker is interface for Checker class
 *
 * @author Pierre Fromager <info@pier_infor.fr>
 * @version 1.0
 * @package PierInfor\Undercover
 */
interface IChecker
{
    public function run(): int;
}
