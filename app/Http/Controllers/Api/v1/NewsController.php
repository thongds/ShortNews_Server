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

    public $number_row = 5;
    public function getNews(Request $request){

        $page = $request->get('page');
        $sessionMessage = "";
//        $type = $request->get('type');
//        $day = $request->get('day');
        $returnData = array();

//        $yesterday = date('d.m.Y',strtotime("-1 days"));
        $currentHours  = (int)date("H");
        $type = 1;
//        $returnData = array();
        if($currentHours>0 && $currentHours < 18){
            $type = 1;
            $sessionMessage = "Sáng Nay";
        }else{
            $type = 3;
            $sessionMessage = "Tối Nay";
        }
//        $data = $this->queryData((int)$page,(int)$type,(string)$day);
//        if(count($data) > 0){
//            $sessionDayData = DB::table('session_day')->select('name','type')->where('type','=',$type)->first();
//            $returnData['session_name'] = $sessionDayData['name'];
//            $returnData['session_type'] = $sessionDayData['type'];
//            $returnData['data'] = $data;
//        }
        $message = array();
        $message['welcome_message'] = "";
        $message['event_message'] = "";
        $msgData = array();
        if($page == 0) {
            $today = date("d/m/Y");
            if($type == 1){
                $msgData = DB::table("welcome_message")
                    ->select('welcome_msg','event_msg','avatar_morning as avatar')
                    ->where([['type','=',1],['active','=',1]])->get();
            }else{
                $msgData = DB::table("welcome_message")
                    ->select('welcome_msg','event_msg','avatar_night as avatar')
                    ->where([['type','=',1],['active','=',1]])->get();
            }

            $message['welcome_message'] = count($msgData) > 0 ?$msgData[0]['welcome_msg']." ".$sessionMessage." ".$today : "Tin Chính Hôm Nay"." ".$today;
            $message['event_message'] = count($msgData) > 0 ? $msgData[0]['event_msg'] : "";
            $message['avatar'] = count($msgData) > 0 ?$msgData[0]['avatar'] : "empty avatar";
        }
        $returnData = $this->querySimpleData($page);
        $data['message'] = $message;
        $data['data'] = $returnData;
        return response(json_encode($data),200);

    }
    public function querySimpleData($page){

        $data =DB::table('news')->join('newspaper','newspaper.id','=','news.newspaper_id')
            ->select('news.post_title','news.post_content','news.post_image',
                'news.is_video','news.created_at as created','news.video_link','news.full_link'
                ,'newspaper.title_color','newspaper.paper_logo',
                'newspaper.paper_tag_color','newspaper.video_tag_image')
            ->where([
                ['news.active','=',1],
                ['newspaper.active','=',1],
            ])
            ->offset($page*$this->number_row)->limit($this->number_row)->orderBy('news.created_at','desc')->get();
        return $data;
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