## Level Up - Blog
Welcome to the level up blog project.

If you are first time here visit
<a href="https://www.notion.so/How-to-setup-Docker-e095fa4f176d4435919ef1c82f80e03e">This link</a> to learn how to setup this project.

Alternatively, you can use `make init` to perform repo initialization with default settings (only needs to be done once)

If you are already know how to setup this project here is useful commands:

---

### Server urls (when docker is running)
Frontend url: http://localhost:8080

Backend url: http://localhost:8000

---
<strong>Starting server:</strong>
```
docker-compose up
```
If you want to start docker in background:
```
docker-compose up -d
```

-----
<strong>Stopping docker project:</strong>
```
docker-compose down
```
---
<strong>Running migrations</strong>
```
make migrate
```
Which translates to
```
docker-compose exec backend php artisan migrate
```
To learn more about executing commands and MakeFile visit: <a href="https://supreme-gold-b6b.notion.site/Executing-commands-4e10d50133314751a27ceb80ef1d0de5">This link</a>

----
<strong>Install frontend packages</strong>
```
docker-compose exec frontend npm i <package>
```


----
<i>THIS README FILE WILL BE UPDATED HOW DURING THE SCHOOL</i>
