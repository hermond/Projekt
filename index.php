<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-26
 * Time: 15:07
 * To change this template use File | Settings | File Templates.
 */
require_once('application/controller/DoApplication.php');

session_start();

$application = new \controller\DoApplication();

echo $application->doApplication();