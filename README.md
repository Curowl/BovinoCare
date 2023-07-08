## What is it ?

This is just a small laravel project called budgeting app, the app is use to track budgets such as your monthly budget : food budget, hangout with friends budget, entertainment budget, etc.


## Requirements run the project

- PHP 8
- laravel 9
- Node.js


## How to run the project

- make sure the requirements are fulfilled
- clone this project
- copy .env.example and rename it .env
- run this command :
- composer install
- npm install

just wait until finish installation
and run this :
- php artisan migrate
- php artisan migrate --path=database/migrations/budget/database
- php artisan migrate --path=database/migrations/budget
- php artisan db:seed
- php artisan serve

open second terminal :
- npm run dev

check your database (budgetingapp on table users) :
run sql to get first user : 
select * from users where id = 1

grab the email from that user

open your browser and hit http://127.0.0.1:8000/login
paste the email and the password is just "password" without quotation mark


done !
you are ready to explore the app.


## Wait a minute, why this project looks like a basic implementation of laravel ?

I create this project to demonstrate most common issue for laravel developer (especially for beginer):
- how to setup laravel project with multiple database connection
- how to setup migration file depends each database
- how to create factories and run the seeder
- how to make eager loading to optimize query
- how to create pagination 
- Is it possible to run raw sql query in laravel (without eloquent) ? Yes. you can do it
- Display the basic report of dataset


this is not for beginer :
- how to manipulate the DOM with native javascript. No Jquery 
- modify the bootstrap validation
- how to integrate additional js library for frontend like : 
    - bootstrap 5 tags : https://www.npmjs.com/package/bootstrap5-tags
    - Chart.js : https://www.npmjs.com/package/chart.js

but, wait. why do we need chart.js for this project ?

let's imagine this situation:
One day, your manager told you to do something with dataset, such as comparison / just diplay dataset from specific time range. 
To do so, you gonna need chart.js.
for example in this project :
let's compare the dataset of total entertainment budget vs total food budget from Jan 01, 2023 - Jul 30, 2023