<?php

declare(strict_types=1);

namespace PierInfor\Undercover;

use PierInfor\Undercover\Interfaces\IChecker;
use PierInfor\Undercover\Args;

/**
 * Checker is a coverage cover format file checker
 *
 * @author Pierre Fromager <info@pier_infor.fr>
 * @version 1.0
 * @package PierInfor\Undercover
 */
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
     * @return int
     */
    public function run(): int
    {
        if (!empty($this->getContent())) {
            $this->parse()->check();
        }
        return ($this->error && $this->isBlocking())
            ? 1
            : 0;
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
     * parse xml clover file and set coverage results
     *
     * @return Checker
     */
    protected function parse(): Checker
    {
        $xml = new \SimpleXMLElement($this->getContent());
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
     * returns result metrics coverage ratios as array
     *
     * @return string
     */
    protected function getResults(): array
    {
        return $this->results;
    }

    /**
     * returns coverage file content
     *
     * @return string
     */
    protected function getContent(): string
    {
        return $this->content;
    }

    /**
     * display msg and set error if under coverage
     *
     * @return Checker
     */
    protected function check(): Checker
    {
        echo self::TITLE;
        $errCount = 0;
        foreach ($this->results as $k => $v) {
            $valid = $v >= $this->thresholds[$k];
            if (!$valid) {
                ++$errCount;
            }
            echo PHP_EOL . $this->getMsgLine($k, $v, $valid);
        }
        echo PHP_EOL . self::T_BEFORE;
        $this->error = ($errCount > 0);
        return $this;
    }

    /**
     * return formated msg line
     *
     * @param string $k
     * @param float $v
     * @return string
     */
    protected function getMsgLine(string $k, float $v, bool $valid): string
    {
        return sprintf(
            self::MSG_FORMAT,
            ucfirst($k),
            $v,
            'limit',
            $this->thresholds[$k],
            $valid ? self::_OK : self::_KO
        );
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
        return isset($mets[Args::_METHODS])
            ? $this->getRatio(
                (float) $mets[self::COVERED_METHODS],
                (float) $mets[Args::_METHODS]
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
        if ($max == 0) {
            $max = INF;
        }
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
     * returns true if file exists
     *
     * @return boolean
     */
    protected function exists(): bool
    {
        return file_exists($this->filename);
    }

    /**
     * return true if blocking option was set
     *
     * @return boolean
     */
    protected function isBlocking(): bool
    {
        return $this->cloverArgs->isBlocking();
    }
}
