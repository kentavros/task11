<?php
include ('libs/config.php');
include ('libs/function.php');




try
{
 $myTest = new MyTest();
 //test
    $myTest->key='user8';
    $myTest->data='test15';
    $myTest->key;




    echo $myTest->save();




}
catch (Exception $e)
{
    $msg= $e->getMessage();
}




include('template/tmp.php');
?>