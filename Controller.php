<?php 


declare(strict_types=1);

namespace App;

use Throwable;
require_once("View.php");
require_once("Database.php");
require_once("pages.php");




class Controller{

          
          
          public array $requestLogin = [];
          public View $view ;
          public array $request;
          private Database $database;
          private static array $configuration = [];
          

          public static function initConfiguration(array $configuration): void
          {
                    self::$configuration = $configuration;
          }
          
          public function __construct(array $request)
          {
                    
                    $this->view = new View();
                    
                    $this->request = $request;
                    $this->database = new Database(self::$configuration['db']);
                  
          }
          

          public function run():void
          {         
                    $this->view->render();
          
                    $post = $this->getRequestPost();
                   
                    


                    if ($this->action()=='register' && !empty($post['fname'])
                              && !empty($post['password'])
                              && !empty($post['email'])){

                                        
                                        // if an email and login are not granted to any user store them in db
                                        // else conditions - shows informations 
                                        var_dump($this->database->emailExists($post['email']));
                                        var_dump($this->database->loginExists($post['fname']));

                                        if(!$this->database->emailExists($post['email']) 
                                        && !$this->database->loginExists($post['fname'])){

                                                  $this->database->storeDataSignUp($this->getRequestPost());

                                        }elseif($this->database->emailExists($post['email'])){

                                                  echo 'Email is used!';

                                        }elseif($this->database->loginExists($post['fname'])){

                                                  echo 'Login exists!';
                                        }

                              
                              
                    

                    }else{
                              Page::setPageName('Monit');
                              Page::setMessage('emptyField');

                    }

                    

          }
     
          // get data from login page
          public  function getDataFromLogin():void
          {         
                    $dataLogin = $this->getRequestPost();
                    // email given by user in login form
                    $emailLogin = $dataLogin['email'];
                   
                    
                    try{
                              //get emails from table users1
                              $emails = $this->database->getEmails();
                              // return true if an email is in table
                              $validEmail = $this->dataLoginValidation('email', $emails, $emailLogin);

                              if($validEmail){

                                        $passwords = $this->database->getPasswords();
                                        $passwordLogin = $dataLogin['password'];
                    
          
                                        $validPassword = $this->dataLoginValidation('password',$passwords,$passwordLogin);
          
          
                                        if($validPassword){
                                                  $login = $this->database->getLogin($emailLogin,$passwordLogin)[0]['login'] ;
                                                  Page::setPageName('Monit');
                                                  Page::setMessage($login);
                                                  
                                        }else{
                                                  // try again input email and password
                                                  Page::setPageName('Monit');
                                                  Page::setMessage('');
          
                                        }
                              }else{
                                        Page::setPageName('Monit');
                                        Page::setMessage('noEmail');
          
                              }
                    }catch(Throwable $e){
                              echo 'Database connection failed';
                    }
                    
                    
                    

                    // if email from login form is in db check if password is correct 
                    

          }
         
          // check wheter email or password exists in db
          private function dataLoginValidation(string $dataType,array $dataLogin,string $varToCheck):bool
          {
                    $valid = false;

                    switch($dataType){
                              case 'email':
                                        // take an element from emails and compare to given email
                                        foreach($dataLogin as $email){

                                                  if($email['email'] == $varToCheck){
                                                            $valid = true;
                                                                                    }
                                                                     }
                                        break;
                              case 'password':
                                        
                                        foreach($dataLogin as $password){
                                                  if($password['password'] == $varToCheck){
                                                            $valid = True;
                                                                                          }
                                                                        }
                                        break;


                              }
            
                    
                    return $valid;
          }




          private function action():string
          {
                    return $this->getRequestGet()['action'] ?? '';
          }


          private function getRequestGet():array
          {
                    return $this->request['get'] ?? [];
          }

          private function getRequestPost():array
          {
                    return $this->request['post'] ?? [];
          }
          
          
}