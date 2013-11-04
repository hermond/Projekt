<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-28
 * Time: 23:59
 * To change this template use File | Settings | File Templates.
 */

namespace model;
require_once('common/model/DALBase.php');

class SettingsDAL extends DALBase {

    public function updateSettings(Settings $settings){
    $statement = parent::getDBConnection()->prepare("UPDATE Settings
    SET PageTitle = :pageTitle, Heading1 = :heading1, Introtext = :introText,
     Language = :language, Metadescription = :metaDescription, Metakeywords = :metaKeywords,
     Nofollow = :nofollow, Showprice = :showPrice ");

    $pageTitle = $settings->getPageTitle();
    $heading1 = $settings->getHeading1();
    $introText  = $settings->getIntroText();
    $language  = $settings->getLanguage();
    $metaDescription = $settings->getMetaDescription();
    $metaKeywords = $settings->getMetaKeywords();
    $nofollow = $settings->getNofollow();
    $showPrice = $settings->getShowPrice();

    $statement->bindParam(':pageTitle', $pageTitle, \PDO::PARAM_STR);
    $statement->bindParam(':heading1', $heading1, \PDO::PARAM_STR);
    $statement->bindParam(':introText', $introText, \PDO::PARAM_STR);
    $statement->bindParam(':language', $language, \PDO::PARAM_STR);
    $statement->bindParam(':metaDescription', $metaDescription, \PDO::PARAM_STR);
    $statement->bindParam(':metaKeywords', $metaKeywords, \PDO::PARAM_STR);
    $statement->bindParam(':nofollow', $nofollow, \PDO::PARAM_INT);
    $statement->bindParam(':showPrice', $showPrice, \PDO::PARAM_INT);




    $statement->execute();
    }

    public function getSettings()
    {
        $statement = parent::getDBConnection()->prepare("SELECT PageTitle, Heading1, IntroText, Language,
        Metadescription, Metakeywords, Nofollow, Showprice FROM Settings");


        $statement->execute();


        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            try {

                $settings = new Settings($row['PageTitle'], $row['Heading1'], $row['IntroText'],
                    $row['Language'], $row['Metadescription'], $row['Metakeywords'],
                    +$row['Nofollow'], +$row['Showprice']);


            }

            catch (\Exception $e) {
                echo $e->getMessage();
            }

        }

        return $settings;
    }

    public function addMainStoreDBSettings(MainStoreDBSettings $mainStoreDBSettings)
    {
        $statement = parent::getDBConnection()->prepare("UPDATE MainStoreDBSettings SET MainStoreUrl = :mainStoreUrl, Hostname = :dbHost, Username = :dbUsername,
     Password = :dbPassword, Name = :dbName");
        $mainStoreUrl = $mainStoreDBSettings->getMainStoreUrl();
        $dbHost = $mainStoreDBSettings->getDBHost();
        $dbUsername  = $mainStoreDBSettings->getDBUsername();
        $dbPassword = $mainStoreDBSettings->getDBPassword();
        $dbName = $mainStoreDBSettings->getDBName();
        $statement->bindParam(':mainStoreUrl', $mainStoreUrl, \PDO::PARAM_STR);
        $statement->bindParam(':dbHost', $dbHost, \PDO::PARAM_STR);
        $statement->bindParam(':dbUsername', $dbUsername, \PDO::PARAM_STR);
        $statement->bindParam(':dbPassword', $dbPassword, \PDO::PARAM_STR);
        $statement->bindParam(':dbName', $dbName, \PDO::PARAM_STR);



        $statement->execute();
    }

    public function getMainStoreDBSettings()
    {
        $statement = parent::getDBConnection()->prepare("SELECT MainStoreUrl, Hostname, Username, Password, Name FROM MainStoreDBSettings");

        $statement->execute();


        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            try {

                $DBsettings = new MainStoreDBSettings($row['MainStoreUrl'], $row['Hostname'], $row['Username'], $row['Password'], $row['Name']);

            }

            catch (\Exception $e) {

            }

        }

        return $DBsettings;
    }
}