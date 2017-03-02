<?php

/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 2/2/17
 * Time: 2:55 PM
 */
use \Illuminate\Foundation\Testing\DatabaseTransactions;
use \App\Http\Controllers\Admin\CDUHelper\CreateNewNormal;
use \Illuminate\Http\Request;
use \App\Models\Category;
use \Illuminate\Foundation\Validation\ValidationException;
class CreateNewNormalTest extends TestCase{

    use DatabaseTransactions;

    protected $createNewNormalObject;
    protected $model;
    protected $uniqueField;
    protected $validateForm;
    protected $request;
    protected $progressData;
    public function __construct()
    {
        $this->model = new Category();
        $this->uniqueField = ["name"];
        $this->validateForm = ["name" => 'required|numeric'];
        $this->progressData = ["name" => "thongds@gmail.com"];
        $this->request = new Request();
        $this->createNewNormalObject = new CreateNewNormal($this->model);

    }

    public function testPassFormValidate(){
        $this->request->setMethod('POST');
        $this->request->initialize(['name' => "123"]);
        $response = $this->createNewNormalObject->createNewRow($this->request,$this->progressData,
            $this->uniqueField,$this->validateForm);
        $this->assertTrue($response->getStatus());
    }

    public function testIncorrectFormValidate(){
        $this->request->setMethod('POST');
        try {
            $response = $this->createNewNormalObject->createNewRow($this->request,$this->progressData,
                $this->uniqueField,$this->validateForm);
            $this->assertTrue(false);
        }catch (ValidationException $e){
            $this->assertTrue(true);
        }

    }

    public function testValidateUniqueEmptyData(){
        $this->progressData = Array();
        $this->uniqueField = Array();
        $response = $this->createNewNormalObject->validateUnique($this->uniqueField,$this->progressData);
        $this->assertTrue($response->getStatus());
    }
    public function testValidateUniqueEmptyProgressData(){
        $this->progressData = Array();
        $this->uniqueField = ['name'];
        $response = $this->createNewNormalObject->validateUnique($this->uniqueField,$this->progressData);
        $this->assertTrue($response->getStatus());
    }
    public function testValidateUniqueEmptyUniqueData(){
        $this->progressData = ['id' => 1];
        $this->uniqueField = Array();
        $response = $this->createNewNormalObject->validateUnique($this->uniqueField,$this->progressData);
        $this->assertTrue($response->getStatus());
    }
    public function testValidateUniqueFail(){
        $this->progressData = ['name' => 'thongds'];
        $this->uniqueField = ['name'];
        $result = $this->createNewNormalObject->addNewRow($this->progressData);
        $this->assertTrue($result->getStatus());
        $response = $this->createNewNormalObject->validateUnique($this->uniqueField,$this->progressData);
        $this->assertFalse($response->getStatus());
    }
//
    public function testValidateUniqueHaveData(){
        $this->progressData = ['name' => 'thongds'];
        $this->uniqueField = ['name'];
        $response =  $this->createNewNormalObject->addNewRow($this->progressData);
        $this->assertTrue($response->getStatus());
        $response = $this->createNewNormalObject->validateUnique($this->uniqueField,$this->progressData);
        $this->assertFalse($response->getStatus());
    }
    public function testProcessNewRow(){
        $this->uniqueField = ["name"];
        $this->validateForm = ["name" => 'required|numeric'];
        $this->progressData = Array();
        $this->request->setMethod('POST');
        $this->request->initialize(['name' => "13"]);
        try{
            $response =  $this->createNewNormalObject->createNewRow($this->request,$this->progressData,$this->uniqueField,$this->validateForm);
            $this->assertTrue($response->getStatus());
        }catch (Exception $e){
            var_dump($e->getMessage());exit;
            $this->assertTrue(false);
        }
    }
    public function testProtect(){
        $result = $this->invokeMethod($this->createNewNormalObject,'forTest',[true]);
        $this->assertTrue($result);
    }

}