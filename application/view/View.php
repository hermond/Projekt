<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-28
 * Time: 17:04
 * To change this template use File | Settings | File Templates.
 */

namespace view;


class View {

    private static $admin = "admin";

    public function __construct(){

    }


    public function showAdminPage()
    {
        return isset($_GET[self::$admin]);
    }

}