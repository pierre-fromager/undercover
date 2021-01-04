<?php

declare(strict_types=1);

namespace PierInfor\Undercover\Interfaces;

use PierInfor\Undercover\Checker;

/**
 * IChecker is interface for Checker class
 *
 * @author Pierre Fromager <info@pier_infor.fr>
 * @version 1.0
 * @package PierInfor\Undercover
 */
interface IChecker
{
    const T_BEFORE = '+----- ';
    const T_AFTER = ' -----+';
    const TITLE = PHP_EOL . self::T_BEFORE
        . 'Undercover coverage checker'
        . self::T_AFTER;
    const _KO = "\e[31mKO\e[0m";
    const _OK = "\e[32mOK\e[0m";
    const XPATH_SEARCH = '//class';
    const _ELEMENTS = 'elements';
    const COVERED_ELEMENTS = 'coveredelements';
    const COVERED_METHODS = 'coveredmethods';
    const COVERED_STATEMENTS = 'coveredstatements';
    const MSG_FORMAT = "|  %-12s \e[94m%02.2f%%\e[0m %s \e[93m%02.2f%%\e[0m %s  |";

    public function run(): Checker;
}
