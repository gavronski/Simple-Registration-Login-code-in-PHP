<?php 

declare(strict_types=1);

namespace App;

use PDO;
use Throwable;
use Exception;

class Database 
{
          private PDO $conn;

          public function __construct(array $config)
          {
                    
                    $this->validateConfig($config);
                    $this->createConnection($config);
                    
          }
          
          public function storeDataSignUp(array $requestPost):void
          {         
                    
                    // store data from user if all informations were given
                     if(!empty($requestPost['fname']) 
                              && !empty($requestPost['password'])
                              && !empty($requestPost['email'])){

                              try{
                                $login = $this->conn->quote($requestPost['fname']);
                                $password = $this->conn->quote($requestPost['password']);

                                $email = $this->conn->quote($requestPost['email']);
                                $time= $this->conn->quote(date('Y-m-d H:i:s'));
                              
                                $query = "INSERT INTO users1(login,password,email,time) 
                                        VALUES($login,$password,$email,$time)";
                                        
                                $this->conn->exec($query);

                              }catch(Throwable){
                                echo 'Insert operation failed';
                              }
                              


                    }
          }
          // get array of emails from table users1
          public function getEmails():array
          {
                    $query = "SELECT email FROM users1";
                    $result = $this->conn->query($query);
                    return $result->fetchAll(PDO::FETCH_ASSOC);
          }

          //  get array of passwords from table users1
          public function getPasswords():array
          {
                    $query = "SELECT password FROM users1";
                    $result = $this->conn->query($query);
                    return $result->fetchAll(PDO::FETCH_ASSOC);
          }

          // get array of login from  table users1
          public function getLogin(string $email, string $password):array
          {         
                    $email = $this->conn->quote($email);
                    $password = $this->conn->quote($password);

                    $query = "SELECT login FROM users1 
                    WHERE password=$password and email=$email";

                    $result = $this->conn->query($query);

                    return $result->fetchAll(PDO::FETCH_ASSOC);
          }
         
         public function emailExists(string $email):bool
         {
          
          $newEmail = $email;
          $email = $this->conn->quote($email);
        // check if email is in table
          $query = "SELECT email FROM users1 WHERE email=$email";
          $result = $this->conn->query($query);
          // if there is no such email return null
          $arr = $result->fetch(PDO::FETCH_ASSOC);
          // if  email exists
          if($arr!=null){
            // return true
            $exist = $arr['email'] == $newEmail  ? true : false ;

          }else {
            $exist = false;
          }
          
          return $exist;
        }
         
         
     
        //  the same rule with emails above
         public function loginExists(string $login):bool
         {
          $newLogin = $login;
          $login = $this->conn->quote($login);
          $query = "SELECT login FROM users1 WHERE login=$login";
          $result = $this->conn->query($query);
          $arr = $result->fetch(PDO::FETCH_ASSOC);
          if($arr!=null){

            $exist = $arr['login'] == $newLogin  ? true : false ;

          }else {
            $exist = false;
          }

          return $exist;
        
         }

          

          // check connection with db
          private function createConnection(array $config): void
          {
            try{
            $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
            $this->conn = new PDO(
              $dsn,
              $config['user'],
              $config['password'],
              [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                
              ]
              );
            }catch(Throwable $e){
              echo 'Database connection failed';
            }
          }
          // check db configuration
          private function validateConfig(array $config):void 
          {
                    
                    if(empty($config['database'])
                    || empty($config['host'])
                    || empty($config['user'])
                    || empty($config['password'])){
                              throw(new Exception('Database connection failed'));
                    }
          }



          
}