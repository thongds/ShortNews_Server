<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 2/4/17
 * Time: 9:31 AM
 */

namespace App\Http\Controllers\Admin\CDUHelper;


use App\Http\Controllers\Helper\GenerateCallback;
use App\Http\Controllers\Helper\MessageKey;
use Illuminate\Database\Eloquent\Model;


class DeleteDataNormal{

    public $mModel;

    public function __construct(Model $model){
        $this->mModel = $model;
    }

    public function deleteById($id){
        $response = new GenerateCallback();
        $result = (bool)$this->mModel->destroy($id);
        if($result){
            $response->setStatus($result);
            $response->setMessage(MessageKey::deleteSuccessful);
        }
        else{
           $response->setStatus($result);
            $response->setMessage(MessageKey::cannotDelete);
        }
        return $response;
    }

}