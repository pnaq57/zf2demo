<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
/** 
 * @ORM\Entity
 * @Table(name="file_marker")
 */

class Tape extends EntityAbstract
{
    public static $columns = array('id', 'fk_id', 'action', 'action_from', 'comment');
    
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;
    
    
    /** @ORM\Column(type="integer", name="fk_id") */
    protected $fkId;
    
    /** @ORM\Column(type="string", name="action_from") */
    protected $actionFrom;
    
    
    /** @ORM\Column(type="string", name="action") */
    protected $action;
    
    /** @ORM\Column(type="string", name="comment") */
    protected $comment;
    
    /**
     * @var ArchiveFile|null 
     * @ORM\ManyToOne(targetEntity="Application\Entity\ArchiveFile", inversedBy="tapes")
     * @ORM\JoinColumn(name="fk_id", referencedColumnName="id")
     */
    protected $archiveFile;
    
    
    public function getId()
    {
        return $this->id;
    }

    public function getFkId()
    {
        return $this->fkId;
    }

    public function getActionFrom()
    {
        return $this->actionFrom;
    }

    public function getActionTo()
    {
        return $this->actionTo;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setFkId($archiveFilesId)
    {
        $this->fkId = $archiveFilesId;
    }

    public function setActionFrom($actionFrom)
    {
        $this->actionFrom = $actionFrom;
    }

    public function setActionTo($actionTo)
    {
        $this->actionTo = $actionTo;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function getColumns()
    {
        if (!isset(self::$columns)) {
            return array();
        }
        
        return self::$columns;
    }
    
    public function getArchiveFile()
    {
        return $this->archiveFile;
    }

    public function setArchiveFile(ArchiveFile $archiveFile)
    {
        $this->archiveFile = $archiveFile;
    }
    
    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }


}
