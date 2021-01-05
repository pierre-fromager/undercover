<?php

declare(strict_types=1);

namespace PierInfor\Undercover;

use PierInfor\Undercover\Interfaces\IProcessor;
use PierInfor\Undercover\Interfaces\IArgs;

/**
 * Processor is a clover coverage processor
 *
 * @author Pierre Fromager <info@pier_infor.fr>
 * @version 1.0
 * @package PierInfor\Undercover
 */
class Processor implements IProcessor
{

    protected $results;
    protected $parser;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * initializer
     *
     * @return IProcessor
     */
    protected function init(): IProcessor
    {
        $this->results = [];
        return $this;
    }

    /**
     * process datas from parser and return a processor instance
     *
     * @return IProcessor
     */
    public function process(int $coveredClasses, \SimpleXMLElement $metrics): IProcessor
    {
        $this->results = [
            IArgs::_LINES => $this->getElementsRatio($metrics),
            IArgs::_METHODS => $this->getMethodsRatio($metrics),
            IArgs::_STATEMENTS => $this->getStatementsRatio($metrics),
            IArgs::_CLASSES => $this->getClassesRatio(
                $coveredClasses,
                $metrics
            )
        ];
        return $this;
    }

    /**
     * return process results
     *
     * @return array
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * returns lines coverage ratio as float
     *
     * @param \SimpleXMLElement $mets
     * @return float
     */
    protected function getElementsRatio(\SimpleXMLElement $mets): float
    {
        return isset($mets[self::_ELEMENTS])
            ? $this->getRatio(
                (float) $mets[self::COVERED_ELEMENTS],
                (float) $mets[self::_ELEMENTS]
            )
            : 0;
    }

    /**
     * returns methods coverage ratio as float
     *
     * @param \SimpleXMLElement $mets
     * @return float
     */
    protected function getMethodsRatio(\SimpleXMLElement $mets): float
    {
        return isset($mets[IArgs::_METHODS])
            ? $this->getRatio(
                (float) $mets[self::COVERED_METHODS],
                (float) $mets[IArgs::_METHODS]
            )
            : 0;
    }

    /**
     * returns statements coverage ratio as float
     *
     * @param \SimpleXMLElement $mets
     * @return float
     */
    protected function getStatementsRatio(\SimpleXMLElement $mets): float
    {
        return isset($mets[IArgs::_STATEMENTS])
            ? $this->getRatio(
                (float) $mets[self::COVERED_STATEMENTS],
                (float) $mets[IArgs::_STATEMENTS]
            )
            : 0;
    }

    /**
     * returns classes coverage ratio as float
     *
     * @param integer $coveredClasses
     * @param \SimpleXMLElement $mets
     * @return float
     */
    protected function getClassesRatio(int $coveredClasses, \SimpleXMLElement $mets): float
    {
        return isset($mets[IArgs::_CLASSES])
            ? $this->getRatio(
                (float) $coveredClasses,
                (float) $mets[IArgs::_CLASSES]
            )
            : 0;
    }

    /**
     * return ratio computation as float
     *
     * @param float $min
     * @param float $max
     * @return float
     */
    protected function getRatio(float $min, float $max): float
    {
        if ($max == 0) {
            $max = INF;
        }
        return ($min / $max) * 100;
    }
}
