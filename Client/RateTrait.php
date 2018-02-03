<?php

namespace Aurora\Http\Connection\Client;

trait RateTrait
{
    /**
     * @var int
     */
    protected $readCount = 0;
    /**
     * @var int
     */
    protected $readRate = 0;
    /**
     * @var int
     */
    protected $writeCount = 0;
    /**
     * @var int
     */
    protected $writeRate = 0;
    /**
     * @var int
     */
    protected $writeRateLimit = 0;

    /**
     * @return int
     */
    public function getReadCount()
    {
        return $this->readCount;
    }

    /**
     * @return int
     */
    public function getReadRate()
    {
        return $this->readRate;
    }

    /**
     * Returns a average value of write data speed every second.
     *
     * @return float
     */
    public function getAverageWriteRate()
    {
        return $this->writeCount / $this->writeTimeSpend;
    }

    /**
     * @return int
     */
    public function getWriteCount()
    {
        return $this->writeCount;
    }

    /**
     * @return int
     */
    public function getWriteRate()
    {
        return $this->writeRate;
    }

    /**
     * @return int
     */
    public function getWriteRateLimit()
    {
        return $this->writeRateLimit;
    }
}