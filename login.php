<?php 

declare(strict_types=1);

namespace App;

require_once("Controller.php");
require_once("Database.php");


$configuration = require_once("config.php");

$requestLogin = [
          'get' => $_GET,
          'post' => $_POST
          

];

if(!empty($requestLogin) && !empty($requestLogin['post']['email']) && !empty($requestLogin['post']['email']) ){

          Controller::initConfiguration($configuration);
          $controllerLogin = new Controller($requestLogin);
          $controllerLogin->getDataFromLogin();
}



?>
<!DOCTYPE html>
<html lang="en" >
<head>
          <meta charset="utf-8">
          <title>Contact form</title>
          <link rel="stylesheet" href="style.css">
          <meta name="viewport" content="width=device-width",initial-scale=1>
          <link rel="stylesheet" href="style.css">

</head>
<body>
          <div class="container">
                    <div class="right">
                    <form   method="post">
                                        <section class="copy">
                                                  <h2>Log in</h2>
                                                  <div class="login-container">
                                                  <p>Not registered yet? <a href='/'><strong>Sign up!</strong></a></p>
                                                  </div>
                                        </section>


                                        <div class="input-container email">
                                                  <label for="email">Email</label>
                                                  <input type="email" id="email" name="email"  required="required">
                                        
                                        </div>
                    

                                        <div class="input-container password">
                                                  <label for="pass">Password</label>
                                                  <input type="password" id="pass" name="password"  required="required">
                                                  <i class="far fa-eye-slash"></i>
                                        
                                        </div>
                                        
                                        <br>
                                        <input type="submit" value="sign up"/>
                                                  

                              </form>
                             
                    </div>


                    <div class="left">
                              
                              <section class="copy">
                             <?php 

                             require_once("pages.php");
                             $page = Page::getPageName();
                             $login = Page::getMessage();
                             require_once("$page.php"); 
                             
                             ?>
                             </section>
                              </div>
                    
          </div>

</body>
</html>