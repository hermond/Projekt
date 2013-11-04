<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-26
 * Time: 23:06
 * To change this template use File | Settings | File Templates.
 */

namespace view;


class AdminHTMLPage {

    /**
     * @param String $html
     * @param String $pageTitle
     * @return String
     */
    public function getAdminHTMLPage($html, $pageTitle)
    {

    return
    "<!DOCTYPE html>
        <html>
        <head>
        <title>$pageTitle - Admin</title>
        <meta charset='UTF-8'>
        <link rel='stylesheet' type='text/css' href='public/admin.css'>
        </head>

        <body>
        <div id ='header'>
        <img src = './public/images/administration.png' alt='Administration'>
        </div>
        <div id='menu'>
        <ul>
        <li><a href='?admin' class='navigationlink'>Admin</a>
        <li><a href='?admin&settings' class='navigationlink'>Site Settings</a>
        <li><a href='?admin&databasesettings' class='navigationlink'>Main Store settings</a>
        <li><a href='?admin&logout' class='navigationlink'>Logout</a>
        </ul>
        </div>
        $html
        </body>

        </html>";
    }
}