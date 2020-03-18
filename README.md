please follow this steps:

- First of all pull the project
- run composer update to download all dependencies packages
- create db schema with any name you like and add it to .env file
- run php artisan migrate
- run php artisan create:admin for generate administrator


- register a customer
POST: api/v1/auth/register
body
    name:
    email:
    password:


- login a customer,seller,admin
POST: api/v1/auth/login
body
    email:
    password:


- refresh token
GET: api/v1/auth/refresh
header
    Authorization: Bearer


- logout user
GET: api/v1/auth/logout
header
    Authorization: Bearer


- get user info
GET: api/v1/auth/user
header
    Authorization: Bearer


- add seller by adminstrator
POST: api/v1/admin/seller
header
    Authorization: Bearer
body
    name:
    email:
    password:


- complete store information by seller
PUT: api/v1/seller/store
header
    Authorization: Bearer
body
    name:
    phone:
    latitude:
    longitude:

- add product by seller
POST: api/v1/seller/product
header
    Authorization: Bearer
body
    name:
    price:
    stock_count:


- products listing by lat&lng
POST: api/v1/customer/products
body
   latitude:
    longitude:
    distance:

- buy product by user
POST: api/v1/customer/buy
header
    Authorization: Bearer
body
    product_id:
