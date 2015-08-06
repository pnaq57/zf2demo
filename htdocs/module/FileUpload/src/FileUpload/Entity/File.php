<?php
namespace FileUpload\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Doctrine\Common\Collections\Collection;



/** 
 * @ORM\Entity
 * @Table(name="upload_files")
 */
class File extends \Application\Entity\EntityAbstract
{
    public static $columns = array(
        'id',
        'file_name',
        'file_path',
        'rel_path',
        'file_type',
        'deleted',
        'created_at'
    );
    
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;
    
    
    /** @ORM\Column(type="string", name="file_name") */
    protected $fileName;
    
    /** @ORM\Column(type="string", name="file_path") */
    protected $filePath;
    
    /** @ORM\Column(type="string", name="rel_path") */
    protected $relPath;
    
    /** @ORM\Column(type="string", name="file_type") */
    protected $fileType;
    
    /** @ORM\Column(type="integer", name="deleted") */
    protected $deleted = 0;
    
    /** @ORM\Column(type="datetime", name="created_at") */
    protected $createdAt;
    
    /** @ORM\Column(type="datetime", name="updated_at") */
    protected $updatedAt;
    
    
    public function getId()
    {
        return $this->id;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function getFilePath()
    {
        return $this->filePath;
    }
    
    public function getRelPath()
    {
        return $this->relPath;
    }

    public function setRelPath($relPath)
    {
        $this->relPath = $relPath;
    }

    
    public function getFileType()
    {
        return $this->fileType;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    }

    public function setFileType($fileType)
    {
        $this->fileType = $fileType;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function getDeleted()
    {
        return $this->deleted;
    }

    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

                
    
    public function getColumns()
    {
        return self::$columns;
    }
}
