<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><?=PROJECT_NAME;?></title>
</head>
<body>
     <h1><?= $data['message']; ?>: Core framework </h1><br>

     </div>
     <h3>Description:</h3>
     <p>Mini framework built by Erick Avila in PHP 7.3 and using the PDO driver for MySQL</p><br>

     <h3>Requirements:</h3>
     <ol>
          <li>Language PHP 7.3 to PHP 7.4.30</li>
          <li>MySQL or MariaDB DBMS </li>
          <li>Apache or Nginx http server</li>
     </ol> <br>

     <footer>
          <h6>version 1.2</h6>
     </footer>

     <script src="<?= $data['middleware']; ?>"></script>
</body>
</html>
