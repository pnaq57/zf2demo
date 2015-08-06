<?php
namespace Application\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Doctrine\Common\Collections\Collection;



/** 
 * @ORM\Entity
 * @Table(name="interview")
 */
class Interview extends EntityAbstract
{
    public static $columns = array(
        'id',
        'archivefile_id',
        'fighter',
        'action_in',
        'action_out',
        'language'
    );
    
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;
    
    
    /** @ORM\Column(type="string", name="fighter") */
    protected $fighter;
    
    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\ArchiveFile", inversedBy="interviews")
     * @ORM\JoinColumn(name="archivefile_id", referencedColumnName="id")
     **/
    protected $archivFile;
    
    /** @ORM\Column(type="string", name="action_in") */
    protected $actionIn;
    
    /** @ORM\Column(type="string", name="action_out") */
    protected $actionOut;
    
    /** @ORM\Column(type="string", name="language") */
    protected $language;
    
    
    public function getColumns()
    {
        return self::$columns;
    }
    
    function getId()
    {
        return $this->id;
    }

    function getFighter()
    {
        return $this->fighter;
    }

    function getArchivFile()
    {
        return $this->archivFile;
    }

    function getActionIn()
    {
        return $this->actionIn;
    }

    function getLanguage()
    {
        return $this->language;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setFighter($fighter)
    {
        $this->fighter = $fighter;
    }

    function setArchivFile($archivFile)
    {
        $this->archivFile = $archivFile;
    }

    function setActionIn($actionIn)
    {
        $this->actionIn = $actionIn;
    }

    function setLanguage($language)
    {
        $this->language = $language;
    }
    
    function getActionOut()
    {
        return $this->actionOut;
    }

    function setActionOut($actionOut)
    {
        $this->actionOut = $actionOut;
    }




}
