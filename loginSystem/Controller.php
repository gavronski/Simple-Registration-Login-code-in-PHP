<?php 


declare(strict_types=1);

namespace App;


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
                    $emails = $this->database->getEmails();
                    


                    if ($this->action()=='register' && !empty($post['fname'])
                              && !empty($post['password'])
                              && !empty($post['email'])){

                          
                              $this->database->storeDataSignUp($this->getRequestPost());
                    

                    }

                    

          }
     
          // get data from login page
          public  function getDataFromLogin():void
          {         
                    $dataLogin = $this->getRequestPost();
                    // email given by user in login form
                    $emailLogin = $dataLogin['email'];
                   
                    //get emails from db
                    $emails = $this->database->getEmails();
                    
                    $validEmail = $this->dataLoginValidation('email',$emails,$emailLogin);

                    // if email from login form is in db check if password is correct 
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

          }
         
          // check wheter email or password exists in db
          private function dataLoginValidation(string $dataType,array $dataLogin,string $varToCheck):bool
          {
                    $valid = False;

                    switch($dataType){
                              case 'email':
                                        // take an element from emails and compare to given email
                                        foreach($dataLogin as $email){

                                                  if($email['email'] == $varToCheck){
                                                            $valid = True;
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