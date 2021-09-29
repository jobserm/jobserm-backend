# JobSerm [backend-Laravel framework]

Web Technology and Web Service 01418442: Final project   
JobSerm ระบบจัดหางานออนไลน์สำหรับฟรีแลนซ์   


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
