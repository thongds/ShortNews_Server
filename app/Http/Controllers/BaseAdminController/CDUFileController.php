<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 1/26/17
 * Time: 11:43 AM
 */

namespace App\Http\Controllers\BaseAdminController;

use App\Http\Controllers\Helper\GenerateCallback;
use App\Http\Controllers\Helper\Validate;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Helper\ActionKey;
use App\Http\Controllers\Helper\MessageKey;

use App\Http\Controllers\Helper\UtilFunction;

use Validator;

abstract class CDUFileController extends CDUController{

    protected $mFieldFile;
    protected $mFieldPath;
    protected $mValidateFormUpdate;

    public function __construct(array $fieldFile,array $fieldPath,Model $model, $privateKey, array $uniqueField,
                                array $validateForm, array $validateFormUpdate)
    {
        $this->mFieldFile = $fieldFile;
        $this->mFieldPath = $fieldPath;
        $this->mValidateFormUpdate = $validateFormUpdate;

        parent::__construct($model,$privateKey,$uniqueField,$validateForm);
    }

    public function progressPost(Request $request,Array $progressData){
        if($request->get($this->mPrivateKey)==null){
            return $this->createNew($request,$progressData);
        }
        if($request->get($this->mPrivateKey)!=null){
           return $this->updateFile($request,$progressData);
        }
    }
    public function progressGet(Request $request){
        $response = new GenerateCallback();
        if($request->get(ActionKey::delete)){
            $this->deleteOldFile($this->getOldFilePath($request,$this->mFieldPath));
            $response =  $this->delete($request);
        }
        if($request->get(ActionKey::active)!=null){
            $response = $this->active($request);
        }
        if($request->get(ActionKey::isEdit)!=null && $request->get($this->mPrivateKey) != null){
            $this->edit($request);
        }
        return $response;

    }

    private function updateFile(Request $request,Array $progressData){
        if($request->get($this->mPrivateKey) !=null){
            $oldFilePath = array();
            $beforeUpdate = $request->session()->get(ActionKey::session);
            $afterUpdate = [ActionKey::updated_at => UtilFunction::getNow()]+[$this->mPrivateKey => $request->get($this->mPrivateKey)]+$progressData;
            $data = UtilFunction::mergeTwoArray($beforeUpdate,$afterUpdate,[$this->mPrivateKey]);
            $fieldOfDelete = array();
            foreach ($this->mFieldFile as $value){
                if($request->file($value)!=null){
                        $fieldOfDelete = $fieldOfDelete + [$value.'_path'];
                }
            }
            if(!empty($fieldOfDelete)){
               $oldFilePath =  $this->getOldFilePath($request,$fieldOfDelete);
            }
            $response = $this->update($request,$data,$this->mValidateFormUpdate);;
            if($response->getStatus()){
                $this->deleteOldFile($oldFilePath);
            }
            return $response;
        }
    }

    public function getOldFilePath(Request $request,Array $fieldOfPathDelete){
        $oldFilePath = array();
        $data = $this->mainModel->where($this->mPrivateKey,$request->get($this->mPrivateKey))->get()->toArray();
        if($data !=null){
            foreach ($fieldOfPathDelete as $value){
                array_push($oldFilePath,$data[0][$value]);
            }
        }
        return $oldFilePath;
    }
    public function deleteOldFile(Array $filePath){
        foreach ($filePath as $value){
            unlink($value);
        }
    }
    public function progressFileData(Request $request,Array $fieldFile,Array $progressFileData){
        foreach ($fieldFile as $item){
            $fileUpload = $this->_getFilePath($request->file($item));
            if($fileUpload !=null)
                $progressFileData = array_merge($progressFileData,[$item => $fileUpload['link'],
                    $item.'_path' => $fileUpload['path']]);
        }
        return $progressFileData;
    }

    protected function _getFilePath($file_upload){
        if($file_upload == null)
            return '';
        $file_name = time().'_random_'.rand(5, 100).$file_upload->getFilename().'.'.$file_upload->getClientOriginalExtension();
        $file_upload->move(public_path("uploads"), $file_name);
        $fileData = ['link' =>url('/').'/uploads/'.$file_name,'path' =>public_path("uploads").'/'.$file_name ];
        return  $fileData;
    }

}