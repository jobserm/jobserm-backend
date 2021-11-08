# JobSerm [backend-Laravel framework]

Web Technology and Web Service 01418442 & Introduction Software Engineering 01418471 : Final project\
JobSerm ระบบจัดหางานออนไลน์สำหรับฟรีแลนซ์   

# Team Members
1. Patipan Boomnsimma 6210400710
2. Kanravee Warinsirikul 6210402348
3. Jinna Chodchoy 6210402364
4. Pirapat Jitcharoenwirakun 6210402470
5. Itsaraphap Sakulwong 6210406769
6. Thanakorn Wongsanit 6210407960
7. Kanita Wansang 6210450431

# Installation

**Windows (bash cmd), Linux , and macOS**   

 1. `cp .env.example .env` on working directory.   
 2. run command `composer install`   
 3. run command `composer dump-autoload`   
 4. rum command `php artisan key:generate`, make sure that APP_KEY in `.env` has value.   
 5. run command `npm install`   
 6. run command `php artisan serve`, make sure that server runs correctly.   
 
 After installation dependencies, you need to setup your local database in `.env`        
 - DB_CONNECTION=[database]   
 - DB_HOST=[hostname]   
 - DB_PORT=[database port]   
 - DB_DATABASE=[your local database name]   
 - DB_USERNAME=[your local database username]   
 - DB_PASSWORD=[your local database password]   
 
# Migration & Seeder

After setup database run the following command   

 1. To migrate table, run `php artisan migrate`    
 2. To seed data into tables, run `php artisan db:seed`   
