<?php 

declare(strict_types=1);

namespace App;

require_once("AppException.php");


use PDO;


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
                              
                              $login = $this->conn->quote($requestPost['fname']);
                              $password = $this->conn->quote($requestPost['password']);

                              $email = $this->conn->quote($requestPost['email']);
                              $time= $this->conn->quote(date('Y-m-d H:i:s'));
                              
                              $query = "INSERT INTO userlogin (login,password,email,time) 
                                        VALUES($login,$password,$email,$time)";
                                        
                              $this->conn->exec($query);


                    }
          }
          // get array of emails from db
          public function getEmails():array
          {
                    $query = "SELECT email FROM userlogin";
                    $result = $this->conn->query($query);
                    return $result->fetchAll(PDO::FETCH_ASSOC);
          }
          //  get array of passwords from db
          public function getPasswords():array
          {
                    $query = "SELECT password FROM userlogin";
                    $result = $this->conn->query($query);
                    return $result->fetchAll(PDO::FETCH_ASSOC);
          }
          // get array of login from  db
          public function getLogin(string $email,string $password):array
          {         
                    $email = $this->conn->quote($email);
                    $password = $this->conn->quote($password);

                    $query = "SELECT login FROM userlogin WHERE password=$password and email=$email";
                    $result = $this->conn->query($query);
                    return $result->fetchAll(PDO::FETCH_ASSOC);
          }
         
         

          

          // check connection with db
          private function createConnection(array $config): void
          {
            $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
            $this->conn = new PDO(
              $dsn,
              $config['user'],
              $config['password'],
              [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              ]
            );
          }
          // check db configuration
          private function validateConfig(array $config):void 
          {
                    if(empty($config['database'])
                    || empty($config['host'])
                    || empty($config['user'])
                    || empty($config['password'])){
                              echo "error";
                    }
          }



          
}