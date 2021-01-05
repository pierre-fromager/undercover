<?php

declare(strict_types=1);

namespace PierInfor\Undercover\Interfaces;

/**
 * IReporter is interface for Reporter class
 *
 * @author Pierre Fromager <info@pier_infor.fr>
 * @version 1.0
 * @package PierInfor\Undercover
 */
interface IReporter
{
    const _LIMIT = 'limit';
    const T_BEFORE = '+-----';
    const T_AFTER = '-----+';
    const TITLE = ' Undercover coverage checker ';
    const HEADER = self::T_BEFORE . self::TITLE . self::T_AFTER;
    const _KO = "\e[31mKO\e[0m";
    const _OK = "\e[32mOK\e[0m";
    const MSG_FORMAT = "\n|  %-12s \e[94m%02.2f%%\e[0m %s \e[93m%02.2f%%\e[0m %s  |";
    const REPORT_FORMAT = "\n%s%s\n%s\n";

    public function report(array $results, array $thresholds): IReporter;
}
