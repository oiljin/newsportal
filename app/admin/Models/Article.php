<?php

Admin::model(App\Models\Article::class)->title('Новости')->with()->filters(function () {

})->columns(function () {
    Column::string('name', 'Заголовок');
    Column::category('category_id', 'Категория');
    Column::string('alias', 'Альяс');
    Column::image('image')->sortable(false);
})->form(function () {
    FormItem::select('category_id', 'Категория')->list(\App\Models\Category::class)->required();
    FormItem::text('name', 'Заголовок');
    FormItem::text('alias', 'Альяс');
    FormItem::image('image', 'Рисунок');
    FormItem::ckeditor('intro', 'Интро');
    FormItem::ckeditor('text', 'Текст');
});