<?php
class MyTest extends ActiveRecord
{

    public function __construct()
    {
        //connect to bd - table MY_TEST
        $this->connectProp = mysqli_connect(HOST, USER_NAME, PASS, DB_NAME);
        if(!$this->connectProp)
        {
            throw new Exception(ERROR_CONNECT . mysqli_connect_error());
        }
        //GEt columns name from table
        $this->setColumName();
    }

}