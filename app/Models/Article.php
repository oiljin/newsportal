<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use SleepingOwl\Models\Interfaces\ModelWithImageFieldsInterface;
use SleepingOwl\Models\SleepingOwlModel;

class Article extends SleepingOwlModel  implements ModelWithImageFieldsInterface
{
    use SoftDeletes;


    protected $fillable = ['name', 'alias', 'image', 'intro','text', 'category_id'];


    public function getImageFields()
    {
        return [
            'image' => 'articles/',
        ];
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function save(array $options = array())
    {
        $this->alias = $this->alias ? str_slug($this->alias) : str_slug($this->name);
        $saved = parent::save($options);

        return $saved;
    }

    /**
     * Полнотекстовый поиск с разбивкой на страницы
     * @param $request
     * @return LengthAwarePaginator
     */
    public static function search($request)
    {
        $results    = [];
        $search     = $request->input('q');
        $path       = Paginator::resolveCurrentPath();
        $page       = Paginator::resolveCurrentPage('page');
        $per_page   = config('paginator.per_page');
        $offset     = ((int)$page - 1) * $per_page;

        $sql = 'SELECT SQL_CALC_FOUND_ROWS A.*, MATCH(A.name, A.text) AGAINST (?) AS score
                FROM articles AS A
                WHERE MATCH(A.name, A.text) AGAINST (?)
                ORDER BY score DESC, A.name ASC LIMIT ? OFFSET ?';

        $articles_ids   = DB::select($sql, [$search, $search, $per_page, $offset]);
        $total          = DB::select('SELECT FOUND_ROWS() AS total')[0]->total;

        foreach ($articles_ids as $item) {
            $results[] = Article::find($item->id);
        }

        $paginator = new LengthAwarePaginator($results, $total, $per_page, $page, ['path' => $path]);
        $paginator->appends('q', $search);

        return $paginator;
    }
}
