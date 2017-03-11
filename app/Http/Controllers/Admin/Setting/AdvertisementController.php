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
use App\Models\Advertisement;
use App\Models\SessionDay;
use App\Models\WellcomeMessage;
use Illuminate\Http\Request;
use App\Models\Category;
use Validator;

class AdvertisementController extends CDUAbstractController {

    private $mRouter = ['GET' => 'get_ads', 'POST' => 'post_ads'];
    private $uniqueFields = array();
    private $privateKey = 'id';
    private $fieldFile = array('post_image');
    private $fieldPath = array('post_image_path');
    private $validateForm = ['ads_host'=>'required|max:255','ads_code|max:255' => 'required','post_image'=>'required','type' =>'required|numeric',
        'full_link' =>'required','at_page' =>'required|numeric','at_position' =>'required|numeric'];
    private $validateFormUpdate = ['ads_host'=>'required|max:255','ads_code' => 'required|max:255','type' =>'required|numeric',
        'full_link' =>'required','at_page' =>'required|numeric','at_position' =>'required|numeric'];
    private $pagingNumber = 10;
    private $validateMaker;
    public function __construct(){
        $this->validateMaker = Validator(array(),array(),array());
        parent::__construct(new Advertisement(),$this->privateKey,$this->uniqueFields,$this->validateForm,$this->fieldFile,$this->validateFormUpdate,$this->fieldPath);
    }

    public function index(Request $request){
        $this->request = $request;
        $this->page = $request->get('page');
        if ($request->isMethod('POST')){
            $active = !empty($request->get('active')) ? 1 : 0 ;
            $progressData = ['active' => $active,
                'ads_host' => $request->get("ads_host"),
                'full_link' => $request->get('full_link'),
                'at_page' => $request->get('at_page'),
                'at_position' => $request->get('at_position'),
                'ads_code' => $request->get('ads_code'),
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
        $view = view('admin/setting/advertisement.advertisementIndex',['router' => $this->mRouter,'listData'=>$listData,
            'page'=>$this->page,'isEdit'=>$this->request->get('isEdit'),
            'update_data' =>$this->mUpdateData]);

        if($this->validateMaker!=null && count($this->validateMaker->errors()->toArray())>0){
            $message = $this->validateMaker->errors();
            return $view->withErrors($message);
        }

        return $view;

    }
}