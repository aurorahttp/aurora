<?php

namespace Aurora\Http\Connection\Client;

trait TimeTrait
{
    /**
     * @var int
     */
    protected $createdAt;
    /**
     * @var int
     */
    protected $updatedAt;
    /**
     * @var int
     */
    protected $closedAt = 0;
    /**
     * @var int
     */
    protected $readUpdatedAt;
    /**
     * @var int
     */
    protected $readTimeSpend = 0;
    /**
     * @var int
     */
    protected $writeUpdatedAt;
    /**
     * @var int
     */
    protected $writeTimeSpend = 0;

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return int
     */
    public function getClosedAt()
    {
        return $this->closedAt;
    }

    /**
     * Returns a seconds of the connection's duration from creation to close.
     *
     * @return int
     */
    public function getDuration()
    {
        return $this->closedAt - $this->createdAt;
    }

    /**
     * Returns a average value of read data speed every second.
     *
     * @return float
     */
    public function getAverageReadRate()
    {
        return $this->readCount / $this->readTimeSpend;
    }

    /**
     * @return int
     */
    public function getReadUpdatedAt()
    {
        return $this->readUpdatedAt;
    }

    /**
     * @return int
     */
    public function getReadTimeSpend()
    {
        return $this->readTimeSpend;
    }

    /**
     * @return int
     */
    public function getWriteUpdatedAt()
    {
        return $this->writeUpdatedAt;
    }

    /**
     * @return int
     */
    public function getWriteTimeSpend()
    {
        return $this->writeTimeSpend;
    }
}