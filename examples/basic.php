<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Pagination Class Example - Basic</title>
        <style>

        </style>
    </head>
    <body>
        <?php
            // the Paginator class is included
            require_once '../Paginator.php';

            /*
             * This is the most basic example.
             * Only the total number of results and 
             *  the desired number of items to be displayed 
             *  per page is passed to the constructor
             */
            $paginator = new Paginator(500, 5);
            echo $paginator->paginate();
            
        ?>
    </body>
</html>