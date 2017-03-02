<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 1/30/17
 * Time: 10:16 AM
 */

namespace App\Http\Controllers\BaseAdminController;


abstract  class CDUFileWithForeignDataController extends CDUFileController{

    protected $forgeinTabelData;
    protected $forgeinDataResponse;
    public function getForeinData(){

        if($this->forgeinTabelData !=null){
            foreach ($this->forgeinTabelData as $FGrawData){

            }
        }
    }
}