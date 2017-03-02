<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 1/25/17
 * Time: 11:15 AM
 */

namespace App\Http\Controllers\Helper;


abstract class MessageKey{
    const createSuccessful = "create new Successful!";
    const cannotSave = "can not save!";
    const wasExist = "was exist!";
    const updateSuccessful = "Update Successful!";
    const cannotUpdate = "can not update!";
    const cannotDelete = "can not delete!";
    const deleteSuccessful = "delete successful!";
    const update_exception_message = 'format of data is not correct!';
    const fr_id_exception = 'fr_id key must be a string';
    const fr_table_name_and_private_id = 'not contain fr_table_name or private_id or label';
    const fr_table_name_not_a_model = 'fr_table_name is not a model';
    const numbers_of_data_not_correct = 'number of array must be equal 3';
}