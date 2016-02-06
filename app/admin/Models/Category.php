<?php

Admin::model(App\Models\Category::class)->title('Категории')->with()->filters(function () {

})->columns(function () {
    Column::string('id', 'ID');
    Column::string('name', 'Название');
    Column::string('alias', 'Альяс');
    Column::image('image', 'Рисунок');
})->form(function () {
    FormItem::text('name', 'Название');
    FormItem::text('alias', 'Альяс');
    FormItem::image('image', 'Рисунок');
});