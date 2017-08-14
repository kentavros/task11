<?php
class ActiveRecord extends SQL
{
    protected $connectProp;
    protected $fieldsProp = array();
    protected $dataRow = array();


    /**
     * Magic __set
     * @param $nameProp
     * @param $value
     * @return bool
     * @throws Exception
     */
    public function __set($nameProp, $value)
    {
        if (array_key_exists($nameProp, $this->fieldsProp))
        {
            $this->fieldsProp[$nameProp] = $value;
            return true;
        }
        else
        {
            throw new Exception(NO_FIELD);
        }
    }


    /**
     * Magic __get
     * @param $nameProp
     * @return mixed
     * @throws Exception
     */
    public function __get($nameProp)
    {
        if (array_key_exists($nameProp, $this->fieldsProp))
        {
            return $this->fieldsProp[$nameProp];
        }
        else
        {
            throw new Exception(NO_FIELD);
        }
    }

    /**
     * Method -save - insert and update
     * @return bool|string
     * @throws Exception
     */
    public function save(){
        $queryFields = '';
        $queryValues = '';
        $count = count($this->fieldsProp);
        $i=0;
        foreach ($this->fieldsProp as $k=>$v) {
            $i++;
            if ($i == $count) {
                $queryFields .= '`' . $k . '`';
                $queryValues .= '\''.$v.'\'';
            } else {
                $queryFields .= '`' . $k . '`, ';
                $queryValues .= '\''.$v.'\', ';
            }
        }
        $this->getDataFromTable();
        foreach ($this->dataRow as $k1=>$v1)
        {

            if ((($this->fieldsProp['key'] == $this->dataRow[$k1]['key'])
                && ($this->fieldsProp['data'] == $this->dataRow[$k1]['data'])))
            {
                return ERROR_REC;
            }

            if ((($this->fieldsProp['key'] == $this->dataRow[$k1]['key'])
                && ($this->fieldsProp['data'] != $this->dataRow[$k1]['data'])))
            {
                //UPDATE
                $query = $this->update(TB_NAME)->set('data', $this->fieldsProp['data'])->where($this->fieldsProp['key'])->exec();
                $result = mysqli_query($this->connectProp, $query);
                if (!$result){
                    throw new Exception(ERROR_QUERY.mysqli_error($this->connectProp));
                }
                return DATA_UPDATED;
            }
        }

        //No data in the table - record
        $query = $this->insertInto(TB_NAME, $queryFields)->values($queryValues)->exec();
        $result = mysqli_query($this->connectProp, $query);
        if (!$result){
            throw new Exception(ERROR_QUERY.mysqli_error($this->connectProp));
        }
        return DATA_SAVED;
    }


    /**
     * Delete row by key
     * @param $value
     * @return bool
     * @throws Exception
     */
    public function deleteRow($value){
        $query = $this->delete()->from(TB_NAME)->where($value)->exec();
        $result = mysqli_query($this->connectProp, $query);
        if (!$result)
        {
            throw new Exception(ERROR_QUERY . mysqli_error($this->mySqlConnect));
        }
        else
        {
            $this->getDataFromTable();
            return true;
        }
    }

    /**
     * set columns name from table
     * @throws Exception
     */
    protected function setColumName()
    {
        $query = "SHOW COLUMNS FROM ".TB_NAME;
        $result = mysqli_query($this->connectProp, $query);
        if (!$result)
        {
            throw new Exception(ERROR_QUERY . mysqli_error($this->connectProp));
        }
        else
        {
            $arrResult = array();
            while ($row = mysqli_fetch_assoc($result))
            {
                $arrResult[] =$row;
            }
            $i=0;
            foreach ($arrResult as $v)
            {
                $this->fieldsProp[$arrResult[$i]['Field']] ='';
                $i++;
            }
        }
    }

    /**
     * String with fields for template only
     * @return string
     */
    public function getColumName()
    {
        $queryFields = '';
        $count = count($this->fieldsProp);
        $i=0;
        foreach ($this->fieldsProp as $k=>$v){
            $i++;
            if ($i == $count)
            {
                $queryFields .= '`'.$k.'`';
            }
            else
            {
                $queryFields .= '`'.$k.'`, ';
            }
            $this->dataRow = array();
        }
        return $queryFields; //string for trmplate only
    }

    /**
     * Get data from table
     * @return array
     */
    public function getDataFromTable()
    {
        $queryFields = '';
        $count = count($this->fieldsProp);
        $i=0;
        foreach ($this->fieldsProp as $k=>$v){
            $i++;
            if ($i == $count)
            {
                $queryFields .= '`'.$k.'`';
            }
            else
            {
                $queryFields .= '`'.$k.'`, ';
            }
            $this->dataRow = array();
        }
        $query = "SELECT ".$queryFields." FROM ".TB_NAME;
        $result = mysqli_query($this->connectProp, $query);
        while ($row=mysqli_fetch_assoc($result))
        {
            $this->dataRow[] = $row;
        }
        return $this->dataRow;
    }

    /**
     * find data in table from key
     * @param bool $key
     * @return mixed|string
     */
    public function find($key = false)
    {
        $this->getDataFromTable();
        $count = count($this->dataRow);
        for ($i=0; $i<$count; $i++)
        {
            if ($this->dataRow[$i]['key'] == $key)
            {
                return $this->dataRow[$i];
            }
        }
        return NO_KEY;
    }
}
?>