<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 13/04/2020
 * Time: 12:36 PM
 */

namespace Dlabs\PaginateApi\Test;


use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    protected $table = 'test_models';

    protected $guarded = [];
}