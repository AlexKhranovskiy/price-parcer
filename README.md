### Storage file application
without the framework
#### Vocation
Praction with REST API and file storing on server side using PHP. Praction with MVC, SOLID.
#### Description
Application uses Repository design pattern. Application has REST API, receives file with using HTTP method POST, 
encodes file name, stores in folder 'Files', is able to output all stored files' information and errors in JSON
format, is able to delete info about file and file themself by inputted id. All are stored files' names are 
encoded in uniquals names.

Application handles exceptions in cases:
* Wrong URI
* Can not connect to DB
* Can not delete file
* Can not upload large file

Application has config for:
* DB
* Storing directory
* Routes
#### How to run
* Clone the repository 
* Create file (in root dir of project) .env and copy data from .env.example in it
* ```docker-compose up -d```
* ```docker exec -it 60_mysql_1 /bin/sh```
* ```mysql -u root -p ``` password is: secret
* ```use mydb;```
* Run SQL queries:
```sql
create table files(
    id int not null auto_increment,
    name varchar(255) not null,
    directory varchar(255) not null,
    stored_at datetime,
    primary key (id)
) default character set utf8;

```
* For get all information about files send:
```http request
GET http://localhost:80/api/files
Accept: application/json

###
```
Or open in browser http://localhost/api/files
* To send file to server use curl (where 1.jpg is file name of existing file):
```
curl -X POST -H "Content-Type: multipart/form-data" -H "Accept: application/json" -F "file_image=@1.jpg" http://localhost:80/api/files
```
* To delete file and it's info send:
```http request
DELETE http://localhost:80/api/files/id
Accept: application/json

###
```
Change id to number.

#### Some examples
```http request
GET http://localhost:80/api/files

HTTP/1.1 200 OK
Date: Fri, 28 Oct 2022 07:59:28 GMT
Server: Apache/2.4.52 (Debian)
X-Powered-By: PHP/8.1.2
Content-Length: 359
Keep-Alive: timeout=5, max=100
Connection: Keep-Alive
Content-Type: application/json; charset=utf-8

[
  {
    "id": 70,
    "name": "1.jpg",
    "directory": "\/var\/www\/html\/Files\/1666803133.97451.jpg",
    "stored_at": "2022-10-26 16:52:13",
    "link": "http:\/\/localhost:80\/Files\/1666803133.97451.jpg"
  },
  {
    "id": 72,
    "name": "1.jpg",
    "directory": "\/var\/www\/html\/Files\/1666885896.96461.jpg",
    "stored_at": "2022-10-27 15:51:36",
    "link": "http:\/\/localhost:80\/Files\/1666885896.96461.jpg"
  }
]

Response code: 200 (OK); Time: 309ms; Content length: 359 bytes
```
```http request
GET http://localhost:80/api/filesv

HTTP/1.1 404 Not Found
Date: Fri, 28 Oct 2022 15:14:11 GMT
Server: Apache/2.4.52 (Debian)
X-Powered-By: PHP/8.1.2
Content-Length: 13
Keep-Alive: timeout=5, max=100
Connection: Keep-Alive
Content-Type: application/json; charset=utf-8

[
  "Not found"
]

Response code: 404 (Not Found); Time: 202ms; Content length: 13 bytes
```
```http request
DELETE http://localhost:80/api/files/87

HTTP/1.1 500 Internal Server Error
Date: Fri, 28 Oct 2022 16:02:40 GMT
Server: Apache/2.4.52 (Debian)
X-Powered-By: PHP/8.1.2
Content-Length: 39
Connection: close
Content-Type: application/json; charset=utf-8

[
  "File not found, record was deleted."
]

Response code: 500 (Internal Server Error); Time: 224ms; Content length: 39 bytes
```
```http request
GET http://localhost:80/api/files

HTTP/1.1 500 Internal Server Error
Date: Fri, 28 Oct 2022 16:13:11 GMT
Server: Apache/2.4.52 (Debian)
X-Powered-By: PHP/8.1.2
Content-Length: 76
Connection: close
Content-Type: application/json; charset=utf-8

[
  "Unable connect to the DB SQLSTATE[HY000] [1049] Unknown database 'mydb1'"
]

Response code: 500 (Internal Server Error); Time: 164ms; Content length: 76 bytes
```



