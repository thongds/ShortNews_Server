<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 2/11/17
 * Time: 10:47 AM
 */

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\BaseAdminController\CDUAbstractController;
use App\Http\Controllers\BaseAdminController\CDUController;
use Illuminate\Http\Request;
use App\Models\SongType;

class SongTypeController extends CDUAbstractController{

    private $mRouter = ['GET' => 'get_song_type','POST' => 'post_song_type'];
    private $validateMaker;
    private $uniqueFields = array('name','type');
    private $privateKey = 'id';
    private $validateForm = ['type' => 'required|numeric','name'=>'required|max:255'];
    private $pagingNumber = 3;
    public function __construct(){
        $this->validateMaker = Validator(array(),array(),array());
        parent::__construct(new SongType(),$this->privateKey,$this->uniqueFields,$this->validateForm,null,$this->validateForm);
    }

    public function index(Request $request){
        $this->request = $request;
        $this->page = $request->get('page');
        if ($request->isMethod('POST')){
            $active = !empty($request->get('active')) ? 1 : 0 ;
            $progressData = ['active' => $active,'name' => $request->get('name'),'type' => $request->get('type')];
            $this->validateMaker = $this->progressPost($request,$progressData)->parseMessageToValidateMaker();
        }
        if ($request->isMethod('GET')){
            $this->validateMaker = $this->progressGet($request)->parseMessageToValidateMaker();
        }
        return $this->returnView(null);

    }
    public function returnView($data){
        $listData = $this->mainModel->orderBy('created_at')->paginate($this->pagingNumber);
        $view = view('admin/setting/song_type.songTypeIndex',['router' => $this->mRouter,'listData'=>$listData,
            'page'=>$this->page,'isEdit'=>$this->request->get('isEdit'),
            'update_data' =>$this->mUpdateData]);

        if($this->validateMaker!=null && count($this->validateMaker->errors()->toArray())>0){
            $message = $this->validateMaker->errors();
            return $view->withErrors($message);
        }
        return $view;
    }
}