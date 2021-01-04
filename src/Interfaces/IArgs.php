<?php

declare(strict_types=1);

namespace PierInfor\Undercover\Interfaces;

/**
 * IArgs is interface for Args class
 *
 * @author Pierre Fromager <info@pier_infor.fr>
 * @version 1.0
 * @package PierInfor\Undercover
 */
interface IArgs
{
    const DEFAULT_FILENAME = 'build/logs/clover.xml';
    const ERR_MSG_MISSING_FILENAME = 'First argument should contain filename';
    const _F = 'f';
    const _FILE = 'file';
    const _L = 'l';
    const _LINES = 'lines';
    const _M = 'm';
    const _METHODS = 'methods';
    const _S = 's';
    const _STATEMENTS = 'statements';
    const _C = 'c';
    const _CLASSES = 'classes';
    const _B = 'b';
    const _BLOCKING = 'blocking';
    const _DESC = ':';
    const SOPTS = 'f:l:m:s:c:b::';
    const DEFAULT_THRESHOLD = 50;

    public function getFilename(): string;
    public function getThresholds(): array;
}
