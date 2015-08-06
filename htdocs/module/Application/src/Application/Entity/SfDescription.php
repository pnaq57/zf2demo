<?php
namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Doctrine\Common\Collections\Collection;
/** 
 * @ORM\Entity
 * @Table(name="sf_descriptions")
 */
class SfDescription extends EntityAbstract
{
    public static $columns = array('id', 'sf_file_id', 'type', 'language', 'short_description', 'long_description');
    
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;
    
    /** @ORM\Column(type="string", name="sf_file_id") */
    protected $sfFileId;
    
    
    /** @ORM\Column(type="string", name="type") */
    protected $type;
    
    /** @ORM\Column(type="string", name="language") */
    protected $language;
    
    
    /** @ORM\Column(type="string", name="short_description") */
    protected $shortDescription;
    
    /** @ORM\Column(type="string", name="long_description") */
    protected $longDescription;
    
    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\SendeFile", inversedBy="sfDescriptions")
     * @ORM\JoinColumn(name="sf_file_id", referencedColumnName="id")
     **/
    private $sfFile;
    
    
    public function getId()
    {
        return $this->id;
    }

    public function getSfFileId()
    {
        return $this->sfFileId;
    }

    public function getSfFile()
    {
        return $this->sfFile;
    }

    public function setSfFile($sfFile)
    {
        $this->sfFile = $sfFile;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    public function getLongDescription()
    {
        return $this->longDescription;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setSfFileId($sfFileId)
    {
        $this->sfFileId = $sfFileId;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }

    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;
    }

    
    
    public function getColumns()
    {
        if (!isset(self::$columns)) {
            return array();
        }
        
        return self::$columns;
    }
}
