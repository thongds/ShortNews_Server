<?php

/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 2/3/17
 * Time: 3:08 PM
 */
use \App\Http\Controllers\Admin\CDUHelper\UpdateDataNormal;
use Illuminate\Http\Request;
use \App\Models\Category;
use \Illuminate\Foundation\Validation\ValidationException;
use \Illuminate\Foundation\Testing\DatabaseTransactions;
use \App\Http\Controllers\Helper\MessageKey;
use App\Http\Controllers\Helper\MyException;

class UpdateDataNormalTest extends TestCase{


    use DatabaseTransactions;

    protected $updateObject;
    protected $model;
    protected $uniqueField;
    protected $validateForm;
    protected $request;
    protected $progressData;

    public function __construct(){
        $this->model = new Category();
        $this->uniqueField = ["name"];
        $this->validateForm = ["name" => 'required|numeric'];
        $this->progressData = ["name" => "thongds@gmail.com"];
        $this->request = new Request();
        $this->request->initialize(['name' => '123']);
        $this->updateObject = new UpdateDataNormal($this->model);

    }

    public function testUpdateValidateForm(){
        $this->request->initialize(['name' => 'thongds']);
        $this->request->setMethod('POST');
        try{
            $response = $this->updateObject->update($this->request,$this->uniqueField,$this->validateForm,$this->progressData);
            $this->assertTrue(false);
        }catch (ValidationException $ex){
            $this->assertFalse(false);
        }
    }

    public function testUpdateIDNullException(){
        $this->progressData = ['name' => "123"];
        $this->request->setMethod('POST');
        $response = $this->updateObject->validateUpdateRowById($this->progressData);
        $this->assertFalse($response->getStatus());
        foreach ($response->getMessage() as $message){
            $this->assertEquals($message,MessageKey::cannotUpdate);
        }
    }

    public function testUpdateIDEmptyException(){
        $this->progressData = ['name' => "123",'id'=>''];
        $this->request->setMethod('POST');
        $response = $this->updateObject->validateUpdateRowById($this->progressData);
        $this->assertFalse($response->getStatus());
        foreach ($response->getMessage() as $message){
            $this->assertEquals($message,MessageKey::cannotUpdate);
        }
    }

    public function testUpdateRowFakeId(){
        $response = $this->updateObject->updateRow(-1,$this->progressData);
        $this->assertFalse($response);
    }
    public function testUpdateRowEmptyProgressData(){
        $data = $this->model->where('active',1)->first()->toArray();
        $response = $this->updateObject->updateRow($data['id'],$this->progressData);
        $this->assertTrue($response);
    }

    public function testGetForeignData(){
        $data = $this->updateObject->getForeignData(array());
        $this->assertEquals(0,count($data));
    }
    public function testCheckFormatForeignData(){
        try{
            $this->updateObject->checkFormatForeignData(['fr_id'=>
            ['fr_table_model' => new Category(),
            'private_id' => 1,
            'label' => 'category']]);
            $this->assertTrue(true);
        }catch (MyException $e){
            $this->assertTrue(false);
        }
    }
    public function testCheckFormatForeignDataWrongFormat(){
        try{
            $this->updateObject->checkFormatForeignData([1=>
                ['fr_table_model' => '234',
                    'private_id' => 1,
                    'label' => 'category']]);
            $this->assertTrue(false);
        }catch (MyException $e){
            $this->assertEquals(MessageKey::fr_id_exception,$e->getMessage());
        }
        try{
            $this->updateObject->checkFormatForeignData(['fr_id'=>
                ['fr_table_name_2' => '',
                    'private_id' => 1,
                    'label' => 'category']]);
            $this->assertTrue(false);
        }catch (MyException $e){
            $this->assertEquals(MessageKey::fr_table_name_and_private_id,$e->getMessage());
        }
        try{
            $this->updateObject->checkFormatForeignData(['fr_id'=>
                ['fr_table_model' => '',
                    'private_id_2' => 1,
                    'label' => 'category']]);
            $this->assertTrue(false);
        }catch (MyException $e){
            $this->assertEquals(MessageKey::fr_table_name_and_private_id,$e->getMessage());
        }
        try{
            $this->updateObject->checkFormatForeignData(['fr_id'=>
                ['fr_table_name_2' => '',
                    'private_id_2' => 1,
                    'label' => 'category']]);
            $this->assertTrue(false);
        }catch (MyException $e){
            $this->assertEquals(MessageKey::fr_table_name_and_private_id,$e->getMessage());
        }
        try{
            $this->updateObject->checkFormatForeignData(['fr_id'=>
                ['fr_table_model' => '',
                    'private_id' => 1,
                    'label' => 'category']]);
            $this->assertTrue(false);
        }catch (MyException $e){
            $this->assertEquals(MessageKey::fr_table_name_not_a_model,$e->getMessage());
        }
    }

}