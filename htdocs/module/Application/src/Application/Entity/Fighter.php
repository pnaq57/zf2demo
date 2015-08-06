<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Doctrine\Common\Collections\Collection;



/** 
 * @ORM\Entity
 * @Table(name="fighter")
 */
class Fighter extends EntityAbstract
{
    public static $columns = array(
        'id',
        'deleted',
        'firstname',
        'lastname',
        'lastname_shortcut',
        'fullname'
    );
    
    
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;
    
    /** @ORM\Column(type="integer", name="deleted") */
    protected $deleted = 0;
    
    /** @ORM\Column(type="string", name="firstname") */
    protected $firstname;
    
    /** @ORM\Column(type="string", name="lastname") */
    protected $lastname;
    
    /** @ORM\Column(type="string", name="lastname_shortcut") */
    protected $lastnameShortcut;
    
    
    /** @ORM\Column(type="string", name="fullname") */
    protected $fullname;


    function getId()
    {
        return $this->id;
    }

    function getFirstname()
    {
        return $this->firstname;
    }

    function getLastname()
    {
        return $this->lastname;
    }

    function getLastnameShortcut()
    {
        return $this->lastnameShortcut;
    }

    function getFullname()
    {
        return $this->fullname;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    function setLastnameShortcut($lastnameShortcut)
    {
        $this->lastnameShortcut = $lastnameShortcut;
    }

    function setFullname($fullname)
    {
        $this->fullname = $fullname;
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

//put your code here
}
