<?php

declare(strict_types=1);

namespace PierInfor\Undercover\Interfaces;

use PierInfor\Undercover\Checker;

interface IChecker
{
    const XPATH_SEARCH = '//class';
    const _ELEMENTS = 'elements';
    const COVERED_ELEMENTS = 'coveredelements';
    const COVERED_METHODS = 'coveredmethods';
    const COVERED_STATEMENTS = 'coveredstatements';

    public function run(): Checker;
}
