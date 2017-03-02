<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 2/9/17
 * Time: 4:58 PM
 */

namespace App\Http\Controllers\BaseAdminController;


use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

trait FileSupport{

    public function __construct(){

    }
    public function getOldFilePath(Request $request,Model $model,$privateKey,Array $fieldOfPathDelete){
        $oldFilePath = array();
        $data = $model->where($privateKey,$request->get($privateKey))->get()->toArray();
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