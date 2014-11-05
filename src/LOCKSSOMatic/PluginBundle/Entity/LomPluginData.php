<?php

namespace LOCKSSOMatic\PluginBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LomPluginData
 */
class LomPluginData
{
    /**
     * @var integer
     */
    private $id;


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
     * @var string
     */
    private $domain;

    /**
     * @var integer
     */
    private $objectId;

    /**
     * @var string
     */
    private $datakey;

    /**
     * @var \stdClass
     */
    private $value;

    /**
     * Set domain
     *
     * @param string $domain
     * @return LomPluginData
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return string 
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set objectId
     *
     * @param integer $objectId
     * @return LomPluginData
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;

        return $this;
    }

    /**
     * Get objectId
     *
     * @return integer 
     */
    public function getObjectId()
    {
        return $this->objectId;
    }

    /**
     * Set value
     *
     * @param \stdClass $value
     * @return LomPluginData
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return \stdClass 
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * @var string
     */
    private $plugin;


    /**
     * Set plugin
     *
     * @param string $plugin
     * @return LomPluginData
     */
    public function setPlugin($plugin)
    {
        $this->plugin = $plugin;

        return $this;
    }

    /**
     * Get plugin
     *
     * @return string 
     */
    public function getPlugin()
    {
        return $this->plugin;
    }

    /**
     * Set datakey
     *
     * @param string $datakey
     * @return LomPluginData
     */
    public function setDatakey($datakey)
    {
        $this->datakey = $datakey;

        return $this;
    }

    /**
     * Get datakey
     *
     * @return string 
     */
    public function getDatakey()
    {
        return $this->datakey;
    }
}
