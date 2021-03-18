<?php 

declare(strict_types=1);

namespace App;


class Page 
{         
          public static string $message ='';
          public static string $pageName;

          public static function getPageName():string
          {
                    return self::$pageName ?? 'message';
          }

          public static function setPageName(string $pageName):void
          {
                    self::$pageName = $pageName;
                    
          }

          public static  function getMessage():string{
                    
                    return self::$message;
          }
          
          public static function setMessage(string $message):void{
                    
                    self::$message = $message;
          }



}