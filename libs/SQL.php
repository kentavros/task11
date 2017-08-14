<?php
class SQL
{

	protected $selectProp;
    protected $fromProp;
    protected $whereProp;
    protected $insertProp;
    protected $valuesProp;
    protected $deleteProp;
    protected $updateProp;
    protected $setProp;
    protected $queryProp;
    protected $flag;


    /**
     * Method select
     * @param $columName
     * @return $this
     */
	public function select($columName)
    {
       if ($columName !== '*')
       {
           $this->selectProp = "SELECT ".$columName;
           return $this;
       }

    }

    /**
     * From
     * @param $tableName
     * @return $this
     */
    public function from($tableName)
	{
		$this->fromProp = " FROM ".$tableName;
		return $this;
	}

    /**
     * WHERE
     * @param $val
     * @param $tableName
     * @return $this
     */
    public function where($val)
    {
            $this->whereProp = " WHERE `key`="."'".$val."'";
            return $this;
    }

    /**
     * INSERT INTO
     * @param $tableName
     * @return $this
     */
    public function insertInto($tableName, $fields)
    {
            $this->insertProp = "INSERT INTO ".$tableName." (".$fields.")";
            return $this;
    }

    /**
     * VALUES
     * @param $key
     * @param $data
     * @return $this
     */
    public function values($values)
    {
        $this->valuesProp = " VALUES (".$values.")";
        return $this;
    }

    /**
     * DELETE
     * @return $this
     */
    public function delete()
    {
        $this->deleteProp = "DELETE";
        return $this;
    }

    /**
     * UPDATE
     * @param $tableName
     * @return $this
     */
    public function update($tableName)
    {
        $this->updateProp = "UPDATE ".$tableName;
        return $this;
    }

    /**
     * SET
     * @param $field
     * @param $value
     * @param $tableName
     * @return $this
     */
    public function set($field, $value)
    {
            $this->setProp = " SET `".$field."`='".$value."'";
            return $this;
    }

    /**
     * exec - create query
     * @return string
     */
    public function exec()
    {
        if (!empty($this->selectProp)) {
            if ((!empty($this->fromProp)) && (!empty($this->whereProp))) {
                $this->queryProp = $this->selectProp . $this->fromProp . $this->whereProp;
                $this->selectProp = null;
                $this->fromProp = null;
                $this->whereProp = null;
                return $this->queryProp;
            } elseif (!empty($this->fromProp)) {
                $this->queryProp = $this->selectProp . $this->fromProp;
                $this->selectProp = null;
                $this->fromProp = null;
                return $this->queryProp;
            } else {
                return NO_PROPERTIES;
            }
        }
        elseif ((!empty($this->insertProp)) && (!empty($this->valuesProp)))
        {
            $this->queryProp = $this->insertProp . $this->valuesProp;
            $this->insertProp = null;
            $this->valuesProp = null;
            return $this->queryProp;
        }
        elseif ((!empty($this->deleteProp)) && (!empty($this->fromProp)) && (!empty($this->whereProp)))
        {
            $this->queryProp = $this->deleteProp . $this->fromProp . $this->whereProp;
            $this->deleteProp = null;
            $this->fromProp = null;
            $this->whereProp = null;
            
            return $this->queryProp;
        }
        elseif ((!empty($this->updateProp)) && (!empty($this->setProp)) && (!empty($this->whereProp)))
        {
            $this->queryProp = $this->updateProp . $this->setProp . $this->whereProp;
            $this->updateProp = null;
            $this->setProp = null;
            $this->whereProp = null;
            return $this->queryProp;
        }
        else
        {
            return NO_PROPERTIES;
        }
    }
}
?>
