@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>О сайте</h1>
        </div>
    </div>

    <div class="row">
        <div class="jumbotron">
            <h2>Сайт новостей</h2>
            <h3>Автор: <a target="_blank" href="http://iljin-oleg.ru/">Ильин Олег</a></h3>
            <p>
                Технологии и инструменты:
            </p>

            <ul>
                <li>Laravel 5.1</li>
                <li>Sleeping Owl</li>
                <li>MySql</li>
                <li>Gulp</li>
                <li>Bower</li>
                <li>Stylus</li>
                <li>Bootstrap</li>
                <li>jQuery</li>
            </ul>

            <h2>JSON api</h2>

            <p>Вызов осуществляется по адресу http://job.iljin-oleg.ru/api.php</p>
            <small>Пример вызова:
                <a target="_blank" href="http://job.iljin-oleg.ru/api.php?page=2&order_by=date_asc&category=3">http://job.iljin-oleg.ru/api.php?page=2&order_by=date_asc&category=3</a>
            </small>

            <br>
            <br>
            <p>Api принимает GET параметры</p>

            <ul>
                <li><b>page</b> - номер страницы. Значения от 1 до кол-ва страниц.</li>
                <li><b>order_by</b> - порядок сортировки
                    <br> Принимает значения:
                    <ul>
                        <li>name_asc</li>
                        <li>name_desc</li>
                        <li>date_asc</li>
                        <li>date_desc</li>
                    </ul>
                </li>
                <li>category - идентификатор категории</li>
            </ul>

            <p>В ответ отдается объект с двумя ключами:</p>
            <ul>
                <li><b>pager</b> - пагинатор с информацией о текущем положении (текущая страница, общее кол-во страниц и тд.)</li>
                <li><b>items</b> - массив с результатами выборки</li>
            </ul>

            <p>PS: если вызвать api скрипт без параметров,
                то по умолчанию выводятся новости из всех категорий
                и конфигурация будет иметь параметры
            </p>
            <ul>
                <li>page = 1</li>
                <li>order_by = date_desc</li>
            </ul>

        </div>
    </div>


@endsection