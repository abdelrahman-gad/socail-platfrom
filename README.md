
## Installation 
Make sure you have environment setup properly. You will need MySQL, PHP8.1, Node.js and composer.

### Install Laravel Website + API
1. Download the project (or clone using GIT)
2. Copy `.env.example` into `.env` and configure database credentials 
3. Update `.env` variables 

        DB_DATABASE=dbname
        DB_USERNAME=dbusername
        DB_PASSWORD=dbpassword


        VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
        VITE_PUSHER_HOST="${PUSHER_HOST}"
        VITE_PUSHER_PORT="${PUSHER_PORT}"
        VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
        VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"


        TWILIO_SID=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
        TWILIO_TOKEN=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
        TWILIO_FROM=xxxxxxxxxxx

        JWT_SECRET=test-jwt-token

        `

        `
4. Navigate to the project's root directory using terminal
5. Run `composer install`
6. Set the encryption key by executing `php artisan key:generate --ansi`
7. Run migrations and seeds `php artisan install:project`
8. Start local server by executing `php artisan serve`
9. Open new terminal and navigate to the project root directory
10. Run `npm install`
11. Run `npm run dev` to start vite server for Laravel frontend
12. Open postman
13. Import Postman Collection And Environment  https://documenter.getpostman.com/view/4823675/2sA3QmCZps
14. Navigate to Site\Auth\Login
    ```
     +201022893367
     password
    ```
15. run `php artisan test` to check test cases


### Install Vue.js Admin Panel
1. Navigate to `backend` folder
2. Run `npm install`
3. Copy `backend/.env.example` into `backend/.env`
4. Make sure `VITE_API_BASE_URL` key in `backend/.env` is set to your Laravel API host (Default: http://localhost:8000)
5. Run `npm run dev`
6. Open Vue.js Admin Panel in browser and login with
    ```
    admin@example.com
    admin123
    ```
