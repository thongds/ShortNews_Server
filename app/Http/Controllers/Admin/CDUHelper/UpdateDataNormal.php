<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 2/3/17
 * Time: 3:07 PM
 */

namespace App\Http\Controllers\Admin\CDUHelper;


use App\Http\Controllers\Helper\GenerateCallback;
use App\Http\Controllers\Helper\MessageKey;
use App\Http\Controllers\Helper\MyException;
use App\Http\Controllers\Helper\Validate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;

class UpdateDataNormal extends CreateNewNormal{

    protected  $mModel;
    protected $validateObject;
    public function __construct(Model $model){
        $this->mModel = $model;
        $this->validateObject = new Validate();
    }
    public function validateUpdateRowById(Array $progressData){
        $response = new GenerateCallback();
        $response->setStatus(true);
        if(!array_key_exists('id',$progressData) || (array_key_exists('id',$progressData) && empty($progressData['id']))){
                $response->setStatus(false);
                $response->setMessage(MessageKey::cannotUpdate);
         }
        return $response;
    }
    public function update(Request $request,Array $uniqueForm,Array $validateForm,Array $progressData){
        $this->validateObject->checkValidate($request,$validateForm);
        $responseCheckId = $this->validateUpdateRowById($progressData);
        if(!$responseCheckId->getStatus())
            return $responseCheckId;
        $uniqueResponse = $this->validateUnique($uniqueForm,$progressData);
        if(!$uniqueResponse->getStatus())
            return $uniqueResponse;
        $response = new GenerateCallback();
        if($this->updateRow($progressData['id'],$progressData)){
                $response->setStatus(true);
                $response->setMessage(MessageKey::updateSuccessful);
        }else{
                $response->setStatus(false);
                $response->setMessage(MessageKey::cannotUpdate);
        }

        return $response;
    }
    public function updateRow($id,$progressData){
        $databaseResult = $this->mModel->find($id);
        if(empty($databaseResult))
            return false;
        foreach ($progressData as $field => $data  ){
            $databaseResult->$field = $data;
        }
        return $databaseResult->save();
    }
    public function getForeignData($foreignData = array()){
        $result = array();
        $this->checkFormatForeignData($foreignData);
        foreach ($foreignData as $key => $value){
            $result['fr_id'] = $key;
            foreach ($value as $key1 => $value1){
                if($key1 == 'private_id'){
                    $result['fr_private_id'] = $value[$key1];
                }
                if($key1 == 'fr_table_model'){
                    $result['fr_data'] = $value1->where('active',1)->get();
                }
                if($key1=='label'){
                    $result['label'] = $value[$key1];
                }
                if($key1 == 'fr_select_field'){
                    $result['fr_select_field'] = $value[$key1];
                }
            }
        }
        return $result;
    }
    public function checkFormatForeignData($foreignData = array()){
        if(count($foreignData)>0){
            foreach ($foreignData as $key => $value){
                if(!is_string($key))
                    throw new MyException(MessageKey::fr_id_exception);
                if(count($value)!=3)
                    throw new MyException(MessageKey::numbers_of_data_not_correct);
                if(!array_key_exists('fr_table_model',$value)||!array_key_exists('private_id',$value)||!array_key_exists('label',$value))
                    throw new MyException(MessageKey::fr_table_name_and_private_id);
                foreach ($value as $key1 => $value1){
                    if($key1 == 'fr_table_model'){
                        if(!($value1 instanceof Model))
                            throw new MyException(MessageKey::fr_table_name_not_a_model);
                    }
                }
            }
        }
    }
}