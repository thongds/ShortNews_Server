<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 2/18/17
 * Time: 10:31 AM
 */

namespace App\Http\Controllers\Admin\Setting;


use App\Http\Controllers\BaseAdminController\CDUAbstractController;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends CDUAbstractController
{
    private $mRouter = ['GET' => 'get_event', 'POST' => 'post_event'];
    private $uniqueFields = array('name');
    private $privateKey = 'id';
    private $validateForm = ['name'=>'required|max:255','banner' => 'required','song_id' => 'numeric'];
    private $validateFormNotBanner = ['name'=>'required|max:255','banner' => 'required','song_id' => 'required|numeric'];
    private $validateFormUpdate = ['name'=>'required|max:255'];
    private $pagingNumber = 10;
    private $fieldFile = array('banner');
    private $fieldPath = array('banner_path');
    private $validateMaker;
    public function __construct()
    {
        $this->validateMaker = Validator(array(),array(),array());
        parent::__construct(new Event(),$this->privateKey,$this->uniqueFields,$this->validateForm,$this->fieldFile,$this->validateFormUpdate,$this->fieldPath);
    }

    public function index(Request $request){
        $this->request = $request;
        $this->page = $request->get('page');
        if ($request->isMethod('POST')){
            $active = !empty($request->get('active')) ? 1 : 0 ;
            $isBanner = !empty($request->get('is_banner')) ? 1 : 0 ;
            if($isBanner == 0){
                $this->setValidate($this->validateFormNotBanner);
            }else{
                $this->setValidate($this->validateForm);
            }
            $progressData = ['active' => $active,'is_banner' => $isBanner,'name' => $request->get('name'),'url' => $request->get('url'),'song_id' => $request->get('song_id')];
            $progressData = array_merge($progressData, $this->progressFileData($request,$this->fieldFile,$progressData));
            $this->mValidateMaker = $this->progressPost($request,$progressData)->parseMessageToValidateMaker();
        }
        if ($request->isMethod('GET')){
            $this->mValidateMaker = $this->progressGet($request)->parseMessageToValidateMaker();
        }
        return $this->returnView(null);
    }

    public function returnView($data)
    {
        $listData = $this->mainModel->orderBy('created_at')->paginate($this->pagingNumber);
        $view = view('admin/setting/event.eventIndex',['listData'=>$listData,'router' => $this->mRouter,'page'=>$this->page,
            'isEdit'=>$this->request->get('isEdit'),'update_data' =>$this->mUpdateData]);
        if($this->mValidateMaker!=null && count($this->mValidateMaker->errors()->toArray())>0)
            return  $view->withErrors($this->mValidateMaker);
        return  $view;
    }
}