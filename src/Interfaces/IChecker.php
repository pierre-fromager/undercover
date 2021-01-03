<?php

declare(strict_types=1);

namespace PierInfor\Undercover\Interfaces;

use PierInfor\Undercover\Checker;

interface IChecker
{
    const STARS = '*** ';
    const TITLE = 'Undercover coverage checker';
    const XPATH_SEARCH = '//class';
    const _ELEMENTS = 'elements';
    const COVERED_ELEMENTS = 'coveredelements';
    const COVERED_METHODS = 'coveredmethods';
    const COVERED_STATEMENTS = 'coveredstatements';
    const MSG_FORMAT = '*   %-12s %02.2f%% %s %02.2f%% %s';

    public function run(): Checker;
}
