<p align="center">
<img src="https://i.imgur.com/eza693Z.png" height="50px">
</p>

![Login page](https://i.imgur.com/Y2GwUip.png)

# Elearning - ITF@KMITL Project 2017

ระบบ Elearning ตัวนี้เป็นส่วนหนึ่งของรายวิชา Introduction Technology Fundamental คณะเทคโนโลยีสารสนเทศ สถาบันเทคโนโลยีพระจอมเกล้าเจ้าคุณทหารลาดกระบัง สร้างโดยใช้ [Laravel 5.5](https://laravel.com), [Vue.js V.2](vuejs.org) และ [Bootstrap 3.3](https://getbootstrap.com/docs/3.3)

### Screenshots

<p align="center">
<img src="https://i.imgur.com/Ly4sW5o.png" width="50%">
<img src="https://i.imgur.com/TMCGLQd.png" width="50%">
</p>

### ความต้องการของระบบ

- PHP 7.0 และ MySql 5.0
- [Composer](https://getcomposer.org/)

### ::: การติดตั้ง :::

ทำการ clone project

```bash
git clone https://github.com/Phongsathron/elearning.git
```

ติดตั้ง Composer [Instruction Link](https://getcomposer.org/download/)

```php
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

ติดตั้ง Node.js [Instruction Link](https://nodejs.org/en/)

ทำการลง library ของ laravel

```bash
composer install
npm install
```

แก้ไขไฟล์ .env-example ไปเป็น .env และทำการตั้งค่าเพื่อเชื่อมต่อ database

ทำการ Migrate Database

```bash
php artisan migrate
```

ตั้งค่า Passport

```bash
php artisan passport:install
```

แก้ไข .config.example.js เป็น .config.js และนำ key ของ client_id 2 มาใส่ที่ client_secret

รัน npm

```bash
npm run production
```

จำลอง server โดย artisan

```bash
php artisan serv
```

## Demo

Here is a working live demo : http://52.77.253.20/

## Team

[![Phonsathorn ](https://avatars2.githubusercontent.com/u/26630756?s=460&v=4)](https://github.com/Phongsathron)

## [License]

MIT © [Phongsathron ](https://github.com/Phongsathron)
