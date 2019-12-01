
<?php

class InfoObjectsDetails extends BaseController {

    protected $tableName = 'info_objects_details';

    public function getItem($itemId = 0, $type = 0) {
       $where = '';
       if($itemId) {
           $where = " WHERE `item_id` = {$itemId} 
                      AND `_type`='{$type}'";
       }
       $sql = "SELECT * FROM {$this->tableName} " . $where;
       $result = $this->fetchData($sql);
       return $result;
    }

    public function saveInfo($itemId = 0) {

        $result = false;
        $query  = '';

        $itemId = $this->postData['item_id'];
        $type   = $this->postData['_type'];
        $left   = $this->postData['_left'];
        $top    = $this->postData['_top'];

        $item = $this->getItem($itemId, $type);

        if(empty($item)) {
            $query = "
                INSERT INTO `{$this->tableName}`
                       (`item_id`,   `_type`,   `_left`,   `_top`) 
                VALUES ('{$itemId}', '{$type}', '{$left}', '{$top}')";
        }
        else {
            $infoId = $item[0]['info_id'];

            $query = "
                UPDATE `{$this->tableName}` SET   
                    `_left` = '{$left}', 
                    `_top`  = '{$top}'  
                WHERE 
                    `info_id` = {$infoId} ";
        }

        if($query)
            $result = $this->query($query);

        return array('result' => $result);
    }

}   