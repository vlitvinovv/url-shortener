# О проекте

**Symfony + DDD + CQRS + Onion Architecture + RabbitMQ**

HTTP-сервис, который генерирует короткие ссылки. При переходе по короткой ссылке пользователя редиректит на необходимый url, а информация о пользователе (user agent и ip) отправляется в RabbitMQ очередь. Далее Analytic модуль сохраняет информацию. Analyic модуль позволяет смотреть статистику переходов по короткой ссылке.

# API

**Создание ссылок**

**POST** /links  
Преобразует длинный URL-адрес в короткую ссылку.  
**long_url**  
**tags** array  
**title** string


**Пример запроса:**  
curl \  
-H 'Content-Type: application/json' \  
-X POST \  
-d '{  
"long_url": "[https://google.com&quot](https://google.com%26quot/),  
"title": "Cool link to google",  
"tags": ["homepage", "mylink"]  
}' \  
[https://your.service.com/links](https://your.service.com/links)

_В запросе реализована возможность передать массив ссылок, которые нужно сократить:_


curl \  
-H 'Content-Type: application/json' \  
-X POST \  
-d '[{  
"long_url": "[https://google.example.com&quot](https://google.example.com%26quot/);,  
"title": "Cool link to google",  
"tags": ["search_engines", "google"]  
},{  
"long_url": "[https://yandex.example.com&quot](https://yandex.example.com%26quot/);,  
},{  
"long_url": "[https://bing.example.com&quot](https://bing.example.com%26quot/);,  
"tags": ["search_engines", "bing"]  
}]' \  
[https://your.service.com/links](https://your.service.com/links)


**Обновление информации о ссылке  
PATCH** /links/{id}  
_Пример запроса:_  
curl \  
-H 'Content-Type: application/json' \  
-X PATCH \  
-d '{  
"long_url": "[https://yahoo.example.com&quot](https://yahoo.example.com%26quot/);,  
"title": "Yahoo",  
"tags": [  
"search_engine",  
"yahoo"  
]  
}' \  
[https://your.service.com/links/12a4b6c](https://your.service.com/links/12a4b6c)


**Удаление ссылки по id  
DELETE** /links/{id}


**Получение ссылки по id  
GET** /links/{id} curl -X GET [https://your.service.com/links/12a4b6c](https://your.service.com/links/12a4b6c)

**Получение всех ссылок  
GET** /links curl -X GET [https://your.service.com/links](https://your.service.com/links)


**Статистика**  
**Получение статистики по id ссылки**  
**GET** /stats/{id}  
_Пример запроса:_

curl -X GET [https://your.service.com/stats/12a4b6c](https://your.service.com/stats/12a4b6c)  
**_Ответ сервера (200)_  
total_views - Кол-во всех переходов по ссылке  
unique_views - Кол-во переходов по ссылке уникальных пользователей (в зависимости от ip и User Agent)  
{  
"total_views": "number",  
"unique_views": "number"   
}
