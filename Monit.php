<?php if (!empty($login) && $login != 'noEmail') :?>

          <h1><?php echo"Hello $login !" ?></h1><br>
          <a href="login.php">Log out</a>

<?php elseif($login == 'noEmail'):?>

          <h1>Uncorrect email!</h1>
          <a href="login.php"><h2>Try again!</h2></a>
          

<?php else:?>

          <h1>Uncorrect password!</h1>
          <a href="login.php"><h2>Try again!</h2></a>

<?php endif ?>