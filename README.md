<p align="center">
<img src="https://img.shields.io/badge/Laravel-Package-red" alt="Framework">
<a href="https://github.com/danialhatami/simple-marketplace/actions/workflows/php.yml"> <img src="https://github.com/danialhatami/simple-marketplace/actions/workflows/php.yml/badge.svg?branch=master" alt="Framework"></a>
<a href="https://packagist.org/packages/danialhatami/simple-marketplace"> <img src="https://img.shields.io/packagist/dt/danialhatami/simple-marketplace" alt="Downloads"></a>
</p>

## Laravel Simple Marketplace Package

🚀 Welcome to the Laravel Simple Marketplace - where setting up an e-commerce solution is as easy as spotting the moon on a clear night! 🌔  
<br><br>

Before we launch, make sure you've got Laravel installed and you've run the migrations (because our package needs users like a spaceship needs astronauts!).

### Installation
Ready for a smooth takeoff? Just follow these steps:

1. Install Package via Composer:
    ```bash
    composer require danialhatami/simple-marketplace:dev-master
    ```
2. Initiate Installation:
    ```bash
    php artisan simple-marketplace:install
    ```
3. Migration Check
    Do a quick moonwalk over to your migrations. Modify them if you must (but let's try not to). Another round of migration will lay the groundwork for your marketplace.
    ```bash
    php artisan migrate
    ```
4. That's it

### Key Business Logic
- Product: Title, price, multiple images
- Product Search: By title, with price filters and low-price sorting
- Seller/User Product Management: Add/remove products, inventory control
- Order Process: Simple ordering, cost calculation, admin email alerts
- Delivery Options: Doorstep delivery

After installation, you can customize the admin email.
Navigate to the `config/marketplace.php` file and modify the admin_email value to suit your needs.

### Essential Files
Need to jump straight to the heart of the action?  
Here are quick links to some of the most crucial files in this project:
- Package Service Provider  [👉 Simple Marketplace Service Provider](https://github.com/danialhatami/simple-marketplace/blob/master/src/Providers/SimpleMarketplaceServiceProvider.php)
- Feature Tests  [👉 Test Files](https://github.com/danialhatami/simple-marketplace/tree/master/src/Tests/Feature)
- Installation Command [👉 Install Command](https://github.com/danialhatami/simple-marketplace/blob/master/src/Console/Commands/InstallCommand.php)
- Main Services [👉 Service Files](https://github.com/danialhatami/simple-marketplace/tree/master/src/Services)
- Route File [👉 Api Route](https://github.com/danialhatami/simple-marketplace/blob/master/src/Routes/api.php)
- Notification [👉 Notification](https://github.com/danialhatami/simple-marketplace/blob/master/src/Notifications/OrderPlacedNotification.php)


<b>Dive Deeper</b>  
For an enchanting journey through every nook and cranny of this project, kindly open your IDE's magical gates.  
[👀 Project in IDE MODE](http://github.dev/danialhatami/simple-marketplace)

### Easy Navigation with Postman Collection
It's your handy guidebook.
[👉 Postman Json Collection](https://github.com/danialhatami/simple-marketplace/blob/master/Simple%20Ecommerce.postman_collection.json)
<br>

<img src="https://i.ibb.co/G07t8Q4/Screenshot-2024-01-21-234957.png" alt="postman collection">

