### Web-application 

#### Vocation

#### Description

#### How to run
* Clone the repository 
* Create file (in root dir of project) .env and copy data from .env.example in it
* ```docker-compose up -d```
* ```docker exec -it 59_mysql_1 /bin/sh```
* ```mysql -u root -p ``` password is: secret
* ```use mydb;```
* Run SQL queries:
```sql

```
* Open in browser http://localhost/auth

curl -X POST -H "Content-Type: multipart/form-data" -H "Accept: application/json" -F "file_image=@1.jpg" http://localhost:80/api/files


