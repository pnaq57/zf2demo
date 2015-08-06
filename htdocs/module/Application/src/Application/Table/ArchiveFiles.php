<?php
namespace Application\Table;

/**
 * Description of ArchiveFiles
 *
 * @author aqnguyen
 */
class ArchiveFiles
{
    protected $db;
    
    function getDb()
    {
        return $this->db;
    }

    function setDb($db)
    {
        $this->db = $db;
    }


}
