<?php use Core\{Config, Session}; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->getSiteTitle(); ?></title>
    
    <!-- Bootstrap 4.6  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!-- This will invalidate any cached version for an updated css file core and will increment the version -->
    <link rel="stylesheet" href="<?=ROOT?>app/css/style.css?v=<?=Config::get('version');?>">
    <!-- Javascrip script cdn -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

<?php $this->content('head'); ?>
</head>
<body>
    <?php $this->partial('partials/mainMenu'); ?>
    <div class="container-flud p-4">
        <?= Session::displaySessionAlerts();?>
        <?php $this->content('content'); ?>
    </div>
    
</body>
</html>