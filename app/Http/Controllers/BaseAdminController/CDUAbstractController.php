<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 2/12/17
 * Time: 1:15 PM
 */

namespace App\Http\Controllers\BaseAdminController;

use Illuminate\Database\Eloquent\Model;

abstract class CDUAbstractController extends CDUController{

    public function __construct(Model $model,$privateKey,Array $uniqueField,Array $validateForm,$fieldFile = null,
                                $validateFormUpdate = array(),$fieldPath = array(),$foreignData = array())
    {
        parent::__construct($model, $privateKey, $uniqueField, $validateForm, $fieldFile, $validateFormUpdate, $fieldPath, $foreignData);
    }

    abstract function returnView($data);

}