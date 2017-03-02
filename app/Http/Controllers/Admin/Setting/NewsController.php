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
use App\Models\SessionDay;
use Illuminate\Http\Request;
class NewsController extends  CDUAbstractController{

    private $mRouter = array('GET' => 'get_news','POST' => 'post_news');
    private $uniqueFields = array('name');
    private $privateKey = 'id';
    private $fieldFile = array();
    private $fieldPath = array();
    private $foreignData ;
    private $validateForm = ['post_title'=>'required|max:255','post_content' => 'required',
        'post_image' => 'required','full_link' => 'required','newspaper_id' => 'required'
        ,'category_id' => 'required','session_day_id' => 'required'];
    private $validateFormUpdate = array('post_title'=>'required|max:255',
        'post_content' => 'required',
        'full_link' => 'required');
    private $pagingNumber = 10;
    private $validateMaker;
    public function __construct(){
        $this->validateMaker = Validator(array(),array(),array());
        $categoryInfo = ['fr_id' =>'category_id',
            'fr_data'=>$this->getDataByModel(new Category()),
            'fr_private_id' =>'id',
            'fr_select_field' => 'name',
            'label' => 'Category'
        ];
        $newspaper = ['fr_id' =>'newspaper_id',
            'fr_data'=>$this->getDataByModel(new NewsPaper()),
            'fr_private_id' =>'id',
            'fr_select_field' => 'name',
            'label' => 'Newspaper '
        ];
        $sessionDay = ['fr_id' =>'session_day_id',
            'fr_data'=>$this->getDataByModel(new SessionDay()),
            'fr_private_id' =>'id',
            'fr_select_field' => 'name',
            'label' => 'Session Day'
        ];

        $this->foreignData = [$categoryInfo,$newspaper,$sessionDay];
        parent::__construct(new News(),$this->privateKey,$this->uniqueFields,$this->validateForm,$this->fieldFile,$this->validateFormUpdate,$this->fieldPath);
    }

    public function index(Request $request){
        $this->request = $request;
        $this->page = $request->get('page');
        if ($request->isMethod('POST')){
            $active = !empty($request->get('active')) ? 1 : 0 ;
            $isVideo = !empty($request->get('is_video')) ? 1 : 0 ;
            if ($isVideo){
                $this->mValidateForm = array_add($this->validateForm,'video_link','required');
                $this->mValidateFormUpdate = array_add($this->validateFormUpdate,'video_link','required');
            }
            $progressData = ['active' => $active,
                'is_video' => $isVideo,
                'post_title' => $request->get('post_title'),
                'post_image' => $request->get('post_image'),
                'video_link' => $request->get('video_link'),
                'full_link' => $request->get('full_link'),
                'post_content' => $request->get('post_content'),
                'category_id' => $request->get('category_id'),'newspaper_id' => $request->get('newspaper_id'),
                'session_day_id' => $request->get('session_day_id')
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
        $view = view('admin/setting/news.newsIndex',['router' => $this->mRouter,'listData'=>$listData,
            'page'=>$this->page,'isEdit'=>$this->request->get('isEdit'),
            'update_data' =>$this->mUpdateData,'foreignData' => $this->foreignData]);

        if($this->validateMaker!=null && count($this->validateMaker->errors()->toArray())>0){
            $message = $this->validateMaker->errors();
            return $view->withErrors($message);
        }

        return $view;

    }

}