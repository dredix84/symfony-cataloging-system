# symfony-cataloging-system
A code challenge created in Symfony 3. This is based on the instructions from the Git Repository in [this link](https://github.com/TalentNet/coding-challenges/blob/master/roles/senior-php.md).


## Basic setup:

 * Pull the project to a htdocs
 * Create a virtual host to the project directory. See an example below (Note: in the example below, the windows host file will have to be modified to point inventoryapi.symfony to an ip address).
 ```
<VirtualHost *:80>
    ServerName inventoryapi.symfony
    DocumentRoot "[path/to/htdocs]/web/app_dev.php"
</VirtualHost>
```
 * Modify the database details found under ```app\config\parameters.yml``` to match you dataabse server detail
 * Run the following commamd to generate the tables ```php bin/console doctrine:generate:entity```
 * Go to the url ```http://inventoryapi.symfony``` and if all was done correctly, you should see the default Symfony 3 home page

### Logins
1. bfischer:Just4Now
2. brubble:Just4Now


## Using the API

 1. /product/getall
 2. /product/getsingle/{id}
 3. /category/getall
 4. /category/getsingle/{id}
 5. /product/delete/{id}
 6. /product/update
 7. /product/create

###  1. /product/getall
Description: Used to retrieve a list of all active products

Requires authenication: No


###  2. /product/getsingle/{id}
Description: Used to retrieve the details for a product

Requires authenication: No
#### Parameters
* id (int): The id for specific product


###  3. /category/getall
Description: Used to retrieve the details for all categories

Requires authenication: No


###  4. /category/getsingle/{id}
Description: Used to retrieve the details for a category

Requires authenication: No
#### Parameters
* id (int): The id for specific category


###  5. /product/delete/{id}
Description: Used to delete a specific product

Requires authenication: Yes
#### Parameters
* id (int): The id for specific product


###  6. /product/update
Description: Used to update a existing product

Requires authenication: Yes
#### Parameters
* id: The id for specific product to be updated
* sku (string): SKU
* name (string): Name
* description (string): description
* price (float): Price
* quantity (int): quantity
* isActive (boolean|int): Is the product active
* productVersion (int): Version number for product
* categoryId (int): The category ID

###  7. /product/create
Description: Used to create a product

Requires authenication: Yes
#### Parameters
* sku (string) (required): SKU
* name (string) (required): Name
* description (string): description
* price (float) (required): Price
* quantity (int) (required): quantity
* isActive (boolean|int) (Default: 1): Is the product active
* productVersion (int) (Default: 1): Version number for product
* categoryId (int): The category ID



## To Do / Incomplete:

 * Unit Test has not been implemented
 * Authication uses plaintext because trying to apply encryption like bcrypt or sha512 has not work. Should investiage and change to a more secure way of storing passwords.
 * ```Products.isValid()``` has not been implemented and returns ```TRUE``` irregardless of the data.
 * Methods related to categories should be moved into its own controller.
 * Helper functions like ```formatDataResponse``` and ```isMethod``` should be moved into an area where all controllers can access it.
 * And unique constraint should be applied to ```sku``` and ```productVersion``` conbined to ensure there are not 2 products with the same ```sku``` and ```productVersion```.


## Assumptions:
 * Products can have multiple versions but with the sku so a unique index was not applied onto the products.sku fields


## Author:
Andre Dixon
