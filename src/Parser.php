<?php

declare(strict_types=1);

namespace PierInfor\Undercover;

use PierInfor\Undercover\Interfaces\IParser;
use PierInfor\Undercover\Interfaces\IArgs;
use PierInfor\Undercover\Args;
use PierInfor\Undercover\Interfaces\IProcessor;
use PierInfor\Undercover\Processor;

/**
 * Parser is a clover coverage parser
 *
 * @author Pierre Fromager <info@pier_infor.fr>
 * @version 1.0
 * @package PierInfor\Undercover
 */
class Parser implements IParser
{

    /**
     * $args
     *
     * @var IArgs
     */
    protected $args;

    /**
     * $content
     *
     * @var string
     */
    protected $content;

    /**
     * processor
     *
     * @var IProcessor
     */
    protected $processor;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->args = new Args();
        $this->processor = new Processor();
        $this->init();
    }

    /**
     * initializer
     *
     * @return IParser
     */
    protected function init(): IParser
    {
        $this->setContent();
        return $this;
    }

    /**
     * parse xml clover file and set coverage results
     *
     * @return IParser
     */
    public function parse(): IParser
    {
        if (!empty($this->getContent())) {
            $xml = new \SimpleXMLElement($this->getContent());
            $metrics = $xml->project->metrics;
            $classes = $xml->xpath(self::XPATH_SEARCH);
            $coveredClasses = 0;
            foreach ($classes as $class) {
                $methods = (int) $class->metrics[Args::_METHODS];
                $coveredMethods = (int) $class->metrics[IProcessor::COVERED_METHODS];
                $areMethodsCovered = ($methods > 0 && $methods === $coveredMethods);
                if ($areMethodsCovered) {
                    $coveredClasses++;
                }
            }
            $this->processor->process($coveredClasses, $metrics);
        }
        return $this;
    }

    /**
     * return parser instance
     *
     * @return IParser
     */
    public function getParser(): IParser
    {
        return $this;
    }

    /**
     * return Args object
     *
     * @return IArgs
     */
    public function getArgs(): IArgs
    {
        return $this->args;
    }

    /**
     * returns result metrics coverage ratios as array
     *
     * @return array
     */
    public function getResults(): array
    {
        return $this->processor->getResults();
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
     * set content from file
     *
     * @return IParser
     */
    protected function setContent(): IParser
    {
        $this->content = ($this->exists())
            ? file_get_contents($this->getFilename())
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
        return file_exists($this->getFilename());
    }

    /**
     * return filename from args
     *
     * @return string
     */
    protected function getFilename(): string
    {
        return $this->args->getFilename();
    }
}
