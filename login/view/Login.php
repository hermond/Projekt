<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-11-02
 * Time: 16:49
 * To change this template use File | Settings | File Templates.
 */

namespace view;


class Login {

    /**
     * @var String for locations in $_POST
     */
    private static $username = 'username';
    private static $password = 'password';
    private static $submit = 'submit';

    /**
     * @var String for locations in $_GET
     */
    private static $login = 'login';
    private static $logout = 'logout';

    /**
     * @var string
     */
    private $feedbackmessage = "";

    public function getLoginPage()
    {

        return "<!DOCTYPE html>
        <html>
            <head>
                <meta http-equiv='Content-Type'
                content='text/html; charset=UTF-8'>
                <link rel='stylesheet' type='text/css' href='public/admin.css'>
                <title>Login</title>
            </head>
            <body>
                <div id='header'>
                <img src = './public/images/administration.png' alt='Administration'>
                </div>
                <div id='logindiv'>
                <h2>Login</h2>
                <p>".$this->feedbackmessage."</p>
                <form id='loginform' action='?admin&". self::$login . "' method='post' >
                <table>
                <tr>
                <td><label>Username</label>
                <td><input type='text' name=".self::$username." value='".$this->getUsernameValue()."'>
                </tr>
                <tr>
                <td><label>Password</label>
                <td><input type='password' name=".self::$password.">
                </tr>
                <tr>
                <td>
                <td><input type='submit' name=".self::$submit." value='Login'>
                </tr>
                </div>
                </form>
            </body>
        </html>";
    }

    /**
     * @return string from $_POST with username.
     * @throws /Exception if username is missing
     * @throws /Exception if _$POST is empty
     */
    public function getUsernamePost()
    {
        if (isset($_POST[self::$username]))
        {
            if(strlen($_POST[self::$username])>0)
            {
                return $_POST[self::$username];
            }
            else{
                $this->feedbackmessage = "Username is missing";
                throw new \Exception("Username is missing");
            }
        }
        else
        {
            throw new \Exception("Post crashed");
        }
    }
    /**
     * @return string from $_POST with password.
     * @throws /Exception if password is missing
     * @throws /Exception if _$POST is empty
     */
    public function getPasswordPost()
    {
        if (isset($_POST[self::$password]))
        {
            if(strlen($_POST[self::$password])>0)
            {
                return $_POST[self::$password];
            }
            else{
                $this->feedbackmessage = "Password is missing";
                throw new \Exception("Password is missing");
            }
        }
        else
        {
            throw new \Exception("Post crashed");
        }
    }

    /**
     * @return string
     */
    public function getUsernameValue()
    {
        if (isset($_POST[self::$username]))
        {
            return $_POST[self::$username];
        }
        else{
            return "";
        }
    }

    /**
     * @return bool
     */
    public function isLoggingIn()
    {
        return isset($_GET[self::$login]);
    }

    /**
     * @return bool
     */
    public function isLoggingOut()
    {
        return isset($_GET[self::$logout]);
    }

    /**
     * @return bool
     */
    public function isSubmitted()
    {
        return isset($_POST[self::$submit]);
    }

    public function setFeedbackMessage()
    {
        $this->feedbackmessage = "Username doesn't exist. Try again!";
    }
}