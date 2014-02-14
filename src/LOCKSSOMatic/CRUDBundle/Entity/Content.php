<?php

namespace LOCKSSOMatic\CRUDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Content
 *
 * @ORM\Table(name="content", indexes={@ORM\Index(name="content_providers_id_idx", columns={"content_providers_id"}), @ORM\Index(name="deposits_id_idx", columns={"deposits_id"})})
 * @ORM\Entity
 */
class Content
{
	/**
	* Property required for many-to-one relationship with Deposits.
	* 
	* @ManyToOne(targetEntity="Deposits", mappedBy="content")
	* @JoinColumn(name="deposits_id", referencedColumnName="id")
	*/
	protected $deposit;

	/**
	* Property required for many-to-one relationship with Deposits.
	* 
	* @ManyToOne(targetEntity="Aus", mappedBy="content")
	* @JoinColumn(name="aus_id", referencedColumnName="id")
	*/
	protected $au;

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
     * @ORM\Column(name="deposits_id", type="integer", nullable=true)
     */
    private $depositsId;

    /**
     * @var integer
     *
     * @ORM\Column(name="aus_id", type="integer", nullable=true)
     */
    private $ausId;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="text", nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text", nullable=true)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="size", type="integer", nullable=true)
     */
    private $size;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_deposited", type="datetime", nullable=true)
     */
    private $dateDeposited;

    /**
     * @var string
     *
     * @ORM\Column(name="checksum_type", type="text", nullable=true)
     */
    private $checksumType;

    /**
     * @var string
     *
     * @ORM\Column(name="checksum_value", type="text", nullable=true)
     */
    private $checksumValue;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="recrawl", type="integer", nullable=true)
     */
    private $recrawl;

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
     * Set depositsId
     *
     * @param integer $depositsId
     * @return Content
     */
    public function setDepositsId($depositsId)
    {
        $this->depositsId = $depositsId;

        return $this;
    }

    /**
     * Get depositsId
     *
     * @return integer 
     */
    public function getDepositsId()
    {
        return $this->depositsId;
    }

    /**
     * Set ausId
     *
     * @param integer $ausId
     * @return Content
     */
    public function setAusId($ausId)
    {
        $this->ausId = $ausId;

        return $this;
    }

    /**
     * Get ausId
     *
     * @return integer 
     */
    public function getAusId()
    {
        return $this->ausId;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Content
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
     * Set title
     *
     * @param string $title
     * @return Content
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set size
     *
     * @param integer $size
     * @return Content
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set dateDeposited
     *
     * @param \DateTime $dateDeposited
     * @return Content
     */
    public function setDateDeposited($dateDeposited)
    {
        $this->dateDeposited = new \DateTime();

        return $this;
    }

    /**
     * Get dateDeposited
     *
     * @return \DateTime 
     */
    public function getDateDeposited()
    {
        return $this->dateDeposited;
    }

    /**
     * Set checksumType
     *
     * @param string $checksumType
     * @return Content
     */
    public function setChecksumType($checksumType)
    {
        $this->checksumType = $checksumType;

        return $this;
    }

    /**
     * Get checksumType
     *
     * @return string 
     */
    public function getChecksumType()
    {
        return $this->checksumType;
    }

    /**
     * Set checksumValue
     *
     * @param string $checksumValue
     * @return Content
     */
    public function setChecksumValue($checksumValue)
    {
        $this->checksumValue = $checksumValue;

        return $this;
    }

    /**
     * Get checksumValue
     *
     * @return string 
     */
    public function getChecksumValue()
    {
        return $this->checksumValue;
    }

    /**
     * Set recrawl
     *
     * @param integer $recrawl
     * @return Content
     */
    public function setRecrawl($recrawl)
    {
        $this->recrawl = $recrawl;

        return $this;
    }

    /**
     * Get recrawl
     *
     * @return integer
     */
    public function getRecrawl()
    {
        return $this->recrawl;
    }
}
