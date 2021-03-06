<?php

declare(strict_types=1);

namespace PierInfor\Undercover;

use PierInfor\Undercover\Interfaces\IArgs;

/**
 * Args is a command line argument checker
 *
 * @author Pierre Fromager <info@pier_infor.fr>
 * @package PierInfor\Undercover
 * @version 1.0
 */
class Args implements IArgs
{

    protected $_filename;
    protected $_options;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->setOptions();
    }

    /**
     * return filename from params
     *
     * @return string
     */
    public function getFilename(): string
    {
        if ($this->hasOption(self::_F)) {
            return $this->_options[self::_F];
        }
        if ($this->hasOption(self::_FILE)) {
            return $this->_options[self::_FILE];
        }
        return self::DEFAULT_FILENAME;
    }

    /**
     * return thresholds from params
     *
     * @return array
     */
    public function getThresholds(): array
    {
        return [
            self::_LINES => (float) $this->getThresholdByKeys(
                self::_L,
                self::_LINES
            ),
            self::_METHODS => (float) $this->getThresholdByKeys(
                self::_M,
                self::_METHODS
            ),
            self::_STATEMENTS => (float) $this->getThresholdByKeys(
                self::_S,
                self::_STATEMENTS
            ),
            self::_CLASSES => (float) $this->getThresholdByKeys(
                self::_C,
                self::_CLASSES
            ),
        ];
    }

    /**
     * return true if blocking option was set
     *
     * @return bool
     */
    public function isBlocking(): bool
    {
        if ($this->hasOption(self::_B)) {
            return $this->_options[self::_B];
        }
        if ($this->hasOption(self::_BLOCKING)) {
            return $this->_options[self::_BLOCKING];
        }
        return false;
    }

    /**
     * set options
     *
     * @param array $opts
     * @return Args
     */
    protected function setOptions(array $opts = []): Args
    {
        $this->_options = (empty($opts))
            ? getopt(self::SOPTS, [
                self::_FILE . self::_DESC,
                self::_LINES . self::_DESC,
                self::_METHODS . self::_DESC,
                self::_STATEMENTS . self::_DESC,
                self::_CLASSES . self::_DESC,
                self::_BLOCKING . self::_DESC . self::_DESC,
            ])
            : $opts;
        return $this;
    }

    /**
     * return threshold from both short and long options
     *
     * @param string $kshort
     * @param string $klong
     * @return float
     */
    protected function getThresholdByKeys(string $kshort, string $klong): float
    {
        if ($this->hasOption($kshort)) {
            return $this->floatOption($kshort);
        }
        if ($this->hasOption($klong)) {
            return $this->floatOption($klong);
        }
        return $this->getDefaultThreshold();
    }

    /**
     * return true if option was set
     *
     * @param string $key
     * @return boolean
     */
    protected function hasOption(string $key): bool
    {
        return isset($this->_options[$key]);
    }

    /**
     * returns float threshold value from key arg
     *
     * @param string $key
     * @return float
     */
    protected function floatOption(string $key): float
    {
        return ($this->hasOption($key))
            ? (float) $this->_options[$key]
            : 0;
    }

    /**
     * return default threshold value
     *
     * @return float
     */
    protected function getDefaultThreshold(): float
    {
        return (float) self::DEFAULT_THRESHOLD;
    }
}
