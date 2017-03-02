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
use App\Models\SocialContentType;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
class SocialMediaController extends  CDUAbstractController{

    private $mRouter = array('GET' => 'get_social_media','POST' => 'post_social_media');
    private $uniqueFields = array();
    private $privateKey = 'id';
    private $fieldFile = array();
    private $fieldPath = array();
    private $foreignData ;
    private $validateForm = ['title'=>'required','separate_image_tag' => 'required'];
    private $validateFormUpdate = ['title'=>'required','separate_image_tag' => 'required'];
    private $pagingNumber = 10;
    private $validateMaker;
    public function __construct(){
        $this->validateMaker = Validator(array(),array(),array());
        $fanpage = ['fr_id' =>'fan_page_id',
            'fr_data'=>$this->getDataByModel(new FanPage()),
            'fr_private_id' =>'id',
            'fr_select_field' => 'name',
            'label' => 'Fan Page'
        ];
        $socialContentType = ['fr_id' =>'social_content_type_id',
            'fr_data'=>$this->getDataByModel(new SocialContentType()),
            'fr_private_id' =>'id',
            'fr_select_field' => 'name',
            'label' => 'Social Content Type '
        ];

        $this->foreignData = [$fanpage,$socialContentType];
        parent::__construct(new SocialMedia(),$this->privateKey,$this->uniqueFields,$this->validateForm,$this->fieldFile,$this->validateFormUpdate,$this->fieldPath);
    }

    public function index(Request $request){
        $this->request = $request;
        $this->page = $request->get('page');
        if ($request->isMethod('POST')){
            $active = !empty($request->get('active')) ? 1 : 0 ;
            $isVideo = !empty($request->get('is_video')) ? 1 : 0 ;
            if ($isVideo){
                $this->mValidateFormUpdate = array_add($this->validateFormUpdate,'video_link','required');
                $this->mValidateForm = array_add($this->validateForm,'video_link','required');
            }
            $progressData = ['active' => $active,
                'is_video' => $isVideo,
                'title' => $request->get('title'),
                'post_image_url' => $request->get('post_image_url'),
                'video_link' => $request->get('video_link'),
                'fan_page_id' => $request->get('fan_page_id'),
                'full_link' => $request->get('full_link'),
                'video_link' => $request->get('video_link'),
                'separate_image_tag' => $request->get('separate_image_tag'),
                'social_content_type_id' => $request->get('social_content_type_id')
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
        $view = view('admin/setting/socialMedia.socialMediaIndex',['router' => $this->mRouter,'listData'=>$listData,
            'page'=>$this->page,'isEdit'=>$this->request->get('isEdit'),
            'update_data' =>$this->mUpdateData,'foreignData' => $this->foreignData]);

        if($this->validateMaker!=null && count($this->validateMaker->errors()->toArray())>0){
            $message = $this->validateMaker->errors();
            return $view->withErrors($message);
        }

        return $view;

    }

}