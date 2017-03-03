<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 8/26/16
 * Time: 5:10 PM
 */

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\BaseAdminController\Controller;
use Illuminate\Support\Facades\DB;
class SocialController extends Controller{
    public function getSocial($page){
        $number_row = 10;
        $social_media ='social_media';
        $fan_page ='fan_page';
        $social_content_type = "social_content_type";
        $social_info = 'social_info';
        $data = DB::table($social_media)->join($fan_page,$social_media.'.fan_page_id','=',$fan_page.'.id')
            ->join($social_content_type,$social_content_type.'.id','=',$social_media.'.social_content_type_id')
            ->join($social_info,$social_info.'.id','=',$fan_page.'.social_info_id')
            ->select($social_media.'.title',$social_media.'.post_image_url',$social_media.'.separate_image_tag'
                ,$social_media.'.full_link',$fan_page.'.name as fanpage_name',$social_media.'.social_content_type_id'
                ,$fan_page.'.logo as fanpage_logo',
                $social_info.'.name as social_name',$social_info.'.logo as social_logo',$social_info.'.color_tag',$social_info.'.video_tag')
            ->where([['social_media.active',1],['fan_page.active',1],['social_info.active',1],['social_content_type.active',1]])
            ->offset($page*$number_row)->limit($number_row)->orderBy('social_media.created_at','desc')->get();
         return response(json_encode($data),200);
    }

}