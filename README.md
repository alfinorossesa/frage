## Installation

1. Clone the repository
    ```bash
    git clone https://github.com/alfinorossesa/frage.git
    ```

2. Configure .env files, => copy .env.example and rename it to .env

3. Set up all configuration in .env files

4. Use the package manager [composer](https://getcomposer.org/download/) to install vendor.

    ```bash
    composer install
    ```

5. Generate APP_KEY

    ```bash
    php artisan key:generate
    ```

7. Run Migration

    ```bash
    php artisan migrate
    ```

8. Run Seeder

    ```bash
    php artisan db:seed
    ```
9. Run Laravel server

     ```bash
     php artisan serve
     ```
   
- Basic Admin Credential

    ```bash
    email: admin@frage.com
    password: password
    ```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.


## Demo
Visit website by click this [link](http://frage.my.id).

