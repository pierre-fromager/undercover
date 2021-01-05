<?php

declare(strict_types=1);

namespace PierInfor\Undercover\Interfaces;

use PierInfor\Undercover\Interfaces\IArgs;

/**
 * IParser is interface for Checker class
 *
 * @author Pierre Fromager <info@pier_infor.fr>
 * @version 1.0
 * @package PierInfor\Undercover
 */
interface IParser
{
    const XPATH_SEARCH = '//class';

    public function parse(): IParser;
    public function getResults(): array;
    public function getArgs(): IArgs;
}
