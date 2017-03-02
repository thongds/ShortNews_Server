<?php

/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 2/2/17
 * Time: 4:08 PM
 */
use \App\Http\Controllers\Helper\Validate;
use \Illuminate\Http\Request;
use \Illuminate\Foundation\Validation\ValidationException;
class ValidateTest extends TestCase
{
    protected $validateObject;
    protected $request;
    protected $validateForm;
    public function __construct(){
        $this->request = new Request();
        $this->validateObject = new Validate();
    }

    public function testValidateSuccessful(){
        $this->request->setMethod('POST');
        $this->validateForm = ['name' => 'required|max:255'];
        $this->request->initialize(["name" => "thongds@gmail.com"]);
        try{
            $this->validateObject->checkValidate($this->request,$this->validateForm);
            //$this->assertTrue(true);
        }catch (ValidationException $e){
            $this->assertTrue(false);
        }

    }
    public function testValidateFail(){
        $this->request->setMethod('POST');
        $this->validateForm = ['name' => 'required|max:255'];
        try{
            $this->validateObject->checkValidate($this->request,$this->validateForm);
        }catch (ValidationException $e){
            $this->assertTrue(true);
        }

    }
    public function testValidateRequestNull(){
        $this->request->setMethod('POST');
        $this->validateForm = ['name' => 'required|max:255'];
        try{
            $this->validateObject->checkValidate(null,$this->validateForm);
        }catch (Exception $e){
            $this->assertTrue(true);
        }

    }
    public function testValidateValidateFormNull(){
        $this->request->setMethod('POST');
        $this->validateForm = ['name' => 'required|max:255'];
        try{
            $this->validateObject->checkValidate($this->request,null);
            $this->assertTrue(false);
        }catch (Exception $e){
            $this->assertTrue(true);
        }

    }
    public function testCheckEmpty(){
        $object = new Validate();
        $request = new Request();
        $request->initialize(['test' => 'test']);
        $return = $object->checkValidate($request,Array());
        $this->assertNull($return);
    }

}