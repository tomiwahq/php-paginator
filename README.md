# PHP-Paginator

A simple pagination class for PHP

## Installation
### Option 1: Install via composer (recommended)
     composer require tommylykerin/php-paginator
include composer's autoload.php file in your project.

### Option 2: Clone
 Clone or Download the project to your computer
include the Paginator.php file in your project.

## Usage
instantiate the Paginator class passing the total number of results as the first argument and the number of results per page as the second argument to the class constructor:
`$paginator = new Paginator(500, 5);`

echo a call the paginate method:
`echo $paginator->paginate();` 

the URL is automatically generated based on the current URL in the address bar.

If you want to set custom URL, you should call the `set_url()` method passing the desired URL as the parameter:
`$paginator = new Paginator(500, 5);`
`$paginator->set_url("http://custom_url.com/?query=preserved");`
`echo $paginator->paginate();` 

This will append the page data to the set URL.
The existing parameters in the URL are preserved. 
This example will produce:
`http://custom_url.com/?query=preserved&page=1`, etc.
