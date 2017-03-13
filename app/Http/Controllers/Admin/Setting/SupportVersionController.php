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
use App\Models\News;
use App\Models\NewsPaper;
use App\Models\Platform;
use App\Models\SessionDay;
use App\Models\SupportVersion;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
class SupportVersionController extends  CDUAbstractController{

    private $mRouter = array('GET' => 'get_support_version','POST' => 'post_support_version');
    private $uniqueFields = array('name');
    private $privateKey = 'id';
    private $fieldFile = array();
    private $fieldPath = array();
    private $foreignData ;
    private $validateForm = ['version'=>'required|max:255','platform_id' => 'required','message_update' => 'required','link_update' => 'required'];
    private $pagingNumber = 10;
    private $validateMaker;
    public function __construct(){
        $this->validateMaker = Validator(array(),array(),array());
        $platform = ['fr_id' =>'platform_id',
            'fr_data'=>$this->getDataByModel(new Platform()),
            'fr_private_id' =>'id',
            'fr_select_field' => 'name',
            'label' => 'Platform'
        ];

        $this->foreignData = [$platform];
        parent::__construct(new SupportVersion(),$this->privateKey,$this->uniqueFields,$this->validateForm,$this->fieldFile,$this->validateForm,$this->fieldPath);
    }

    public function index(Request $request){
        $this->request = $request;
        $this->page = $request->get('page');
        if ($request->isMethod('POST')){
            $active = !empty($request->get('active')) ? 1 : 0 ;
            $progressData = ['active' => $active,
                'version' => $request->get('version'),
                'message_update' => $request->get('message_update'),
                'link_update' => $request->get('link_update'),
                'platform_id' => $request->get('platform_id')
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
        $listData = DB::table('support_version')->join('platform','platform.id','=','support_version.platform_id')
            ->select('message_update','link_update','support_version.id','platform.name as platform_name','support_version.version','support_version.active')
            ->orderBy('support_version.created_at')->paginate($this->pagingNumber);
        $view = view('admin/setting/supportVersion.supportVersionIndex',['router' => $this->mRouter,'listData'=>$listData,
            'page'=>$this->page,'isEdit'=>$this->request->get('isEdit'),
            'update_data' =>$this->mUpdateData,'foreignData' => $this->foreignData]);

        if($this->validateMaker!=null && count($this->validateMaker->errors()->toArray())>0){
            $message = $this->validateMaker->errors();
            return $view->withErrors($message);
        }

        return $view;

    }

}