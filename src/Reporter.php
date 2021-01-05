<?php

declare(strict_types=1);

namespace PierInfor\Undercover;

use PierInfor\Undercover\Interfaces\IReporter;

/**
 * Reporter is a coverage reporter
 *
 * @author Pierre Fromager <info@pier_infor.fr>
 * @version 1.0
 * @package PierInfor\Undercover
 */
class Reporter implements IReporter
{

    protected $results;
    protected $thresholds;
    protected $error;

    /**
     * constructor
     */
    public function __construct()
    {
    }

    /**
     * display report
     *
     * @param array $results
     * @param array $thresholds
     * @return void
     */
    public function report(array $results, array $thresholds): IReporter
    {
        $this->results = $results;
        $this->thresholds = $thresholds;
        if (!empty($this->getResults())) {
            echo $this->getReport();
        }
        return $this;
    }

    /**
     * return results
     *
     * @return array
     */
    protected function getResults(): array
    {
        return is_null($this->results)
            ? []
            : $this->results;
    }

    /**
     * return thresholds
     *
     * @return array
     */
    protected function getThresholds(): array
    {
        return is_null($this->thresholds)
            ? []
            : $this->thresholds;
    }

    /**
     * return report
     *
     * @return string
     */
    protected function getReport(): string
    {
        return sprintf(
            IReporter::REPORT_FORMAT,
            $this->getHeader(),
            $this->getBody(),
            $this->getFooter()
        );
        ;
    }

    /**
     * return header
     *
     * @return string
     */
    protected function getHeader(): string
    {
        return IReporter::HEADER;
    }

    /**
     * return body
     *
     * @return string
     */
    protected function getBody(): string
    {
        $body = '';
        foreach ($this->getResults() as $k => $v) {
            $threshold = $this->getThresholds()[$k];
            $body .= $this->getMsgLine(
                $k,
                $v,
                ($v >= $threshold)
            );
        }
        return $body;
    }

    /**
     * return footer
     *
     * @return string
     */
    protected function getFooter(): string
    {
        return IReporter::T_BEFORE
            . str_repeat('-', \strlen(IReporter::TITLE))
            . IReporter::T_AFTER;
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
            IReporter::MSG_FORMAT,
            ucfirst($k),
            $v,
            IReporter::_LIMIT,
            $this->thresholds[$k],
            $valid ? IReporter::_OK : IReporter::_KO
        );
    }
}
