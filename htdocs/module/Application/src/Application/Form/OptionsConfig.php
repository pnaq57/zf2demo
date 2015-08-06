<?php
namespace Application\Form;

/**
 * Description of OptionsConfig
 *
 * @author aqnguyen
 */
class OptionsConfig
{
    public static $options = array(
        'status' => array(
            'New' => 'New',
            'IngestInProgress' => 'Ingest in progress',
            'IngestDone' => 'Ingest done',
            'CutInProgress' => 'Cut in progress',
            'CutDone' => 'Cut done',
            'ReadyToConvert' => 'Ready to convert',
            'NotReadyToConvert' => 'Not ready to convert',
           // 'Finished' => 'Finished',
        ),
        'sf_status' => array(
            '' => '',
            'New' => 'New',
            'ReadyToConvert' => 'Ready to convert',
            'NotReadyToConvert' => 'Not ready to convert',
        ),
        'not_remove_status' => array(
            'ConvertInProgress' => 'Convert in progress',
            'Finished' => 'Finished'
        ),       
        'filter_status' => array(
            'New' => 'New',
            'IngestInProgress' => 'Ingest in progress',
            'IngestDone' => 'Ingest done',
            'CutInProgress' => 'Cut in progress',
            'CutDone' => 'Cut done',
            'ReadyToConvert' => 'Ready to convert',
            'NotReadyToConvert' => 'Not ready to convert',
            'ConvertInProgress' => 'Convert in progress',
            'Finished' => 'Finished',
        ),
        'language' => array(
            'ger' => 'Deutsch',
            'engl' => 'Englisch',
            'fra' => 'Französisch',
            'others' => 'others',
        ),
        
        'comment_audio_channel' => array(
            'Channel 1' => 'Channel 1',
            'Channel 2' => 'Channel 2',
            'Channel 3' => 'Channel 3',
            'Channel 4' => 'Channel 4',
            'Channel 5' => 'Channel 5',
            'Channel 6' => 'Channel 6',
            'Channel 7' => 'Channel 7',
            'Channel 8' => 'Channel 8'
        ),
        
        'resolution' => array(
            '1920x1080' => '1920x1080',
            '1280x720' => '1280x720',
            '720x576' => '720x576',
            'other' => 'other'
        ),
        
        'scale' => array(
            '4:3' => '4:3',
            '16:9' => '16:9',
        ),
        
        'quality' => array(
            'good' => 'good',
            'medium' => 'medium',
            'bad' => 'bad',
        ),
        
        'graphicstyle' => array(
            'sauerland' => 'sauerland',
            'ard' => 'medium',
            'neutral' => 'neutral',
        ),
        
        'graphic_broadcast_station' => array(
            'Station 1' => 'Station 1',
            'Station 2' => 'Station 2',
            'Station 3' => 'Station 3',
        ),
        
        'fight_type' => array(
            'boxing' => 'boxing',
            'mma' => 'mma',
            'kickboxing' => 'kickboxing',
        ),
        
        'gender' => array(
            'Male' => 'Male',
            'Female' => 'Female',
        ),
        
        'weight_class' => array(
            'Heavyweight / Schwergewicht' => 'Heavyweight / Schwergewicht',
            'Cruiserweight / Cruiserweight' => 'Cruiserweight / Cruiserweight',
            'Lightheavyweight / Halbschwergewicht' => 'Lightheavyweight / Halbschwergewicht',
            'Super Middleweight / Super Mittelgewicht' => 'Super Middleweight / Super Mittelgewicht',
            'Middleweight / Mittelgewicht' => 'Middleweight / Mittelgewicht',
            'Super Welterweight / Super Weltergewicht' => 'Super Welterweight / Super Weltergewicht',
            'Welterweight / Weltergewicht' => 'Welterweight / Weltergewicht',
            'Super Lightweight / Superleichtgewicht' => 'Super Lightweight / Superleichtgewicht',
            'Lightweight / Leichtgewicht' => 'Lightweight / Leichtgewicht',
            'Superfeatherweight / Super Federgewicht' => 'Superfeatherweight / Super Federgewicht',
            'Featherweight / Federgewicht' => 'Featherweight / Federgewicht',
            'Superbantam / Superbantam' => 'Superbantam / Superbantam',
            'Bantam / Bantam' => 'Bantam / Bantam',
            'Superflyweight / Superfliegengewicht' => 'Superflyweight / Superfliegengewicht',
            'Flyweight / Fliegengewicht' => 'Flyweight / Fliegengewicht'            
        ),
        
        'result' => array(
            'Draw' => 'Draw',
            'KO' => 'KO',
            'TKO' => 'TKO',
            'Decision' => 'Decision'
        ),
        
        'fight_title' => array(
            'WBA' => 'WBA',
            'WBC' => 'WBC',
            'WBO' => 'WBO',
            'IBF' => 'IBF',
            'other' => 'other'
        ),
        
        'winner' => array(
            'a' => 'A',
            'b' => 'B',
        ),
        
        'action' => array(
            'in' => 'Walk in',
            'out' => 'Walk out',
        ),
        
        'source' => array(
            'SAU' => 'Sauerland',
            'SES' => 'Universum und SES',
            'MAR' => 'Matchroom'
        ),
        
        'marker' => array(
            'Error / Sound' => 'Error / Sound',
            'Error / Picture' => 'Error / Picture',
            'KD' => 'KD',
            'KO' => 'KO',
            'TKO' => 'TKO',
            'Highlights' => 'Highlights'
        ),
        
        'sound' => array(
            'yes' => 'yes',
            'no' => 'no',
        ),
        
        'file_upload_type' => array(
            '' => '',
            'Thumbnail' => 'Thumbnail',
            'Poster' => 'Poster'
        ),
        
        'genre' => array(
            '' => '',
            'Documentation' => 'Documentation',
            'Fight' => 'Fight'
        ),
        
        'sport_type' => array(
            '' => '',
            'boxing' => 'boxing',
            'mma' => 'mma',
            'kickboxing' => 'kickboxing',
        ),
        'rating' => array(
            '' => '',
            'FSK 0' => 'FSK 0',
            'FSK 6' => 'FSK 6',
            'FSK 12' => 'FSK 12',
            'FSK 16' => 'FSK 16',
            'FSK 18' => 'FSK 18',
            'suitable for ages 0 and older' => 'suitable for ages 0 and older',
            'suitable for ages 6 and older' => 'suitable for ages 6 and older',
            'n/a' => 'n/a'
        ),
        'sf_description' => array(
            '' => '',
            'Short description' => 'Short description',
            'Long description' => 'Long description'
        ),
        'sf_language' => array(
            '' => '',
            'deutsch' => 'deutsch',
            'englisch' => 'englisch',
            'französisch' => 'französisch'
        ),
        
        'limit' => array(
            3 => 3,
            20 => 20, 
            30 => 30, 
            50 => 50, 
            100 => 100, 
            500 => 500
        ) 
    );

    public static function getFormOption($optName)
    {
        if ($optName == 'rounds') {
            $rounds =  array_combine(range(1, 15), range(1, 15));
            $rounds['unknown'] = 'unknown';
            return $rounds;
        }
        if ($optName == 'result_round') {
            $resultRound =  array_combine(range(1, 15), range(1, 15));
            return $resultRound;
        }
        
        if ($optName == 'country') {
            $countryOptions = require_once 'CountryOptions.php';
            $countryOptions = array_combine($countryOptions, $countryOptions);
            return $countryOptions;
        }
        return self::$options[$optName];
    }

}
