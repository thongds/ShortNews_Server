<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 3/1/17
 * Time: 4:07 PM
 */

namespace App\Http\Controllers\Admin\Setting;


use App\Http\Controllers\BaseAdminController\CDUAbstractController;
use App\Models\Category;
use App\Models\FanPage;
use App\Models\News;
use App\Models\NewsPaper;
use App\Models\SessionDay;
use App\Models\SocialInfo;
use Illuminate\Http\Request;
class FanPageController extends  CDUAbstractController{

    private $mRouter = array('GET' => 'get_fanpage','POST' => 'post_fanpage');
    private $uniqueFields = array('name');
    private $privateKey = 'id';
    private $fieldFile = array('logo');
    private $fieldPath = array('logo_path');
    private $foreignData ;
    private $validateForm = ['name'=>'required|max:255',
        'logo' => 'required',
        'social_info_id' => 'required'];
    private $validateFormUpdate = array('name'=>'required|max:255');
    private $pagingNumber = 10;
    private $validateMaker;
    public function __construct(){
        $this->validateMaker = Validator(array(),array(),array());
        $socialInfo = ['fr_id' =>'social_info_id',
            'fr_data'=>$this->getDataByModel(new SocialInfo()),
            'fr_private_id' =>'id',
            'fr_select_field' => 'name',
            'label' => 'Social'
        ];

        $this->foreignData = [$socialInfo];
        parent::__construct(new FanPage(),$this->privateKey,$this->uniqueFields,$this->validateForm,$this->fieldFile,$this->validateFormUpdate,$this->fieldPath);
    }

    public function index(Request $request){
        $this->request = $request;
        $this->page = $request->get('page');
        if ($request->isMethod('POST')){
            $active = !empty($request->get('active')) ? 1 : 0 ;
            $progressData = ['active' => $active,
                'name' => $request->get('name'),
                'logo' => $request->get('logo'),
                'social_info_id' => $request->get('social_info_id'),
            ];
            $progressData = array_merge($progressData, $this->progressFileData($request,$this->fieldFile,$progressData));
            $result = $this->progressPost($request,$progressData);
            $this->validateMaker = $result->parseMessageToValidateMaker();
        }
        if ($request->isMethod('GET')){
            $this->validateMaker = $this->progressGet($request)->parseMessageToValidateMaker();
        }
        return $this->returnView(null);
    }

    public function returnView($data){

        $listData = $this->mainModel->orderBy('created_at')->paginate($this->pagingNumber);
        $view = view('admin/setting/fanPage.fanPageIndex',['router' => $this->mRouter,'listData'=>$listData,
            'page'=>$this->page,'isEdit'=>$this->request->get('isEdit'),
            'update_data' =>$this->mUpdateData,'foreignData' => $this->foreignData]);

        if($this->validateMaker!=null && count($this->validateMaker->errors()->toArray())>0){
            $message = $this->validateMaker->errors();
            return $view->withErrors($message);
        }

        return $view;

    }

}