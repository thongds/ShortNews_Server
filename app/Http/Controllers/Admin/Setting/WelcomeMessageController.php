<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 1/21/17
 * Time: 2:10 PM
 */
namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\BaseAdminController\CDUAbstractController;
use App\Http\Controllers\BaseAdminController\CDUController;
use App\Models\SessionDay;
use App\Models\WellcomeMessage;
use Illuminate\Http\Request;
use App\Models\Category;
use Validator;

class WelcomeMessageController extends CDUAbstractController {

    private $mRouter = ['GET' => 'get_welcome_message', 'POST' => 'post_welcome_message'];
    private $uniqueFields = array();
    private $privateKey = 'id';
    private $fieldFile = array('avatar_morning','avatar_night');
    private $fieldPath = array('avatar_morning_path','avatar_night_path');
    private $validateForm = ['welcome_msg'=>'required|max:255','type' =>'required|numeric'];
    private $validateFormUpdate = ['welcome_msg'=>'required|max:255'];
    private $pagingNumber = 10;
    private $validateMaker;
    public function __construct(){
        $this->validateMaker = Validator(array(),array(),array());
        parent::__construct(new WellcomeMessage(),$this->privateKey,$this->uniqueFields,$this->validateForm,$this->fieldFile,$this->validateFormUpdate,$this->fieldPath);
    }

    public function index(Request $request){
        $this->request = $request;
        $this->page = $request->get('page');
        if ($request->isMethod('POST')){
            $active = !empty($request->get('active')) ? 1 : 0 ;
            $progressData = ['active' => $active,
                'welcome_msg' => $request->get('welcome_msg'),
                'event_msg' => $request->get('event_msg'),
                'type' => $request->get('type')];
            $progressData = array_merge($progressData, $this->progressFileData($request,$this->fieldFile,$progressData));
            $this->validateMaker = $this->progressPost($request,$progressData)->parseMessageToValidateMaker();
        }
        if ($request->isMethod('GET')){
            $this->validateMaker = $this->progressGet($request)->parseMessageToValidateMaker();
        }
        return $this->returnView(null);
    }

    public function returnView($data){
        $listData = $this->mainModel->orderBy('created_at')->paginate($this->pagingNumber);
        $view = view('admin/setting/welcomeMessage.welcomeMessageIndex',['router' => $this->mRouter,'listData'=>$listData,
            'page'=>$this->page,'isEdit'=>$this->request->get('isEdit'),
            'update_data' =>$this->mUpdateData]);

        if($this->validateMaker!=null && count($this->validateMaker->errors()->toArray())>0){
            $message = $this->validateMaker->errors();
            return $view->withErrors($message);
        }

        return $view;

    }
}