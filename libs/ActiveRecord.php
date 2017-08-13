<?php
class ActiveRecord extends SQL
{
    protected $connectProp;
    protected $fieldsProp = array();
    protected $dataRow = array();



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
            if (($this->fieldsProp['key'] == $this->dataRow[$k1]['key'])
                && ($this->fieldsProp['data'] == $this->dataRow[$k1]['data']))
            {
                return ERROR_REC;
            }
        }
        //No data in the table - record
        $query = $this->insertInto(TB_NAME, $queryFields)->values($queryValues)->exec();
        $result = mysqli_query($this->connectProp, $query);
        if (!$result){
            throw new Exception(ERROR_QUERY.mysqli_error($this->connectProp));
        }
        return true;
    }



    protected function getColumName()
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
            $arrResult2 = array();
            foreach ($arrResult as $v)
            {
                $this->fieldsProp[$arrResult[$i]['Field']] ='';
                $i++;
            }
        }
    }

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


}