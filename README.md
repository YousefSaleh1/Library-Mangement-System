# Library Management System
An integrated library system with a service for sending emails to users upon every process of adding, borrowing, or returning a book.


## Installation

You Must run the migrations and seeders:
```bash
php artisan migrate --seed
```
The queue must also be running
```bash
php artisan queue:work
```

## Usage

You must create an account or log in with the owner account to be able to send all requests


Owner Information :
```json
{
    'name': 'Owner',
    'email': 'yousefsaleh.888.it@gmail.com',
    'password': 'owner1234'
}
```

You Can View The API Documentation via ([The Link](https://documenter.getpostman.com/view/30507236/2sA3JM7Meo)).
