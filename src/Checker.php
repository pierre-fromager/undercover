<?php

declare(strict_types=1);

namespace PierInfor\Undercover;

use PierInfor\Undercover\Interfaces\IChecker;
use PierInfor\Undercover\Parser;

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
    protected $filename;
    protected $thresholds;
    protected $results;
    protected $error;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->parser = new Parser();
        $this->init();
    }

    /**
     * destructor
     */
    public function __destruct()
    {
        $this->parser = null;
    }

    /**
     * runner
     *
     * @return int
     */
    public function run(): int
    {
        $this->check();
        return ($this->error && $this->isBlocking())
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
        $this->thresholds = $this->parser->getArgs()->getThresholds();
        $this->results = [];
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
            echo self::TITLE;
            $errCount = 0;
            foreach ($results as $k => $v) {
                $valid = $v >= $this->thresholds[$k];
                if (!$valid) {
                    ++$errCount;
                }
                echo PHP_EOL . $this->getMsgLine($k, $v, $valid);
            }
            echo PHP_EOL . self::T_BEFORE;
            $this->error = ($errCount > 0);
        }
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
}
