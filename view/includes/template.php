<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="public/css/styleOk.css">
    <title><?=$title?></title>
</head>

<body>
    <?php include('view/includes/navbar.php');?>
    <?=$content?>
    <script src="public/js/BootstrapJquery/jquery-3.4.1.min.js">
    </script>
    <script src="public/js/BootstrapJquery/bootstrap.min.js">
    </script>
</body>

</html>