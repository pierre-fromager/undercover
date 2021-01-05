<?php

declare(strict_types=1);

namespace PierInfor\Undercover\Interfaces;

/**
 * IProcessor is interface for Processor class
 *
 * @author Pierre Fromager <info@pier_infor.fr>
 * @version 1.0
 * @package PierInfor\Undercover
 */
interface IProcessor
{
    const _ELEMENTS = 'elements';
    const COVERED_ELEMENTS = 'coveredelements';
    const COVERED_METHODS = 'coveredmethods';
    const COVERED_STATEMENTS = 'coveredstatements';

    public function process(int $coveredClasses, \SimpleXMLElement $metrics): IProcessor;
    public function getResults(): array;
}
