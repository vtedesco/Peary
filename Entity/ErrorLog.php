<?php

namespace Vted\PearyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ErrorLog
 */
class ErrorLog
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $createDate;

    /**
     * @var string
     */
    private $username;

    /**
     * @var integer
     */
    private $userid;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $referer;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $code;


    public function __construct()
    {
        $this->createDate = new \DateTime();
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
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return ErrorLog
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime 
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return ErrorLog
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     * @return ErrorLog
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return integer 
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return ErrorLog
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return ErrorLog
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set referer
     *
     * @param string $referer
     * @return ErrorLog
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;

        return $this;
    }

    /**
     * Get referer
     *
     * @return string 
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return ErrorLog
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return ErrorLog
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }
}
