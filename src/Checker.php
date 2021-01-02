<?php

declare(strict_types=1);

namespace PierInfor\Undercover;

use PierInfor\Undercover\Interfaces\IChecker;
use PierInfor\Undercover\Args;

class Checker implements IChecker
{

    protected $cloverArgs;
    protected $filename;
    protected $content;
    protected $error;
    protected $results;
    protected $thresholds;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->cloverArgs = new Args();
        $this->init();
    }

    /**
     * runner
     *
     * @return Checker
     */
    public function run(): Checker
    {
        if (!empty($this->content)) {
            $this->parse()->check();            
        }
        return $this;
    }

    /**
     * initializer
     *
     * @return Checker
     */
    protected function init(): Checker
    {
        $this->filename = $this->cloverArgs->getFilename();
        $this->setContent();
        $this->error = false;
        $this->thresholds = $this->cloverArgs->getThresholds();
        $this->results = [];
        return $this;
    }

    /**
     * parser
     *
     * @return Checker
     */
    protected function parse(): Checker
    {
        $xml = new \SimpleXMLElement($this->content);
        $metrics = $xml->project->metrics;
        $classes = $xml->xpath(self::XPATH_SEARCH);
        $coveredClasses = 0;
        foreach ($classes as $class) {
            $methods = (int) $class->metrics[Args::_METHODS];
            $areMethodsCovered = ($methods > 0
                && $methods === (int) $class->metrics[self::COVERED_METHODS]);
            if ($areMethodsCovered) {
                $coveredClasses++;
            }
        }
        $this->setResults($coveredClasses, $metrics);
        return $this;
    }

    /**
     * checker
     * 
     * @todo implemention
     * @return Checker
     */
    protected function check(): Checker
    {
        foreach ($this->results as $k => $v) {
            var_dump(
                $k . '->' . $this->thresholds[$k] . '->' . $v
            );
        }
        return $this;
    }

    /**
     * set results
     *
     * @param integer $coveredClasses
     * @param \SimpleXMLElement $metrics
     * @return Checker
     */
    protected function setResults(int $coveredClasses, \SimpleXMLElement $metrics): Checker
    {
        $this->results = [
            Args::_LINES => $this->getElementsRatio($metrics),
            Args::_METHODS => $this->getMethodsRatio($metrics),
            Args::_STATEMENTS => $this->getStatementsRatio($metrics),
            Args::_CLASSES => $this->getClassesRatio(
                $coveredClasses,
                $metrics
            )
        ];
        return $this;
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
            ? $mets[self::COVERED_ELEMENTS] / $mets[self::_ELEMENTS] * 100
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
        return isset($mets[Args::_METHODS])
            ? $mets[self::COVERED_METHODS] / $mets[Args::_METHODS] * 100
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
        return isset($mets[Args::_STATEMENTS])
            ? $this->getRatio(
                (float) $mets[self::COVERED_STATEMENTS],
                (float) $mets[Args::_STATEMENTS]
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
        return isset($mets[Args::_CLASSES])
            ? $this->getRatio(
                (float) $coveredClasses,
                (float) $mets[Args::_CLASSES]
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
        return ($min / $max) * 100;
    }

    /**
     * set content from file
     *
     * @return Checker
     */
    protected function setContent(): Checker
    {
        $this->content = ($this->exists())
            ? file_get_contents($this->filename)
            : '';
        return $this;
    }

    /**
     * returns true if ile exists
     *
     * @return boolean
     */
    protected function exists(): bool
    {
        return file_exists($this->filename);
    }
}
