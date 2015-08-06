<?php
namespace Application\Service\Utils;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StringHandler
 *
 * @author aqnguyen
 */
class StringHandler
{
    public static function convertCamelCaseToUnderScore($input) {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
    
    
    public static function dashesToCamelCase($string, $capitalizeFirstCharacter = false) 
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }
        return $str;
    }
    
    public static function filterUmlauts($str)
    {
        if (!is_string($str)) {
            return $str;
        }
        $sourceStrings = array('ä', 'ö', 'ü', 'Ä', 'Ö', 'Ü');
        $targetStrings = array('ae', 'oe', 'ue', 'AE', 'OE', 'UE');
        $str = str_replace($sourceStrings, $targetStrings, $str);
        return trim($str);
    }
    
}
