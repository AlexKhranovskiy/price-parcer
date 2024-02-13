### OLX ads price change watcher

#### Description

Application periodically makes request to olx ad and if price has changed answers to
email about it, about current price and about previus price. Application has REST API method which receives the url
of olx ad and email for answering. Application receives url of the ad, makes request to service parses the response,
takes price and currency code, stores taken data in subscription table. If url has already existed then nothing is
duplicated. Email is stored in users table, if email has already existed than nothing is duplicated. Email is attached
with the ad. Tables Subscriptions and users are attached with many-to-many reference. Ad can has a lot of emails for
answering. Emails can has a lot of ads for receiving answers.

Application without a framework. It handles exceptions and answers to a client using JSON.

Application has config for:

* DB
* Routes

#### How to run

* Clone the repository
* Create file (in root dir of project) .env and copy data from .env.example in it
* Set smtp config of email account which will send mail in files:

```
.docker/ssmtp/ssmtp.conf
.docker/ssmtp/revaliases
App/Config/mail.php
```

* ```docker-compose up -d```
* ```docker exec -it price-parcer_mysql_1 /bin/sh```
* ```mysql -u root -p ``` password is: secret
* ```use price-parcer-db;```
* Run SQL queries:

```sql
create table users
(
    id    int          not null auto_increment,
    email varchar(255) not null,
    primary key (id)
) default character set utf8;

```

```sql
create table subscriptions
(
    id           int          not null auto_increment,
    url          varchar(255) not null,
    price        varchar(255) null,
    currencyCode varchar(255) null,
    PRIMARY KEY (id)
) default character set utf8;

```

```sql
create table users_subscriptions
(
    id              int not null auto_increment,
    user_id         int,
    FOREIGN KEY (user_id) references users (id),
    subscription_id int,
    FOREIGN KEY (subscription_id) references subscriptions (id),
    primary key (id)
) default character set utf8;

```

* Got to price-parcer_php-apache container ```docker exec -it price-parcer_php-apache_1 bash```
* Run ```composer install```
* Make POST request to ```http://localhost/api/subscribes``` body like this:

```json
{
  "url": "https://www.olx.ua/d/uk/obyavlenie/prodam-IDUfizH.html",
  "email": "email@gmail.com"
}
```



