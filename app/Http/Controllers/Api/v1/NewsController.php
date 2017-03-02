<?php

/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 8/26/16
 * Time: 4:23 PM
 */
namespace App\Http\Controllers\Api\v1;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
class NewsController extends Controller{

    public function getNews($page){
        $number_row = 8;
        $data =DB::table('news')->join('newspaper','newspaper.id','=','news.newspaper_id')
            ->select('news.post_title','news.post_content','news.post_image','news.is_video','news.created','news.video_link','news.full_link'
            ,'newspaper.title_color','newspaper.paper_logo','newspaper.paper_tag_color','newspaper.video_tag_image')
            ->where([['news.status','=',1],['newspaper.status','=',1]])->offset($page*$number_row)->limit($number_row)->orderBy('created','desc')->get();
        if(false){
            return response()->json($data,204);
        }else{
            return response()->json($data);
        }

    }
}