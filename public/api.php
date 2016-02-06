<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 05.02.2016
 * Time: 1:11
 */

class DB {
    private $host   = 'localhost';
    private $dbname = '';
    private $user   = '';
    private $pass   = '';

    private $dbh    = null;

    public function __construct()
    {
        $this->dbh = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->user, $this->pass);
    }

    /**
     * Выполняет SQl запрос и возвращает результат в виде массива объектов
     * @param $sql
     * @param $params
     * @return array
     */
    public function select($sql, $params)
    {
        $stmt = $this->dbh->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindParam($key, $val);
        }

        $result = [];

        if ($stmt->execute()) {
            while ($row = $stmt->fetchObject()) {
                $result[] = (object)$row;
            }
        }

        return $result;
    }

    public function __destruct()
    {
        $this->dbh = null;
    }
}

class ArrHelper {
    /**
     * Возвращает значение ключа $key из массива $arr,
     * в случае отсутствия ключа возвращается $default
     * @param $arr
     * @param $key
     * @param null $default
     * @return null
     */
    public static function get($arr, $key, $default = null) {
        return isset($arr[$key]) ? $arr[$key] : $default;
    }

    /**
     * Возвращает значения ключе $keys из массива $arr,
     * каждый отсутствующий ключ принимает значение $default
     * @param $arr
     * @param $keys
     * @param null $default
     * @return object
     */
    public static function extract($arr, $keys, $default = null) {
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = static::get($arr, $key, $default);
        }

        return (object)$result;
    }
}

class ApiCategory {
    private $db;
    private $order_valid = [
        'name_asc', 'name_desc',
        'date_asc', 'date_desc',
    ];

    private $category   = 0;
    private $page       = 1;
    private $per_page   = 3;
    private $order_by   = ' A.created_at DESC';

    public function __construct()
    {
        $this->db = new DB();
        $this->parseRequest();
    }

    /**
     * Расчитывает пагинатор
     * @return object
     */
    private function getPager () {
        $sql = 'SELECT COUNT(*) AS count_items FROM articles WHERE deleted_at IS NULL';
        $params = [];

        if ($this->category !== 0) {
            $sql .= ' AND category_id=:id';
            $params[':id'] = $this->category;
        }

        $count_items    =  $this->db->select($sql, $params);
        $count_items    = (int)$count_items[0]->count_items;

        $total_page     = (int)ceil($count_items / $this->per_page);
        $current_page   = (int)$this->page > $total_page ? $total_page : ($this->page < 1 ? 1 : $this->page);
        $next           = $current_page === $total_page ? null : $current_page + 1;
        $prev           = $current_page === 1 ? null : $current_page - 1;

        return (object)array_filter([
            'current_page'  => $current_page,
            'next'          => $next,
            'prev'          => $prev,
            'total_page'    => $total_page,
            'total_items'   => $count_items,
        ]);
    }

    /**
     * Извлекает и валидирует входные данные - get параметры
     */
    private function parseRequest() {
        $form           = ArrHelper::extract($_GET, ['page', 'category', 'order_by']);

        $this->page     = is_null($form->page) ? $this->page : (int)$form->page;
        $this->category = is_null($form->category) ? $this->category : (int)$form->category;

        switch($form->order_by) {
            case 'name_desc':   $this->order_by = ' A.name DESC';         break;
            case 'name_asc':    $this->order_by = ' A.name ASC';          break;
            case 'date_desc':   $this->order_by = ' A.created_at DESC';   break;
            case 'date_asc':    $this->order_by = ' A.created_at ASC';    break;
            default:            $this->order_by = ' A.created_at DESC';   break;
        }
    }

    /**
     * Возвращет массив новостей
     * @return array
     */
    public function getNews()
    {
        $pager  = $this->getPager();
        $offset = ($pager->current_page - 1) * $this->per_page;
        $params = [];

        $sql = 'SELECT A.id, A.name, A.alias, A.image,
                       A.intro, A.text,
                       A.created_at, A.updated_at,
                       A.category_id, B.name AS category_name
                FROM articles AS A
                  LEFT JOIN categories AS B ON B.id=A.category_id
                WHERE A.deleted_at IS NULL';

        if ($this->category !== 0) {
            $sql .= ' AND A.category_id=:category';
            $params[':category'] = $this->category;
        }

        $sql .= ' ORDER BY ' . $this->order_by . ' LIMIT '.(int)$this->per_page.' OFFSET '. (int)$offset;
        $result = $this->db->select($sql, $params);

        return [
            'pager' => $pager,
            'items' => $result,
        ];
    }
}


$api = new ApiCategory();
$news = $api->getNews();

header('Content-Type:application/json');
echo json_encode($news);