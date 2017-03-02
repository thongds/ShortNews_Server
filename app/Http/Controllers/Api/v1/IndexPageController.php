<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 2/12/17
 * Time: 8:43 AM
 */

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\BaseAdminController\Controller;

class IndexPageController extends Controller
{
    public function index(){
        return view('admin/setting/songs.songIndex');
    }

}