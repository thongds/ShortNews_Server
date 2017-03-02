<?php

/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 2/4/17
 * Time: 2:49 PM
 */
use \App\Http\Controllers\Helper\GenerateCallback;
class GenerateCallbackTest extends TestCase
{
    private $object;
    public function __construct(){
        parent::createApplication();
        $this->object = new GenerateCallback();
    }

    public function testSetStatus(){
        $this->object->setStatus(true);
        $this->assertTrue($this->object->getStatus());
    }
    public function testSetMessage(){
        $message = 'message';
        for($i= 0 ; $i < 10 ;$i++ ){
            $this->object->setMessage($message);
        }
        $this->assertEquals(count($this->object->getMessage()),10);
    }
    public function testSetMessageReturnCorrectFormat(){
        $message = 'message';
        for($i= 0 ; $i < 10 ;$i++ ){
            $this->object->setMessage($message);
        }
        for($i=0;$i<10;$i++){
            $this->assertEquals($this->object->getMessage()[$i],$message);
        }

    }
    public function testSetMessageInputData(){
        $result = $this->object->setMessage(['a' =>'n']);
        $this->assertFalse($result);
        $result = $this->object->setMessage(['n']);
        $this->assertFalse($result);
    }
    public function testParseToValidateMaker_autoParse(){
        $object = new GenerateCallback();
        $object->setMessage('helloWorld');
        $object->setMessage('hello everybody');
        $validator = $object->parseMessageToValidateMaker();
        $validatorArray =$validator->errors()->toArray();
        $result = array_key_exists('field',$validatorArray);
        $this->assertTrue($result);
        $messageArray = $validatorArray['field'];
        $this->assertEquals(count($messageArray),2);
    }
    public function testParseToValidateMaker_customDataWrongFormat(){
        $object = new GenerateCallback();
        $validator = $object->parseMessageToValidateMaker('string');
        $validatorArray = $validator->errors()->toArray();
        $this->assertEquals(count($validatorArray),0);
    }
    public function testParseToValidateMaker_customDataCorrectFormat(){
        $object = new GenerateCallback();
        $validator = $object->parseMessageToValidateMaker(['abc' => 'string','nextString']);
        $validatorArray = $validator->errors()->toArray();
        $messageArray = $validatorArray['field'];
        $this->assertEquals(count($validatorArray['field']),2);
        foreach ($messageArray as $index => $value){
            if($index == 0)
                $this->assertEquals('string',$value);
            if($index == 1)
                $this->assertEquals('nextString',$value);
        }

    }
}
