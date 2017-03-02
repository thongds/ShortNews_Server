<?php

/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 2/2/17
 * Time: 11:03 AM
 */

namespace App\Http\Controllers\Admin\CDUHelper;

use App\Http\Controllers\Helper\GenerateCallback;
use App\Http\Controllers\Helper\MessageKey;
use App\Http\Controllers\Helper\Validate;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class CreateNewNormal{

    protected $mUniqueFields;
    protected $mValidateForm;
    protected $mCheckValidateObject;
    protected $mMessage = array();
    protected $mModel;
    protected $mRequest;
    protected $mProcessData;
    protected $mIsError;
    public function __construct(Model $model){
        $this->mModel = $model;
        $this->mCheckValidateObject = new Validate();
    }

    public function createNewRow(Request $request,Array $processData,Array $uniqueField, Array $validateForm){
        $this->mCheckValidateObject->checkValidate($request,$validateForm);
        $callbackResponse = $this->validateUnique($uniqueField,$processData);
        if(!$callbackResponse->getStatus())
            return $callbackResponse;
        return $this->addNewRow($processData);

    }
    public function validateUnique(Array $uniqueField,Array $processData){
        $response = new GenerateCallback();
        $status = true;
        foreach ($uniqueField as $field){
            if(array_key_exists($field,$processData)){
                $result = $this->mModel->where($field,$processData[$field])->get()->toArray();
                if (!empty($result)){
                    $status = false;
                    $response->setMessage($processData[$field].' was exist');
                }

            }
        }
        $response->setStatus($status);
        return $response;
    }
    public function addNewRow(Array $progressData){
        foreach ($progressData as $field => $data  ){
            $this->mModel->$field = $data;
        }
        $result = $this->mModel->save();
        $response = new GenerateCallback();
        if($result){
            $response->setStatus($result);
            $response->setMessage(MessageKey::createSuccessful);
            $response->setData($this->mModel->id);

        }else{
            $response->setStatus($result);
            $response->setMessage(MessageKey::cannotSave);
        }
        return $response;
    }
    protected function forTest($params){
        return $params;
    }

}