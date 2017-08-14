<?php
include ('libs/config.php');
include ('libs/function.php');

try
{
    $myTest = new MyTest();
    $colName = $myTest->getColumName();
    $showData = $myTest->getDataFromTable();
    //Create
    $setKey = $myTest->key='user6';
    $setData = $myTest->data='test6';
    $myTest->save();
    $getKey = $myTest->key;
    $getData = $myTest->data;
    //Read
    $find = $myTest->find('user6');
    //Update
    $setKey2 = $myTest->key='user6';
    $setData2 = $myTest->data='test13';
    $myTest->save();
    $find2 = $myTest->find('user6');
    //Delete
    $myTest->deleteRow('user6');
    $find3 = $myTest->find('user6');
}
catch (Exception $e)
{
    $msg= $e->getMessage();
}

include('template/tmp.php');
?>