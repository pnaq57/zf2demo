<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Doctrine\Common\Collections\Collection;


/** 
 * @ORM\Entity
 * @Table(name="sende_files")
 */
class SendeFile extends EntityAbstract
{
    public static $columns = array(
        'id',
        'fk_id',
        'genre',
        'storage',
        'name',
        'hidden',
        'deleted',
        'title',
        'product_year',
        'sport_type',
        'content_tags',
        'run_time',
        'country',
        'licensors',
        'copyright',
        'license_start',
        'license_end',
        'legal_runtime',
        'rating',
        'duration',
        'updated_at',
        'created_at'
    ); 
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;
    
    /**
     * @ORM\OneToOne(targetEntity="Application\Entity\FileIndex")
     * @ORM\JoinColumn(name="fk_id", referencedColumnName="id")
     **/
    protected $fileIndex;
    
    /** @ORM\Column(type="string", name="genre") */
    protected $genre;
    
    /** @ORM\Column(type="string", name="storage") */
    protected $storage;
    
    /** @ORM\Column(type="string", name="name") */
    protected $name;
    
    /** @ORM\Column(type="string", name="title") */
    protected $title;
    
    /** @ORM\Column(type="string", name="product_year") */
    protected $productYear;
    
    /** @ORM\Column(type="string", name="sport_type") */
    protected $sportType;
    
    /** @ORM\Column(type="string", name="content_tags") */
    protected $contentTags;
    
    /** @ORM\Column(type="string", name="run_time") */
    protected $runTime;
    
    /** @ORM\Column(type="string", name="country") */
    protected $country;
    
    /** @ORM\Column(type="string", name="licensors") */
    protected $licensors;
    
    /** @ORM\Column(type="string", name="copyright") */
    protected $copyright;
    
    /** @ORM\Column(type="date", name="license_start") */
    protected $licenseStart;
    
    
    /** @ORM\Column(type="date", name="license_end") */
    protected $licenseEnd;
    
    
    /** @ORM\Column(type="string", name="legal_runtime") */
    protected $legalRuntime;
    
    /** @ORM\Column(type="string", name="rating") */
    protected $rating;
    
    /** @ORM\Column(type="string", name="duration") */
    protected $duration;
    
    /** @ORM\Column(type="datetime", name="updated_at") */
    protected $updatedAt;
    
    /** @ORM\Column(type="datetime", name="created_at") */
    protected $createdAt;
    
    /** @ORM\Column(type="integer", name="hidden") */
    protected $hidden = 0;
    
    /** @ORM\Column(type="integer", name="deleted") */
    protected $deleted = 0;
    
    /**
     * @ORM\ManyToMany(targetEntity="FileUpload\Entity\File")
     * @ORM\JoinTable(name="sf_artwork",
     *      joinColumns={@ORM\JoinColumn(name="sf_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="upload_file_id", referencedColumnName="id")}
     *      )
     **/
    protected $artwork;
    
    /**
     * @ORM\ManyToMany(targetEntity="Application\Entity\Fighter")
     * @ORM\JoinTable(name="sf_fighter",
     *      joinColumns={@ORM\JoinColumn(name="sf_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="fighter_id", referencedColumnName="id")}
     *      )
     **/
    protected $fighters;
    
    
    /**
     * @ORM\OneToMany(targetEntity="Application\Entity\SfDescription", mappedBy="sfFile")
     **/
    protected $sfDescriptions;
    
    public function __construct() {
        $this->artwork = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sfDescriptions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fighters = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function getFileIndex()
    {
        return $this->fileIndex;
    }

    public function getArtwork()
    {
        return $this->artwork;
    }
    
    public function getFighters()
    {
        return $this->fighters;
    }

    public function setFighters($fighters)
    {
        $this->fighters = $fighters;
    }

        
    public function getSfDescriptions()
    {
        return $this->sfDescriptions;
    }

    public function setSfDescriptions($sfDescriptions)
    {
        $this->sfDescriptions = $sfDescriptions;
    }

    
    public function setFileIndex($fileIndex)
    {
        $this->fileIndex = $fileIndex;
    }

    public function setArtwork($artwork)
    {
        $this->artwork = $artwork;
    }

        
    public function getId()
    {
        return $this->id;
    }

    public function getGenre()
    {
        return $this->genre;
    }
    
    public function getStorage()
    {
        return $this->storage;
    }

    public function setStorage($storage)
    {
        $this->storage = $storage;
    }

        
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }


    public function getTitle()
    {
        return $this->title;
    }

    public function getProductYear()
    {
        return $this->productYear;
    }

    public function getSportType()
    {
        return $this->sportType;
    }

    public function getContentTags()
    {
        return $this->contentTags;
    }

    public function getRunTime()
    {
        return $this->runTime;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getLicensors()
    {
        return $this->licensors;
    }

    public function getCopyright()
    {
        return $this->copyright;
    }

    public function getLicenseStart()
    {
        return $this->licenseStart;
    }

    public function getLicenseEnd()
    {
        return $this->licenseEnd;
    }

    public function getLegalRuntime()
    {
        return $this->legalRuntime;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getHidden()
    {
        return $this->hidden;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setProductYear($productYear)
    {
        $this->productYear = $productYear;
    }

    public function setSportType($sportType)
    {
        $this->sportType = $sportType;
    }

    public function setContentTags($contentTags)
    {
        $this->contentTags = $contentTags;
    }

    public function setRunTime($runTime)
    {
        $this->runTime = $runTime;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function setLicensors($licensors)
    {
        $this->licensors = $licensors;
    }

    public function setCopyright($copyright)
    {
        $this->copyright = $copyright;
    }

    public function setLicenseStart($licenseStart)
    {
        if (!$licenseStart instanceof \DateTime) {
            $licenseStart = new \DateTime($licenseStart);
        }
        $this->licenseStart = $licenseStart;
    }

    public function setLicenseEnd($licenseEnd)
    {
        if (!$licenseEnd instanceof \DateTime) {
            $licenseEnd = new \DateTime($licenseEnd);
        }
        $this->licenseEnd = $licenseEnd;
    }

    public function setLegalRuntime($legalRuntime)
    {
        $this->legalRuntime = $legalRuntime;
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function setUpdatedAt($updatedAt)
    {
        if (!$updatedAt instanceof \DateTime) {
            $updatedAt = new \DateTime($updatedAt);
        }
        $this->updatedAt = $updatedAt;
    }

    public function setCreatedAt($createdAt)
    {
        if (!$createdAt instanceof \DateTime) {
            $createdAt = new \DateTime($createdAt);
        }
        $this->createdAt = $createdAt;
    }

    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }
        
    public function getColumns()
    {
        if (!isset(self::$columns)) {
            return array();
        }
        
        return self::$columns;
    }
    
    public function getDeleted()
    {
        return $this->deleted;
    }

    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }


}
