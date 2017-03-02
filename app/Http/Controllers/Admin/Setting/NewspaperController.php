<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 3/1/17
 * Time: 11:54 AM
 */

namespace App\Http\Controllers\Admin\Setting;


use App\Http\Controllers\BaseAdminController\CDUAbstractController;
use App\Models\NewsPaper;
use Illuminate\Http\Request;

class NewspaperController extends  CDUAbstractController{

    private $routers = array('GET' => 'get_newspaper','POST' => 'post_newspaper');
    private $uniqueFields = array('name');
    private $fieldFile = array('paper_logo','video_tag_image');
    private $fieldPath = array('paper_logo_path','video_tag_image_path');
    private $privateKey = 'id';
    private $validateForm = ['name'=>'required|max:255','video_tag_image' => 'required'];
    private $validateFormUpdate = ['name'=>'required|max:255'];
    private $pagingNumber = 3;
    private $mValidateMaker;
    public function __construct(){
        $this->mValidateMaker = Validator(array(),array(),array());
        parent::__construct(new NewsPaper(),$this->privateKey,$this->uniqueFields,$this->validateForm,$this->fieldFile,$this->validateFormUpdate,$this->fieldPath);
    }

    public function index(Request $request){
        $this->request = $request;
        $this->page = $request->get('page');
        if ($request->isMethod('POST')){
            $active = !empty($request->get('active')) ? 1 : 0 ;
            // only fields without file
            $progressData = ['active' => $active,'name' => $request->get('name')
                ,'title_color' => $request->get('title_color')
                ,'paper_tag_color' => $request->get('paper_tag_color')];

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
        $view = view('admin/setting/newsPaper.newsPaperIndex',['listData'=>$listData,'router' => $this->routers,'page'=>$this->page,
            'isEdit'=>$this->request->get('isEdit'),'update_data' =>$this->mUpdateData]);
        if($this->mValidateMaker!=null && count($this->mValidateMaker->errors()->toArray())>0)
            return  $view->withErrors($this->mValidateMaker);
        return  $view;

    }
}