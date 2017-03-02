<?php

/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 1/24/17
 * Time: 2:14 PM
 */
namespace App\Http\Controllers\Helper;

abstract class ActionKey {
    const delete = "delete";
    const active = "active";
    const isEdit = "isEdit";
    const session = 'update_session';
    const create_at = 'created_at';
    const updated_at = 'updated_at';
}
