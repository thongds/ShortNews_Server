<?php

/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 2/4/17
 * Time: 9:34 AM
 */
use \App\Http\Controllers\Admin\CDUHelper\DeleteDataNormal;
use \App\Models\Category;
use \Illuminate\Foundation\Testing\DatabaseTransactions;
class DeleteDataNormalTest extends TestCase{

    use DatabaseTransactions;

    public $mDeleteObject;
    public $realId;
    public $model;
    public function __construct(){
        $this->model = new Category();
        $this->mDeleteObject = new DeleteDataNormal($this->model);
    }

    public function testDeleteByFakeId(){
        $result = $this->mDeleteObject->deleteById(-1);
        $this->assertFalse($result->getStatus());
    }
    public function testDeleteByRealId(){
//        $data = $this->mDeleteObject->mModel->get()->first()->toArray();
//        $this->realId = $data['id'];
//        $result = $this->mDeleteObject->deleteById($this->realId);
//        $this->assertTrue($result->getStatus());
    }
}