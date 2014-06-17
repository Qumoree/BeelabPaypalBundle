<?php

namespace Beelab\PaypalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\MappedSuperclass
 */
class Transaction
{
    const STATUS_KO      = -1;
    const STATUS_STARTED = 0;
    const STATUS_OK      = 1;

    public static $statuses = array(
        self::STATUS_STARTED => 'started',
        self::STATUS_OK      => 'success',
        self::STATUS_KO      => 'failed',
    );

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $end;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", options={"default": 0})
     */
    protected $status = self::STATUS_STARTED;

    /**
     * @var string
     *
     * @ORM\Column(unique=true)
     */
    protected $token;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=6, scale=2, options={"default": 0})
     */
    protected $amount = 0;

    /**
     * @var string
     *
     * @ORM\Column(type="array")
     */
    protected $response;

    /**
     * Costruttore
     *
     * @param string $amount
     */
    public function __construct($amount = null)
    {
        $this->amount = $amount;
        $this->start = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set status
     *
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $status;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getStatusLabel()
    {
        return isset(static::$statuses[$this->status]) ? static::$statuses[$this->status] : 'invalid';
    }

    /**
     * Set token
     *
     * @param  string      $token
     * @return Transaction
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get response
     *
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Complete transaction
     *
     * @param string $response
     */
    public function complete($response)
    {
        $this->status = self::STATUS_OK;
        $this->end = new \DateTime();
        $this->response = $response;
    }

    /**
     * Cancel transaction
     *
     * @param string $response
     */
    public function cancel($response)
    {
        $this->status = self::STATUS_KO;
        $this->end = new \DateTime();
        $this->response = $response;
    }
}