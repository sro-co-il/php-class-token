<?php
/*****
php class token
http://code.google.com/p/php-class-token/
owner: Sro [sro.co.il]
*****/

class token
        {
        public $timeout = 1800; // 1800 sec is 30 min for time out
        public $tokenfieldname = "token";
        public $error = "";
        
        private $errormsg1 = "token not received";
        private $errormsg2 = "token failed";
        private $errormsg3 = "token time out, make the action again";

        function __construct()
                {
                if(!isset($_SESSION))
                        session_start();        
                }
        
        function createtoken()
                {
                // create new token, prefix (to distinguish with another session date) with random value (to prevent guess)
                $token = "token-" . mt_rand();
                // put in the token, created time
                $_SESSION[$token] = time();
                return $token;
                }
        
        function createtokenfield()
                {
                return "<input type='hidden' name='" . $this->tokenfieldname . "' value='" . $this->createtoken() . "' />";
                }
        
        function createGETtoken()
                {
                return $this->tokenfieldname . "=" . $this->createtoken();
                }
        
        function checktoken()
                {
                $tokenfield = $this->tokenfieldname
                if (!isset($_REQUEST[$tokenfield]))
                        {
                        $this->error = $this->errormsg1;
                        return false;
                        }
                $token = $_REQUEST[$tokenfield];
                if (!isset($_SESSION[$token]))
                        {
                        $this->error = $this->errormsg2;
                        return false;
                        }
                
                // check if token not time outing
                if (time() - $_SESSION[$token] < $this->timeout)
                        {
                        // after the validation, we clear the specifically session to prevent repeating on the same token
                        unset($_SESSION[$token]);
                        return true;
                        }
                else
                        {
                        $this->error =$this->errormsg3;
                        return false;
                        }
                }
        
        }

        if(!isset($token))
                $token = new token;
?>
