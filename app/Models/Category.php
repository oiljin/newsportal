<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use SleepingOwl\Models\Interfaces\ModelWithImageFieldsInterface;
use SleepingOwl\Models\SleepingOwlModel;

class Category extends SleepingOwlModel  implements ModelWithImageFieldsInterface
{
    use SoftDeletes;

    protected $fillable = ['name', 'alias', 'image'];


    public function getImageFields()
    {
        return [
            'image' => 'category/',
        ];
    }

    public function save(array $options = array())
    {
        $this->alias = $this->alias ? str_slug($this->alias) : str_slug($this->name);
        $saved = parent::save($options);

        return $saved;
    }

    public function articles()
    {
        return $this->hasMany('App\Models\Article');
    }

    public static function getList()
    {
        $categories_ = self::all(['id', 'name']);
        $categories = [];
        foreach($categories_ as $category){
            $categories[$category->id] = $category->name;
        }

        return $categories;
    }
}
