<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\Common\Collections\Collection;

/** 
 * @ORM\Entity
 * @Table(name="sf_artwork")
 */
class SfArtwork extends EntityAbstract
{
    public static $columns = array('id', 'upload_file_id', 'sf_id');
    
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;
    
    /** @ORM\Column(type="integer", name="upload_file_id") */
    protected $uploadFile;
    
    public function getColumns()
    {
        if (!isset(self::$columns)) {
            return array();
        }
        
        return self::$columns;
    }
}
