<?php

/* 
 * The MIT License
 *
 * Copyright (c) 2014 Mark Jordan, mjordan@sfu.ca.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace LOCKSSOMatic\CRUDBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use LOCKSSOMatic\LoggingBundle\Entity\LogEntry;

/**
 * Plns
 */
class Plns
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $propsPath;

    /**
     * @var Collection
     */
    private $contentProviders;

    /**
     * @var Collection
     */
    private $aus;

    /**
     * @var Collection
     */
    private $plnProperties;

    /**
     * @var Collection
     */
    private $externalTitleDbs;

    /**
     * @var Collection
     */
    private $boxes;

    /**
     * @var string
     */
    private $propServer;

    /**
     * @var Collection
     */
    private $logs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contentProviders = new ArrayCollection();
        $this->aus = new ArrayCollection();
        $this->plnProperties = new ArrayCollection();
        $this->externalTitleDbs = new ArrayCollection();
        $this->boxes = new ArrayCollection();
        $this->logs = new ArrayCollection();
    }

    /**
     * Stringify the entity
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return Plns
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set propsPath
     *
     * @param string $propsPath
     * @return Plns
     */
    public function setPropsPath($propsPath)
    {
        $this->propsPath = $propsPath;

        return $this;
    }

    /**
     * Get propsPath
     *
     * @return string
     */
    public function getPropsPath()
    {
        return $this->propsPath;
    }

    /**
     * Add contentProviders
     *
     * @param ContentProviders $contentProviders
     * @return Plns
     */
    public function addContentProvider(ContentProviders $contentProviders)
    {
        $this->contentProviders[] = $contentProviders;

        return $this;
    }

    /**
     * Remove contentProviders
     *
     * @param ContentProviders $contentProviders
     */
    public function removeContentProvider(ContentProviders $contentProviders)
    {
        $this->contentProviders->removeElement($contentProviders);
    }

    /**
     * Get contentProviders
     *
     * @return Collection
     */
    public function getContentProviders()
    {
        return $this->contentProviders;
    }

    /**
     * Add aus
     *
     * @param Aus $aus
     * @return Plns
     */
    public function addAus(Aus $aus)
    {
        $this->aus[] = $aus;

        return $this;
    }

    /**
     * Remove aus
     *
     * @param Aus $aus
     */
    public function removeAus(Aus $aus)
    {
        $this->aus->removeElement($aus);
    }

    /**
     * Get aus
     *
     * @return Collection
     */
    public function getAus()
    {
        return $this->aus;
    }

    /**
     * Add plnProperties
     *
     * @param PlnProperties $plnProperties
     * @return Plns
     */
    public function addPlnProperty(PlnProperties $plnProperties)
    {
        $this->plnProperties[] = $plnProperties;

        return $this;
    }

    /**
     * Remove plnProperties
     *
     * @param PlnProperties $plnProperties
     */
    public function removePlnProperty(PlnProperties $plnProperties)
    {
        $this->plnProperties->removeElement($plnProperties);
    }

    /**
     * Get plnProperties
     *
     * @return Collection
     */
    public function getPlnProperties()
    {
        return $this->plnProperties;
    }

    /**
     * Add externalTitleDbs
     *
     * @param ExternalTitleDbs $externalTitleDbs
     * @return Plns
     */
    public function addExternalTitleDb(ExternalTitleDbs $externalTitleDbs)
    {
        $this->externalTitleDbs[] = $externalTitleDbs;

        return $this;
    }

    /**
     * Remove externalTitleDbs
     *
     * @param ExternalTitleDbs $externalTitleDbs
     */
    public function removeExternalTitleDb(ExternalTitleDbs $externalTitleDbs)
    {
        $this->externalTitleDbs->removeElement($externalTitleDbs);
    }

    /**
     * Get externalTitleDbs
     *
     * @return Collection
     */
    public function getExternalTitleDbs()
    {
        return $this->externalTitleDbs;
    }

    /**
     * Add boxes
     *
     * @param Boxes $boxes
     * @return Plns
     */
    public function addBox(Boxes $boxes)
    {
        $this->boxes[] = $boxes;

        return $this;
    }

    /**
     * Remove boxes
     *
     * @param Boxes $boxes
     */
    public function removeBox(Boxes $boxes)
    {
        $this->boxes->removeElement($boxes);
    }

    /**
     * Get boxes
     *
     * @return Collection
     */
    public function getBoxes()
    {
        return $this->boxes;
    }

    /**
     * Set propServer
     *
     * @param string $propServer
     * @return Plns
     */
    public function setPropServer($propServer)
    {
        $this->propServer = $propServer;

        return $this;
    }

    /**
     * Get propServer
     *
     * @return string 
     */
    public function getPropServer()
    {
        return $this->propServer;
    }

    /**
     * Add logs
     *
     * @param LogEntry $logs
     * @return Plns
     */
    public function addLog(LogEntry $logs)
    {
        $this->logs[] = $logs;

        return $this;
    }

    /**
     * Remove logs
     *
     * @param LogEntry $logs
     */
    public function removeLog(LogEntry $logs)
    {
        $this->logs->removeElement($logs);
    }

    /**
     * Get logs
     *
     * @return Collection 
     */
    public function getLogs()
    {
        return $this->logs;
    }
}
