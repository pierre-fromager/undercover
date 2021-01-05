<?php

declare(strict_types=1);

namespace PierInfor\Undercover;

use PierInfor\Undercover\Interfaces\IChecker;
use PierInfor\Undercover\Parser;
use PierInfor\Undercover\Reporter;

/**
 * Checker is a clover coverage checker
 *
 * @author Pierre Fromager <info@pier_infor.fr>
 * @version 1.0
 * @package PierInfor\Undercover
 */
class Checker implements IChecker
{

    protected $parser;
    protected $thresholds;
    protected $error;
    protected $reporter;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * runner
     *
     * @return int
     */
    public function run(): int
    {
        $this->check();
        return ($this->getError() && $this->isBlocking())
            ? 1
            : 0;
    }

    /**
     * initializer
     *
     * @return IChecker
     */
    protected function init(): IChecker
    {
        $this->parser = new Parser();
        $this->reporter = new Reporter();
        $this->thresholds = $this->parser->getArgs()->getThresholds();
        $this->error = false;
        return $this;
    }

    /**
     * display msg and set error if under coverage
     *
     * @return IChecker
     */
    protected function check(): IChecker
    {
        if (!empty($results = $this->getResults())) {
            $errCount = 0;
            foreach ($results as $k => $v) {
                $valid = $v >= $this->thresholds[$k];
                if (!$valid) {
                    ++$errCount;
                }
            }
            $this->error = ($errCount > 0);
            $this->reporter->report($results, $this->thresholds);
        }
        return $this;
    }

    /**
     * return parser results
     *
     * @return array
     */
    protected function getResults(): array
    {
        return $this->parser->parse()->getResults();
    }

    /**
     * return true if blocking mode set
     *
     * @return array
     */
    protected function isBlocking(): bool
    {
        return $this->parser->getArgs()->isBlocking();
    }

    /**
     * return true if error happens
     *
     * @return array
     */
    protected function getError(): bool
    {
        return $this->error;
    }
}
