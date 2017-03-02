<?php

/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 2/7/17
 * Time: 8:54 AM
 */
use \App\Models\Category;
use  App\Http\Controllers\BaseAdminController\CDUController;
class CDUControllerTest extends TestCase{

    private $uniqueFields = array('name');
    private $privateKey = 'id';
    private $validateForm = ['name'=>'required|max:255'];
    private $pagingNumber = 3;
    private $validateMaker;
    private $object;
    public function __construct(){
        parent::createApplication();
    }

    public function testProgressUpdateData(){
        //$var = $this->object->forTest();
//        $classPath = 'App\Http\Controllers\BaseAdminController\CDUController';
//        $mockObject = $this->invokeConstruct($classPath,[new Category(),'id',array(),array()]);
//        $beforeArray = ['name' => '123','id' => 2];
//        $afterArray = ['name' => '123','test'=>'123','id' => 1];
//        $result = $this->invokeMethod($mockObject,'progressUpdateData',[$afterArray,$beforeArray]);
//        $this->assertEquals(count($result),3);
    }

}
