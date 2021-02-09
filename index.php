<?php define('APP_ROOT', __DIR__); ?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <?php require 'utils/styles.php'; ?>
        <?php require 'utils/scripts.php'; ?>
    </head>
    <body>
      <?php require 'utils/toolbar.php'; ?>
        <div class="container">
            <!-- <div class="row">
                <div class="col-md-12">
                    <?php //require 'utils/header.php'; ?>
                </div>
            </div> -->
            <!-- <div class="row">
                <div class="col-md-12">
                    <?php //require 'utils/toolbar.php'; ?>
                </div>
            </div> -->
            <div class="row">
                <div class="col-md-12">
                  <br>
                    <h2>Welcome to the Cloud Festivals Website</h2>
                    <br>
                    <?php if(isset($_GET['error'])) {
                        ?> <div class="alert alert-danger" role="alert">
                        <?= $_GET['error'] ?>, <a href="<?= $auth->getSignInURL(); ?>" class="alert-link">Click here to login</a> 

                      </div>
                      <?php
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php require 'utils/footer.php'; ?>
                </div>
            </div>
        </div>
    </body>
</html>
