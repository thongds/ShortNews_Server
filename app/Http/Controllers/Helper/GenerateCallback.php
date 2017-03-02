<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 2/3/17
 * Time: 1:39 PM
 */

namespace App\Http\Controllers\Helper;
use Validator;

class GenerateCallback {
    private $status = true;
    private $responseMessage = Array();
    public $statusJsonKey = "status";
    public $messageJsonKey = "message";
    private $mValidateMaker;
    private $mData = null;
    public function __construct($status = false,Array $message = Array()){
        $this->status = (boolean)$status;
        $this->responseMessage = $message;
        $this->mValidateMaker = Validator(array(),array(),array());
    }

    public function getStatus(){
        return $this->status;
    }
    public function getMessage(){
        return $this->responseMessage;
    }
    public function getData(){
        return $this->mData;
    }
    public function setData($data){
        $this->mData = $data;
    }
    public function responseJSON(){
        $jsonFormat = [$this->statusJsonKey => $this->status,$this->messageJsonKey => $this->responseMessage];
        return json_encode($jsonFormat);
    }
    public function setStatus($status){
        $this->status = $status;
    }
    public function setMessage($message){
        if(is_string($message) || is_integer($message)){
            array_push($this->responseMessage,$message);
            return true;
        }else{
            echo __CLASS__.' wrong format at '.__FUNCTION__.' function ';
            return false;
        }

    }
    public function parseMessageToValidateMaker($message = null){
        $this->mValidateMaker = Validator(array(),array(),array());

        if($message == null){
            foreach ($this->getMessage() as $key => $value){
                $this->mValidateMaker->errors()->add('field',$value);
            }
        }else{
            if(is_array($message)){
                foreach ($message as $key => $value){
                    $this->mValidateMaker->errors()->add('field',$value);
                }
            }
        }

        return $this->mValidateMaker;

    }

}