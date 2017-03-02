<?php

/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 1/27/17
 * Time: 10:11 AM
 */
namespace App\Http\Controllers\Admin\CreateData;

use App\Http\Controllers\BaseAdminController\CDUAbstractController;
use App\Http\Controllers\BaseAdminController\CDUController;
use App\Models\Category;
use App\Models\HotSong;
use App\Models\Language;
use App\Models\NewLeastSong;
use App\Models\Singer;
use App\Models\SongDetail;
use App\Models\SongType;
use App\Models\SubtitleType;
use Illuminate\Http\Request;

class SongDetailController extends CDUAbstractController{
    private $mRouter = array('GET' => 'get_song','POST' => 'post_song');
    private $uniqueFields = array('name');
    private $privateKey = 'id';
    private $fieldFile = array('avatar','subtitle_source','song_source');
    private $fieldPath = array('avatar_path','subtitle_source_path','song_source_path');
    private $foreignData ;
    private $validateForm = ['name'=>'required|max:255','duration' => 'required','avatar' => 'required',
        'song_source' => 'required','subtitle_source' => 'required','category_id' => 'required','language_id' => 'required'
        ,'singer_id' => 'required','subtitle_type_id' => 'required','song_type_id' => 'required'];
    private $validateFormUpdate = ['name'=>'required|max:255','duration' => 'required'];
    private $pagingNumber = 10;
    private  $mLimitHostSong = 10;
    private $mLimitNewSongByCategory = 3;
    private $validateMaker;
    public function __construct(){
        $this->validateMaker = Validator(array(),array(),array());
        $categoryInfo = ['fr_id' =>'category_id',
            'fr_data'=>$this->getDataByModel(new Category()),
            'fr_private_id' =>'id',
            'fr_select_field' => 'name',
            'label' => 'Category'
        ];
        $language = ['fr_id' =>'language_id',
            'fr_data'=>$this->getDataByModel(new Language()),
            'fr_private_id' =>'id',
            'fr_select_field' => 'name',
            'label' => 'Language'
        ];
        $singer = ['fr_id' =>'singer_id',
            'fr_data'=>$this->getDataByModel(new Singer()),
            'fr_private_id' =>'id',
            'fr_select_field' => 'name',
            'label' => 'Singer'
        ];
        $subtitleType = ['fr_id' =>'subtitle_type_id',
            'fr_data'=>$this->getDataByModel(new SubtitleType()),
            'fr_private_id' =>'id',
            'fr_select_field' => 'name',
            'label' => 'Subtitle Type'
        ];
        $songType = ['fr_id' =>'song_type_id',
            'fr_data'=>$this->getDataByModel(new SongType()),
            'fr_private_id' =>'id',
            'fr_select_field' => 'name',
            'label' => 'Song Type'
        ];
        $this->foreignData = [$categoryInfo,$language,$singer,$subtitleType,$songType];
        parent::__construct(new SongDetail(),$this->privateKey,$this->uniqueFields,$this->validateForm,$this->fieldFile,$this->validateFormUpdate,$this->fieldPath);
    }

    public function index(Request $request){
        $this->request = $request;
        $this->page = $request->get('page');
        if ($request->isMethod('POST')){
            $active = !empty($request->get('active')) ? 1 : 0 ;
            $progressData = ['active' => $active,'name' => $request->get('name'),'duration' => $request->get('duration'),
                'category_id' => $request->get('category_id'),'language_id' => $request->get('language_id'),
                'singer_id' => $request->get('singer_id'),'subtitle_type_id' => $request->get('subtitle_type_id'),
                'song_type_id' => $request->get('song_type_id')
            ];
            $progressData = array_merge($progressData, $this->progressFileData($request,$this->fieldFile,$progressData));
            $result = $this->progressPost($request,$progressData);
            if($result->getStatus()){
                $progressData= $progressData+['song_detail_id'=>$result->getData()];
                $cduNewLeastSong = new CDUController(new NewLeastSong(),$this->privateKey,$this->uniqueFields,$this->validateForm,$this->fieldFile,$this->validateFormUpdate,$this->fieldPath);
                if($cduNewLeastSong->fifoDatabaseByCategory('new_least_song',$this->mLimitNewSongByCategory,$progressData['category_id'])){
                    $result = $cduNewLeastSong->progressPost($request,$progressData);
                    if(!$result->getStatus()){
                       var_dump('can not insert into newLeastSong');
                       exit;
                    }
                    $this->validateMaker = $result->parseMessageToValidateMaker();
                }else{
                    var_dump('can not delete newLeastSong');
                    exit;
                }
                if(!empty($request->get('is_hot_song')) ? true : false){
                    $cduHotSong = new CDUController(new HotSong(),$this->privateKey,$this->uniqueFields,$this->validateForm,$this->fieldFile,$this->validateFormUpdate,$this->fieldPath);
                    if($cduHotSong->fifoDatabase('hot_song',$this->mLimitHostSong)){
                        $result = $cduHotSong->progressPost($request,$progressData);
                        if(!$result->getStatus()){
                            var_dump('can not insert into hot song');
                            exit;
                        }else{
                            $this->validateMaker = $cduHotSong->progressPost($request,$progressData)->parseMessageToValidateMaker();
                        }

                    }

                }
            }
            $this->validateMaker = $result->parseMessageToValidateMaker();

        }
        if ($request->isMethod('GET')){
            $this->validateMaker = $this->progressGet($request)->parseMessageToValidateMaker();
        }
        return $this->returnView(null);
    }

    public function returnView($data){

        $listData = $this->mainModel->orderBy('created_at')->paginate($this->pagingNumber);
        $view = view('admin/setting/songs.songIndex',['router' => $this->mRouter,'listData'=>$listData,
            'page'=>$this->page,'isEdit'=>$this->request->get('isEdit'),
            'update_data' =>$this->mUpdateData,'foreignData' => $this->foreignData]);

        if($this->validateMaker!=null && count($this->validateMaker->errors()->toArray())>0){
            $message = $this->validateMaker->errors();
            return $view->withErrors($message);
        }

        return $view;

    }

}