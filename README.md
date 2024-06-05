# KitKat system back-end files

This repository contains the necessary files to run the back-end for the KitKat site.
For the front end files, see this repository:
- https://github.com/r-rozenvalds/fe-kitkat

### This back-end system is built using php and Laravel.

# Instructions 

### Necessary programs: XAMPP (or similar web-hosting alternative), php, Composer, npm, Node.js

1. Download the front-end and back-end files and put them in a folder.
2. Open XAMPP (or similar web-hosting alternative), start Apache & MySQL
3. Run command ```npm install```
4. Open the command prompt in the front-end folder and write ```npm run dev```
5. Wait for the system to start, then open the provided link.
6. Go to the back-end folder
7. Run command ```composer install```
8. Migrate and seed the database using ```php artisan migrate --seed```
9. Open the command prompt in the back-end folder and write ```php artisan serve```
10. Wait for the back-end to start and refresh the front-end site.

If the connection between front-end and back-end cannot be made, check that the correct port (DB_PORT) is written in the back-end .env file and that DB_DATABASE is a database that exists on your web-hosting application.
