<?php

/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 8/26/16
 * Time: 4:23 PM
 */
namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\BaseAdminController\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class NewsController extends  Controller{

    public $number_row = 8;
    public function getNews(Request $request){

        $page = $request->get('page');
        $type = $request->get('type');
        $day = $request->get('day');
        $returnData = array();
//        $today = date("Y/m/d");
//        $yesterday = date('d.m.Y',strtotime("-1 days"));
//        $currentHours  = (int)date("H");
//        $type = 1;
//        $returnData = array();
//        if($currentHours>5 && $currentHours < 12){
//            $type = 1;
//        }else{
//            $type = 3;
//        }
        $data = $this->queryData((int)$page,(int)$type,(string)$day);
        if(count($data) > 0){
            $sessionDayData = DB::table('session_day')->select('name')->where('type','=',$type)->first();
            $sessionDayName = $sessionDayData['name'];
            $returnData['session_name'] = $sessionDayName;
            $returnData['data'] = $data;
        }
        return response(json_encode($returnData),200);

    }
    public function queryData($page,$type,$today){
        $data =DB::table('news')->join('newspaper','newspaper.id','=','news.newspaper_id')
            ->join('session_day','session_day.id','=','news.session_day_id')
            ->select('news.post_title','news.post_content','news.post_image',
                'news.is_video','news.created_at as created','news.video_link','news.full_link'
                ,'newspaper.title_color','newspaper.paper_logo',
                'newspaper.paper_tag_color','newspaper.video_tag_image','session_day.type')
            ->where([
                ['news.active','=',1],
                ['newspaper.active','=',1],
                ['session_day.type','=',$type],
                ['news.created_at','>=',$today.' 00:00:00'],
                ['news.created_at','<',$today.' 23:59:59']
            ])
            ->offset($page*$this->number_row)->limit($this->number_row)->orderBy('news.created_at','desc')->get();
        return $data;
    }
}