
<?php

class MySQLiClass
{

    protected $mysqli;
    public $tableName = '';
    protected $config   = array();


    //############################
    //---- PUBLIC INTERFACE ---
    
    public function __construct($config = array())
    {
        $this->config = $config;
        
        $host = $config['host'];
        $user = $config['user'];
        $password = $config['password'];
        $dbname   = $config['dbname'];
        
        try {
          $this->mysqli = new mysqli($host, $user, $password, $dbname);  
        }
        catch (Exception $e) { 
          lg($e, 'BaseException');
        }   
         
    }

    //------ add item
    public function insert($data = array(), $tableName, $dbName = '') {
        $data = (array)$data;
        if(!$tableName) $tableName = $this->tableName;
        $query = $this->sqlInsertFormatted($data, $tableName, $dbName);
        $sql = 'INSERT INTO '.$tableName. ' ' .$query;
        $this->query($sql); 
    }
    
    //----- update item
    public function update($data = array(), $tableName, $where = '') {
        $data = (array)$data;
        $query = $this->sqlUpdateFormatted($data, $tableName);
        $sql = 'UPDATE  '.$tableName. ' SET ' . $query . $where;
        $this->query($sql); 
    }
    
    //---- основная выборка 
    public function select($sql, $fieldName = '')
    {
        $result   = array();
        $resource = $this->mysqli->query($sql);
        if(empty($resource)) return $result;
        
        if(!$fieldName) {
             while ($row = $resource->fetch_assoc()) $result[] = $row;
        }
        else {
            while ($row = $resource->fetch_assoc()) 
                if(isset($row[$fieldName])) 
                    $result[$row[$fieldName]] = $row;            
        }
        
        return $result;
    }
    
    public function setTableName($tableName){
        $this->tableName = $tableName;
    }
    
    //############################
    //---- PROTECTED INTERFACE ---
    public function query($sql){
        return $this->mysqli->query($sql);
    }

    protected function error(){
        return $this->mysqli->error;
    }

    

    protected function escape($value){
        return $value = '"' . $this->mysqli->real_escape_string($value) . '"';
    }

    protected function sqlInsertFormatted($data, $tableName = 'phones', $dbName = 'test')
    {

        $fields = $values = array();
        $rowDate = date("Y-m-d H:i:s");
        $dbName  = $this->config['dbname'];
        $query = 'SHOW COLUMNS FROM ' . $dbName . '.' . $tableName;
        $result = $this->query($query);

        $tableFields = array();
        while ($row = $result->fetch_assoc()) {
            $name = $row['Field'];
            $auto = $row['Extra'];
            if ($auto == 'auto_increment')
                $this->autoName = $name;

            $tableFields[$name] = $row;
        }

        foreach ($tableFields as $key => $fValues) {
            if (isset($data[$key])) {
                $value = $this->escape($data[$key]);
                $fields[] = $key;
                $values[] = $value;
            }
        }

        $query = ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $values) . ') ';

        return $query;
    }
    
    
    protected function sqlUpdateFormatted($data, $tableName)
    {

        $fields = $values = $resultVal = array();
        $rowDate = date("Y-m-d H:i:s");
        $dbName  = $this->config['dbname'];  
        $query = 'SHOW COLUMNS FROM ' . $dbName . '.' . $tableName;
        $result = $this->query($query);

        $tableFields = array();
        while ($row = $result->fetch_assoc()) {
            $name = $row['Field'];
            $auto = $row['Extra'];
            if ($auto == 'auto_increment')
                $this->autoName = $name;

            $tableFields[$name] = $row;
        }

        foreach ($tableFields as $key => $fValues) {
            if (isset($data[$key])) {
                $value = $this->escape($data[$key]);
                //$fields[] = $key;
                //$values[] = $value;
                $resultVal[] = $key . '=' . $value;
            }
        }

        $query = implode(',', $resultVal); 
        // lg($query);
        // $query = ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $values) . ') ';
        return $query;
    }

}
