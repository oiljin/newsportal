<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 04.02.2016
 * Time: 1:22
 */
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
{
    /**
     * Главная страница
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::all();

        return view('pages/index', ['categories' => $categories]);
    }

    /**
     * Список новостей
     * @param Request $request
     * @param null $alias
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function feed(Request $request, $alias = null)
    {
        $page       = Paginator::resolveCurrentPage('page');
        $per_page   = config('paginator.per_page');
        $category   = Category::where('alias', $alias)->first();
        $order_by   = $request->input('order_by');

        $articles   = Article::whereRaw('1=1');

        switch($order_by) {
            case 'name_desc':   $articles->orderBy('name', 'desc');         break;
            case 'name_asc':    $articles->orderBy('name', 'asc');          break;
            case 'date_desc':   $articles->orderBy('created_at', 'desc');   break;
            case 'date_asc':    $articles->orderBy('created_at', 'asc');    break;
            default:            $articles->orderBy('created_at', 'desc');   break;
        }

        if (is_null($category)) {
            $articles = $articles->paginate($per_page);
        } else {
            $articles = $articles->where('category_id', $category->id)->paginate($per_page);
        }

        if($order_by) {
            $articles->appends('order_by', $order_by);
        }

        return view('pages/feed', [
            'articles'  => $articles,
            'category'  => $category,
            'page'      => $page,
            'order_by'  => $order_by,
        ]);
    }

    /**
     * Страница новости
     * @param Request $request
     * @param $alias
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function article(Request $request, $alias)
    {
        $article = Article::where('alias', $alias)->first();
        if (is_null($article)) {
            abort(404, 'Новость  не найдена');
        }

        return view('pages/article', ['article' => $article]);
    }

    /**
     * Результаты поиска
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $articles = Article::search($request);

        return view('pages/search', ['articles' => $articles, 'q' => $request->input('q')]);
    }


    /**
     * О проекте
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        return view('pages/about');
    }
}