<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 2/12/17
 * Time: 8:26 AM
 */

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\BaseAdminController\Controller;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{
    public function __construct()
    {
    }

    public function hostSong(){
        $data = DB::table('hot_song')->where('active','1')->get();
        echo json_encode($data);
    }
    public function menuSong(){
        $languageArray = array();
        $language = DB::table('language')->where('active',1)->get();
        foreach ($language as $key =>$value){
            $languageArray[$value['name']] =$value['id'];
        }
        echo json_encode($languageArray);
    }
    public function getEvent(){
        $eventData = DB::table('event')->where('active',1)->get();
        echo json_encode($eventData);
    }
    public function mainPageByCategory(){
        $categoryArray = array();
        $responseData = array();
        $categoryData = DB::table('category')->where('active',1)->get();
        $newSongData = DB::table('new_least_song')->join('singer','singer.id','=','new_least_song.singer_id')
            ->select('new_least_song.name','duration','new_least_song.avatar',
            'subtitle_source','category_id','language_id','singer_id','subtitle_type_id','song_type_id','song_detail_id','song_source','singer.name as singer name')
            ->where('new_least_song.active',1)->get();
        $hostSongData = DB::table('hot_song')->leftJoin('singer','singer.id','=','hot_song.singer_id')
            ->select('hot_song.name','duration','hot_song.avatar','subtitle_source','category_id','language_id','singer_id',
            'subtitle_type_id','song_type_id','song_detail_id','song_source','singer.name as singer name')
            ->where('hot_song.active','1')->get();

        foreach ($categoryData as $key =>$value){
            $categoryArray[$value['name']] =$value['id'];
        }
        $result = $categoryArray;
        foreach ($newSongData as $key => $value){
            foreach ($categoryArray as $key1 => $value1){
                if($value1 == $value['category_id']){
                    if(is_int($result[$key1])){
                        $result[$key1] = array($value);
                    }else{
                        array_push($result[$key1],$value);
                    }
                }
            }
        }

        $result['host_song'] = $hostSongData;
       // $responseData['host_song'] = $hostSongData;
        $responseData = $result;
        return response( json_encode($responseData),200);
    }
    public function timeOut(){
        sleep(20);
    }
    public function ResponseNotJson(){
        $array = ["code" => 1000,"message" => "request error"];
        return response("1",200);
    }

}