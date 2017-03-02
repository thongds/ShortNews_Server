<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 2/8/17
 * Time: 4:53 PM
 */

namespace App\Http\Controllers\Helper;


class UtilFunction{

    static function mergeTwoArray(Array $beforeUpdate,Array $afterUpdate,Array $ignoreKey){
        $resultArray = array();

        foreach ($afterUpdate as $key1 => $value1){
            if(in_array($key1,$ignoreKey)){
                $resultArray[$key1] = $afterUpdate[$key1];
                unset($ignoreKey[$key1]);
                continue;
            }
            foreach ($beforeUpdate as $key2 => $value2){
                if($key2==$key1 && $beforeUpdate[$key2] != $afterUpdate[$key1] ){
                    $resultArray[$key1] = $afterUpdate[$key1];
                }
            }
        }
        return $resultArray;
    }
    static function getNow(){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        return date("Y-m-d H:i:s");
    }

}