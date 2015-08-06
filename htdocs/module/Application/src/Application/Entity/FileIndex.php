<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\Common\Collections\Collection;

/** 
 * @ORM\Entity
 * @Table(name="file_index")
 */
class FileIndex extends EntityAbstract
{
     public static $columns = array('id', 'type', 'status', 'created_at', 'updated_at');
    
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;
    
    

    
    /** @ORM\Column(type="string", name="type") */
    protected $type;
    
    /** @ORM\Column(type="string", name="status") */
    protected $status;
    
    
    /** @ORM\Column(type="datetime", name="created_at") */
    protected $createdAt;
    
    /** @ORM\Column(type="datetime", name="updated_at") */
    protected $updatedAt;
    

    
    
    public function getSendeFile()
    {
        return $this->sendeFile;
    }

    public function setSendeFile($sendeFile)
    {
        $this->sendeFile = $sendeFile;
    }

        
    
    public function getArchiveFile()
    {
        return $this->archiveFile;
    }

    public function setArchiveFile($archiveFile)
    {
        $this->archiveFile = $archiveFile;
    }

        
    
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        if (!$updatedAt instanceof \DateTime) {
            $updatedAt = new \DateTime($updatedAt);
        }
        $this->updatedAt = $updatedAt;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    public function getFkId()
    {
        return $this->fkId;
    }

    public function setFkId($fkId)
    {
        $this->fkId = $fkId;
    }

    public function getColumns()
    {
        if (!isset(self::$columns)) {
            return array();
        }
        
        return self::$columns;
    }

}
