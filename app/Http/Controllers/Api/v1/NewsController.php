<?php

/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 8/26/16
 * Time: 4:23 PM
 */
namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\BaseAdminController\Controller;
use Illuminate\Support\Facades\DB;
class NewsController extends  Controller{

    public function getNews($page){
        $number_row = 8;
        $data =DB::table('news')->join('newspaper','newspaper.id','=','news.newspaper_id')
            ->select('news.post_title','news.post_content','news.post_image','news.is_video','news.created_at as created','news.video_link','news.full_link'
            ,'newspaper.title_color','newspaper.paper_logo','newspaper.paper_tag_color','newspaper.video_tag_image')
            ->where([['news.active','=',1],['newspaper.active','=',1]])
            ->offset($page*$number_row)->limit($number_row)->orderBy('news.created_at','desc')->get();
        if(false){
            return response()->json($data,200);
        }else{
            return response()->json($data);
        }

    }
}