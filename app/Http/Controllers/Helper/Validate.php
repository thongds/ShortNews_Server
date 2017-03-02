<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 1/31/17
 * Time: 3:25 PM
 */

namespace App\Http\Controllers\Helper;
use App\Http\Controllers\BaseAdminController\Controller;

use Illuminate\Http\Request;

class Validate extends Controller{

    public function checkValidate(Request $request,Array $validateForm){
        if(!empty($validateForm))
            $this->validate($request,$validateForm);
        return;
    }

}