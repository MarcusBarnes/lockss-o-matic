<?php

namespace LOCKSSOMatic\CRUDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Aus
 *
 * @ORM\Table(name="aus", indexes={@ORM\Index(name="plns_id_idx", columns={"plns_id"})})
 * @ORM\Entity
 */
class Aus
{
	/**
	 * Property required for one-to-many relationship with Content.
	 * 
	 * @OneToMany(targetEntity="Content", mappedBy="content")
	 */
	protected $content;

	/**
	 * Initializes the $collectionowner property.
	 */
	public function __construct()
	{
		$this->content = new ArrayCollection();
	}
	
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="plns_id", type="integer", nullable=true)
     */
    private $plnsId;

    /**
     * @var integer
     *
     * @ORM\Column(name="exteranl_title_dbs_id", type="integer", nullable=true)
     */
    private $externalTitleDbsId;

    /**
     * @var string
     *
     * @ORM\Column(name="auid", type="text", nullable=true)
     */
    private $auid;

    /**
     * @var string
     *
     * @ORM\Column(name="manifest_url", type="text", nullable=true)
     */
    private $manifestUrl;

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
     * Set plnsId
     *
     * @param integer $plnsId
     * @return Aus
     */
    public function setPlnsId($plnsId)
    {
        $this->plnsId = $plnsId;

        return $this;
    }

    /**
     * Get plnsId
     *
     * @return integer 
     */
    public function getPlnsId()
    {
        return $this->plnsId;
    }

    /**
     * Get externalTitleDbsId
     *
     * @return integer 
     */
    public function getExternalTitleDbsId()
    {
        return $this->externalTitleDbsId;
    }
    
    /**
     * Set externalTitleDbsId
     *
     * @param integer $exteralTitleDbsId
     * @return Aus
     */
    public function setExternalTitleDbsId($externalTitleDbsId)
    {
        $this->plnsId = $plnsId;

        return $this;
    }

    /**
     * Set auid
     *
     * @param string $auid
     * @return Aus
     */
    public function setAuid($auid)
    {
        $this->auid = $auid;

        return $this;
    }

    /**
     * Get auid
     *
     * @return string 
     */
    public function getAuid()
    {
        return $this->auid;
    }

    /**
     * Set manifestUrl
     *
     * @param string $manifestUrl
     * @return Aus
     */
    public function setManifestUrl($manifestUrl)
    {
        $this->manifestUrl = $manifestUrl;

        return $this;
    }

    /**
     * Get manifestUrl
     *
     * @return string 
     */
    public function getManifestUrl()
    {
        return $this->manifestUrl;
    }
}
