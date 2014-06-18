<?php
/**
 * User: c3stream
 * Date: 13/06/06
 * Time: 20:06
 */

require_once(dirname(dirname(__FILE__))."/DBPDOConnectionClass/DBPDOConnectionClass.php");
mb_internal_encoding("UTF-8");
$DBH = null;
try{
    $DBH = new Libs\DBConnection\DBPDOConnectionClass("mysql",'*****',"test_db","******", true);
} catch (Exception $e){
    echo $e->getMessage();
    exit;
}

echo "Success Connection";
