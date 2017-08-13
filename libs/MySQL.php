<?php

class MySQL extends SQL
{
    protected $mySqlConnect;
    protected $DBname;


    /**
     * Construct - create connect and select db MySQL
     * MySQL constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->mySqlConnect = mysql_connect(HOST, USER_NAME, PASS);
        if (!$this->mySqlConnect)
        {
            throw new Exception(ERROR_CONNECT . mysql_error());
        }
        $this->DBname = mysql_select_db(DB_NAME);
        if(!$this->DBname)
        {
            throw new Exception(ERROR_DB . mysql_error());
        }

    }

    /**
     *
     * Given query from SQL class and proces it
     * @return array|int
     * @throws Exception
     */
    public function exec()
    {
        parent::exec();
        $result = mysql_query($this->queryProp, $this->mySqlConnect);
        if (!$result)
        {
            throw new Exception(ERROR_QUERY . mysql_error());
        }
        else
        {
            if (is_bool($result))
            {
                return mysql_affected_rows();
            }
            else
            {
                $i=0;
                $arrResult = array();
                while($row = mysql_fetch_assoc($result))
                {
                    $arrResult[$i]=$row;
                    $i++;
                }
                return $arrResult;
            }
        }
    }


    public function __destruct()
    {
        mysql_close($this->mySqlConnect);
    }

}

?>
