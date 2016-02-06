<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 21.09.2015
 * Time: 12:19
 */

namespace App\Classes\Admin;


use SleepingOwl\Admin\Columns\Column\BaseColumn;

/**
 * Кастомное поле для вывода названия категории в админке
 * Class CategoryColumn
 * @package App\Classes\Admin
 */
class CategoryColumn extends BaseColumn
{
    public function render($instance, $totalCount)
    {
        $val = $instance->category->name;

        return parent::render($instance, $totalCount, $val);
    }
}