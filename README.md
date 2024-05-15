# Full Stack Jegyzet Rögzítő

![1](/mdImages/1.png)
![2](/mdImages/2.png)
![3](/mdImages/3.png)
![4](/mdImages/4.png)
![5](/mdImages/5.png)

### Szükséges Prgoramok

a ) MAMP, XAMP , LAMP vagy bármilyen php-apache developer pack

b) Php  8.1, Mysql , Apache

A vagy B opció elég a a futtatáshoz

### Local Setupolás

0. ```XAMP / MAMP / LAMP``` esetén a program .htacces mappájába navigálás

1. Fileok letöltése

```
git clone git@github.com:MilanEgri/Delocal-test.git
```

2. ```backend/_config.php``` átnevezése ```backend/confg.php``` ra
 és fileon belül db adatok kitöltése

3. ```MAMP/XAMP/LAMP/ [PHP + APACHE + MYSQL]``` Elindítása

4. ```http://localhost/delocal-test/backend/init_db.php``` megynitása böngészőben ezzel adatbázis legenerálása

5. Oldal elérhető: ```http://localhost/delocal-test/frontend/```
