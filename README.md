## Технологии и инструменты:
  - Laravel 5.1
  - Sleeping Owl
  - MySql
  - Gulp
  - Bower
  - Stylus
  - Bootstrap
  - jQuery
 
## JSON api
Вызов осуществляется по адресу http://job.iljin-oleg.ru/api.php

Пример вызова:
```
http://job.iljin-oleg.ru/api.php?page=2&order_by=date_asc&category=3 
```

## Api принимает GET параметры
**category** - идентификатор категории  
**page** - номер страницы. Значения от 1 до кол-ва страниц.     
**order_by** - порядок сортировки

Order by принимает значения:    
 - name_asc
 - name_desc   
 - date_asc    
 - date_desc


### В ответ отдается объект с двумя ключами:

**pager** - пагинатор с информацией о текущем положении (текущая страница, общее кол-во страниц и тд.)  
**items** - массив с результатами выборки

#### PS: если вызвать api скрипт без параметров, то по умолчанию выводятся новости из всех категорий и конфигурация будет иметь параметры

**page** = 1    
**order_by** = date_desc