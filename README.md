### Storage file application
without the framework
#### Vocation
Praction with REST API and file storing on server side using PHP. Praction with MVC, SOLID.
#### Description
Application uses Repository design pattern. Application has REST API, receives file with using HTTP method POST,
is able to output all stored files' information in JSON format, is able to delete info about file and file themself by inputed
id.
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




