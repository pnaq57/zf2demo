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
use Doctrine\Common\Collections\ArrayCollection;
/** 
 * @ORM\Entity
 * @Table(name="archive_files")
 */
class ArchiveFile extends EntityAbstract
{
    
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;
    
    /** @ORM\Column(type="string", name="name") */
    protected $name;
    
    /** @ORM\Column(type="string", name="path") */
    protected $path;
    
    /** @ORM\Column(type="string", name="storage") */
    protected $storage;
    
    /** @ORM\Column(type="string", name="comment") */
    protected $comment;
    
    /** @ORM\Column(type="string", name="comment_lang") */
    protected $commentLang;
    
    /** @ORM\Column(type="string", name="comment_audio_channel") */
    protected $commentAudioChannel;
    
    /** @ORM\Column(type="string", name="moderator") */
    protected $moderator;
    
    /** @ORM\Column(type="string", name="moderator_lang") */
    protected $moderatorLang;
    
    /** @ORM\Column(type="string", name="interview") */
    protected $interview;
    
    /** @ORM\Column(type="string", name="atmosphere") */
    protected $atmosphere;
    
    /** @ORM\Column(type="string", name="resolution") */
    protected $resolution;
    
    /** @ORM\Column(type="string", name="resolution_input") */
    protected $resolutionInput;
    
    /** @ORM\Column(type="string", name="scale") */
    protected $scale;
    
    /** @ORM\Column(type="string", name="graphic") */
    protected $graphic;
    
    /** @ORM\Column(type="string", name="graphicstyle") */
    protected $graphicstyle;
    
    /** @ORM\Column(type="string", name="graphic_broadcast_station") */
    protected $graphicBroadcastStation;
    
    
    /** @ORM\Column(type="string", name="quality") */
    protected $quality;
    
    /** @ORM\Column(type="date", name="legalaffiars_from") */
    protected $legalaffiarsFrom;
    
    /** @ORM\Column(type="date", name="legalaffiars_to") */
    protected $legalaffiarsTo;
    
    /** @ORM\Column(type="date", name="fight_date") */
    protected $fightDate;
    
    /** @ORM\Column(type="string", name="fight_where") */
    protected $fightWhere;
    
    
    /**
     * @ORM\OneToOne(targetEntity="Application\Entity\Fighter")
     * @ORM\JoinColumn(name="fighter_a", referencedColumnName="id")
     **/
    protected $fighterA;
    
    /**
     * @ORM\OneToOne(targetEntity="Application\Entity\Fighter")
     * @ORM\JoinColumn(name="fighter_b", referencedColumnName="id")
     **/
    protected $fighterB;
    
    /** @ORM\Column(type="string", name="nationality_fighter_a") */
    protected $nationalityFighterA;
    
    /** @ORM\Column(type="string", name="nationality_fighter_b") */
    protected $nationalityFighterB;
    
    /** @ORM\Column(type="string", name="fight_type") */
    protected $fightType;
    
    /** @ORM\Column(type="string", name="gender") */
    protected $gender;
    
    /** @ORM\Column(type="string", name="weight_class") */
    protected $weightClass;
    
    /** @ORM\Column(type="string", name="rounds") */
    protected $rounds;
    
    /** @ORM\Column(type="string", name="fight_title") */
    protected $fightTitle;
    
    /** @ORM\Column(type="string", name="tags") */
    protected $tags;
    
    /** @ORM\Column(type="string", name="winner") */
    protected $winner;
    
    /** @ORM\Column(type="string", name="result") */
    protected $result;
    
    /** @ORM\Column(type="string", name="result_round") */
    protected $resultRound;

    /** @ORM\Column(type="datetime", name="created_at") */
    protected $createdAt;
    
    /** @ORM\Column(type="datetime", name="updated_at") */
    protected $updatedAt;
    
    protected $status;

    /** @ORM\Column(type="string", name="source") */
    protected $source;
    
    /** @ORM\Column(type="string", name="tc_start") */
    protected $tcStart;
    
    /** @ORM\Column(type="string", name="tc_end") */
    protected $tcEnd;
    
    /** @ORM\Column(type="string", name="sound") */
    protected $sound;
    
    /** @ORM\Column(type="string", name="length") */
    protected $length;
    
    /** @ORM\Column(type="string", name="legal_runtime") */
    protected $legalRuntime;
    
    
    /** @ORM\Column(type="string", name="graphic_input") */
    protected $graphicInput;
    

    /**
     * @ORM\OneToMany(targetEntity="Application\Entity\Interview", mappedBy="archivFile")
     **/
    protected $interviews;

    /** @ORM\Column(type="integer", name="hidden") */
    protected $hidden = 0;
    
    /** @ORM\Column(type="integer", name="deleted") */
    protected $deleted = 0;


    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Application\Entity\Tape", mappedBy="archiveFile")
     */
    protected $tapes;
    

    /**
     * @ORM\OneToOne(targetEntity="Application\Entity\FileIndex")
     * @ORM\JoinColumn(name="fk_id", referencedColumnName="id")
     **/
    protected $fileIndex;
    
    
    public function __construct() {
        $this->interviews = new ArrayCollection();
    }
    
    public function getFileIndex()
    {
        return $this->fileIndex;
    }

    public function setFileIndex($fileIndex)
    {
        $this->fileIndex = $fileIndex;
    }


    public static $columns = array(
        'id',
        'fk_id',
        'name',
        'hidden',
        'deleted',
        'path',
        'storage',
        'comment',
        'comment_lang',
        'comment_audio_channel',
        'moderator',
        'moderator_lang',
        'interview',
        'atmosphere',
        'resolution',
        'resolution_input',
        'scale',
        'graphic',
        'graphicstyle',
        'graphic_broadcast_station',
        'graphic_broadcast_station_yes',
        'quality',
        'legalaffiars_from',
        'legalaffiars_to',
        'fight_date',
        'fight_where',
        'fighter_a',
        'fighter_b',
        'nationality_fighter_a',
        'nationality_fighter_b',
        'fight_type',
        'gender',
        'weight_class',
        'rounds',
        'fight_title',
        'tags',
        'winner',
        'result',
        'result_round',
        'status',
        'source',
        'tc_start',
        'tc_end',
        'sound',
        'length',
        'legal_runtime',
        'graphic_input'
    );
    
   
    public function validateData()
    {
        
        if (!isset($this->rawData['comment']) || $this->rawData['comment'] != 'y') {
            $this->setComment('n');
            $this->commentLang = null;
            $this->commentAudioChannel = null;
        }
        
        if (!isset($this->rawData['moderator']) || $this->rawData['moderator'] != 'y') {
            $this->setModerator('n');
            $this->moderatorLang = null;
        }
        
        if (!isset($this->rawData['graphic']) || $this->rawData['graphic'] != 'y') {
            $this->setGraphic('n');
        }
        
        if (!isset($this->rawData['atmosphere']) || $this->rawData['atmosphere'] != 'y') {
            $this->setAtmosphere('n');
        }
       
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getCommentLang()
    {
        return $this->commentLang;
    }

    public function getCommentAudioChannel()
    {
        return $this->commentAudioChannel;
    }

    public function getModerator()
    {
        return $this->moderator;
    }

    public function getModeratorLang()
    {
        return $this->moderatorLang;
    }

    public function getInterview()
    {
        return $this->interview;
    }

    public function getResolution()
    {
        return $this->resolution;
    }

    public function getScale()
    {
        return $this->scale;
    }

    public function getGraphic()
    {
        return $this->graphic;
    }

    public function getGraphicstyle()
    {
        return $this->graphicstyle;
    }

    public function getGraphicBroadcastStation()
    {
        return $this->graphicBroadcastStation;
    }


    public function getQuality()
    {
        return $this->quality;
    }

    public function getLegalaffiarsFrom()
    {
        return $this->legalaffiarsFrom;
    }

    public function getLegalaffiarsTo()
    {
        return $this->legalaffiarsTo;
    }

    public function getFightDate()
    {
        return $this->fightDate;
    }

    public function getFightWhere()
    {
        return $this->fightWhere;
    }

    public function getNationalityFighterA()
    {
        return $this->nationalityFighterA;
    }

    public function getNationalityFighterB()
    {
        return $this->nationalityFighterB;
    }

    public function getFightType()
    {
        return $this->fightType;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getWeightClass()
    {
        return $this->weightClass;
    }

    public function getRounds()
    {
        return $this->rounds;
    }

    public function getFightTitle()
    {
        if (is_string($this->fightTitle)) {
            return explode(',', $this->fightTitle);
        }        
        return $this->fightTitle;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function getWinner()
    {
        return $this->winner;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function setCommentLang($commentLang)
    {
        $this->commentLang = $commentLang;
    }

    public function setCommentAudioChannel($commentAudioChannel)
    {
        $this->commentAudioChannel = $commentAudioChannel;
    }

    public function setModerator($moderator)
    {
        $this->moderator = $moderator;
    }

    public function setModeratorLang($moderatorLang)
    {
        $this->moderatorLang = $moderatorLang;
    }

    public function setInterview($interview)
    {
        $this->interview = $interview;
    }

    public function setResolution($resolution)
    {
        $this->resolution = $resolution;
    }

    public function setScale($scale)
    {
        $this->scale = $scale;
    }

    public function setGraphic($graphic)
    {
        $this->graphic = $graphic;
    }

    public function setGraphicstyle($graphicstyle)
    {
        $this->graphicstyle = $graphicstyle;
    }

    public function setGraphicBroadcastStation($graphicBroadcastStation)
    {
        $this->graphicBroadcastStation = $graphicBroadcastStation;
    }

    public function setQuality($quality)
    {
        $this->quality = $quality;
    }

    public function setLegalaffiarsFrom($legalaffiarsFrom)
    {
        if (!$legalaffiarsFrom instanceof \DateTime) {
            $legalaffiarsFrom = new \DateTime($legalaffiarsFrom);
        }
        $this->legalaffiarsFrom = $legalaffiarsFrom;
    }

    public function setLegalaffiarsTo($legalaffiarsTo)
    {
        if (!$legalaffiarsTo instanceof \DateTime) {
            $legalaffiarsTo = new \DateTime($legalaffiarsTo);
        }
        $this->legalaffiarsTo = $legalaffiarsTo;
    }

    public function setFightDate($fightDate)
    {
        if (!$fightDate instanceof \DateTime) {
            $fightDate = new \DateTime($fightDate);
        }
        $this->fightDate = $fightDate;
    }

    public function setFightWhere($where)
    {
        $this->fightWhere = $where;
    }

    public function setNationalityFighterA($nationalityFighterA)
    {
        $this->nationalityFighterA = $nationalityFighterA;
    }

    public function setNationalityFighterB($nationalityFighterB)
    {
        $this->nationalityFighterB = $nationalityFighterB;
    }

    public function setFightType($fightType)
    {
        $this->fightType = $fightType;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function setWeightClass($weightClass)
    {
        $this->weightClass = $weightClass;
    }

    public function setRounds($rounds)
    {
        $this->rounds = $rounds;
    }

    public function setFightTitle($fightTitle)
    {
        $this->fightTitle = $fightTitle;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    public function setWinner($winner)
    {
        $this->winner = $winner;
    }

    public function setResult($result)
    {
        $this->result = $result;
    }

    public function getColumns()
    {
        if (!isset(self::$columns)) {
            return array();
        }
        
        return self::$columns;
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
    
    
    /**
     * @return Collection
     */
    public function getTapes()
    {
        return $this->tapes;
    }

    public function setTapes(Collection $tapes)
    {
        $this->tapes = $tapes;
    }

    function getFighterA()
    {
        return $this->fighterA;
    }

    function getFighterB()
    {
        return $this->fighterB;
    }

    function setFighterA($fighterA)
    {
        $this->fighterA = $fighterA;
    }

    function setFighterB($fighterB)
    {
        $this->fighterB = $fighterB;
    }


    function getAtmosphere()
    {
        return $this->atmosphere;
    }

    function setAtmosphere($atmosphere)
    {
        $this->atmosphere = $atmosphere;
    }
    
    function getStorage()
    {
        return $this->storage;
    }

    function setStorage($storage)
    {
        $this->storage = $storage;
    }


    function getStatus()
    {
        return $this->status;
    }

    function setStatus($status)
    {
        $this->status = $status;
    }

    function getSource()
    {
        return $this->source;
    }

    function setSource($source)
    {
        $this->source = $source;
    }

    function getInterviews()
    {
        return $this->interviews;
    }

    function setInterviews($interviews)
    {
        $this->interviews = $interviews;
    }

    public function getTcStart()
    {
        return $this->tcStart;
    }

    public function getTcEnd()
    {
        return $this->tcEnd;
    }

    public function getSound()
    {
        return $this->sound;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function getLegalRuntime()
    {
        return $this->legalRuntime;
    }

    public function setTcStart($tcStart)
    {
        $this->tcStart = $tcStart;
    }

    public function setTcEnd($tcEnd)
    {
        $this->tcEnd = $tcEnd;
    }

    public function setSound($sound)
    {
        $this->sound = $sound;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function setLegalRuntime($legalRuntime)
    {
        $this->legalRuntime = $legalRuntime;
    }

    public function getGraphicInput()
    {
        return $this->graphicInput;
    }

    public function setGraphicInput($graphicInput)
    {
        $this->graphicInput = $graphicInput;
    }

    public function getResultRound()
    {
        return $this->resultRound;
    }

    public function setResultRound($resultRound)
    {
        $this->resultRound = $resultRound;
    }

    public function getResolutionInput()
    {
        return $this->resolutionInput;
    }

    public function setResolutionInput($resolutionInput)
    {
        $this->resolutionInput = $resolutionInput;
    }
    
    public function getHidden()
    {
        return $this->hidden;
    }

    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
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
