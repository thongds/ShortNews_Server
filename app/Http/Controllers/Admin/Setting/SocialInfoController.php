<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 3/2/17
 * Time: 9:25 AM
 */

namespace App\Http\Controllers\Admin\Setting;


use App\Http\Controllers\BaseAdminController\CDUAbstractController;

use App\Models\SocialInfo;
use Illuminate\Http\Request;
class SocialInfoController extends CDUAbstractController{
    private $routers = array('GET' => 'get_social_info','POST' => 'post_social_info');
    private $uniqueFields = array('name');
    private $fieldFile = array('logo','video_tag');
    private $fieldPath = array('logo_path','video_tag_path');
    private $privateKey = 'id';
    private $validateForm = ['name'=>'required|max:255','video_tag' => 'required'];
    private $validateFormUpdate = ['name'=>'required|max:255','color_tag' => 'required'];
    private $pagingNumber = 3;
    private $mValidateMaker;
    public function __construct(){
        $this->mValidateMaker = Validator(array(),array(),array());
        parent::__construct(new SocialInfo(),$this->privateKey,$this->uniqueFields,$this->validateForm,$this->fieldFile,$this->validateFormUpdate,$this->fieldPath);
    }

    public function index(Request $request){
        $this->request = $request;
        $this->page = $request->get('page');
        if ($request->isMethod('POST')){
            $active = !empty($request->get('active')) ? 1 : 0 ;
            // only fields without file
            $progressData = ['active' => $active
                ,'name' => $request->get('name')
                ,'logo' => $request->get('logo')
                ,'video_tag' => $request->get('video_tag')
                ,'color_tag' => $request->get('color_tag')];

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
        $view = view('admin/setting/socialInfo.socialInfoIndex',['listData'=>$listData,'router' => $this->routers,'page'=>$this->page,
            'isEdit'=>$this->request->get('isEdit'),'update_data' =>$this->mUpdateData]);
        if($this->mValidateMaker!=null && count($this->mValidateMaker->errors()->toArray())>0)
            return  $view->withErrors($this->mValidateMaker);
        return  $view;

    }
}