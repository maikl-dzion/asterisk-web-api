<?php

class CoreAsteriskInfo {
    
    protected $db;

    public  $results = array();
    
    public function __construct($db){
        $this->db = $db; 
    }

    public function getResults() {

        $results = array();
        $results['tables'] = $this->getTables();
        $tableNameArr = array(
           'ringgroups'   => "SELECT * FROM ringgroups ORDER BY grpnum",
           'users'        => "SELECT * FROM users ORDER BY extension",
           'trunks'       => "SELECT * FROM trunks ORDER BY trunkid",
           'devices'      => '',
           'sip'          => '',
           'findmefollow' => '',

           'routes' => "SELECT a.*, b.seq FROM `outbound_routes` a
                        JOIN `outbound_route_sequence` b ON a.route_id = b.route_id
                        ORDER BY `seq`",

           'DID'             => "SELECT * FROM incoming ORDER BY description,extension,cidnum",
           'custom_contexts' => "SELECT * FROM customcontexts_contexts ",
           'queues_config'   => "SELECT * FROM queues_config ORDER BY extension",
           'queues_details'  => "SELECT * FROM queues_details ORDER BY id",
        );

        foreach($tableNameArr as $tableName => $value) {
            if($value)
              $results[$tableName] = $this->fetchData($value);
            else
              $results[$tableName] = $this->selectData($tableName);
        }

        $results['queues'] = $this->getQueues($results);
        $results['ivr_details'] = $this->ivrGetDetails();

        $customContexts = $results['custom_contexts'];
        $results['custom_contexts'] = $this->setCustomContextsIncludes($customContexts);

        // lg($results['custom_contexts']);

        return $results;
    }


    protected function getQueues($items) {
        $result = array();
        if(empty($items['queues_config'])
           || empty($items['queues_details'])) return array();

        $queuesConfig = $items['queues_config'];
        $queuesDetails = $items['queues_details'];

        foreach ($queuesConfig as $key => $queueValue) {
            $itemId       = $queueValue['extension'];
            $extNumbers   = array();
            $stategyValue = '';

            foreach ($queuesDetails as $detailKey => $detailVal) {
                if($itemId != $detailVal['id']) continue;

                $keyword = $detailVal['keyword'];
                $data    = $detailVal['data'];
                $flags   = $detailVal['flags'];

                switch($keyword) {

                    case 'member' :
                          $detailDataArr = explode(',', $data);
                          $extenNumber = preg_replace('/[^0-9]/', '', $detailDataArr[0]);
                          $extNumbers[$flags] = $extenNumber . ",0";
                          break;

                    case 'strategy' :
                          $stategyValue = $data;
                          break;
                }
            }  // foreach 2

            $queueValue['strategy']    = $stategyValue;
            $queueValue['ext_numbers'] = $extNumbers;
            $result[$key] = $queueValue;
        } // foreach 1

        return $result;
    }

    protected function getTables() {
        $result = array();
        $tables = $this->fetchData('SHOW TABLES');
        // lg($tables);
        foreach ($tables as $key => $values) {
            if(is_array($values)) {
               foreach ($values as $field => $tableName) 
                  $result[$tableName] = $tableName;    
            }
        }
        return $result;
    }
    
    protected function fetchData($sql) {
        return $this->db->select($sql);
    }
    
    protected function selectData($tableName, $where = '', $limit = '', $fields = ' * ') {
        $sql = 'SELECT ' . $fields . ' FROM ' . $tableName . ' ' . $where . ' ' . $limit;
        return $this->db->select($sql);
    }

    public function getTableFields($tableName) {
        $sql = ' DESCRIBE ' . $tableName;
        return $this->fetchData($sql);
    }

    public function getContextItem($context){
        $sql = 'SELECT * FROM customcontexts_contexts WHERE context = "' .$context.' "';
        $results = $this->db->select($sql);
        return $results;
    }


    public function getExtensionInfo($extension){
        $sipInfo = $extenInfo = array();
        $sql = "SELECT * FROM devices WHERE id = '$extension'";
        $extenInfo = $this->db->select($sql);
        $sql = "SELECT keyword,data FROM sip WHERE id = '$extension'";
        $sipTemp = $this->db->select($sql);
        foreach ($sipTemp as $key => $value) {
            $sipInfo[$value['keyword']] = $value['data'];
        }
        $results = array_merge($extenInfo[0], $sipInfo);
        return $results;
    }

    public function setCustomContextsIncludes($items) {
        $results = array();
        foreach ($items as $key => $values) {
            $context = $values['context'];
            $includesItem = $this->getContextIncludesList($context);
            if(empty($includesItem)) continue;

            $incItem = array();
            foreach ($includesItem as $inKey => $inValues) {
                $param = array();
                if (!empty($inValues['include'])) {
                    if (isset($inValues['allow']))
                        $param['allow'] = $inValues['allow'];
                    if (isset($inValues['sort']))
                        $param['sort'] = $inValues['sort'];
                    $incItem[$inValues['include']] = $param;
                }
            }
            $items[$key]['includes'] = $incItem;
        }

        $results = $items;
        return $results;
    }

    public function extensionContextSave($extension, $context){

//        $sql = "SELECT context FROM sip WHERE id = '$extension'";
//        $sipInfo = $this->db->select($sql);
//        $tableName = 'sip';
//        if(!empty($sipInfo)) {
//            $sql = 'UPDATE '.$tableName.' SET context="' .$context. '" WHERE id=' . $extension;
//        }
//        else {
//            $sql = 'INSERT INTO '.$tableName. ' context=';
//        }
//
//
//        $this->query($sql);
//
//        return $results;
    }

    public function ivrGetDetails($id = '') {

//        $sql = "SELECT *, announcement announcement_id FROM ivr_details
//                LEFT JOIN ivr_entries ON ivr_details.id = ivr_entries.ivr_id";

        $sql = "SELECT *, announcement announcement_id FROM ivr_details";
        if ($id) {
            $sql .= ' WHERE  id = "' . $id . '"';
        } else {
            $sql .= ' ORDER BY name';
        }

        $results = $this->db->select($sql);
        foreach ($results as $key =>$value) {
            $res = $this->ivrGetEntries($value['id']);
            $entries = array();
            foreach ($res as $enKey => $enVal) {
                $entries['ext'][] = $enVal['selection'];
                $entries['goto'][] = $enVal['dest'];
                $entries['ivr_ret'][] = $enVal['ivr_ret'];
            }
            $results[$key]['entries'] = $entries;
        }

        // lg($results);
        return $results;
    }


    public function ivrGetEntries($id) {
        $sql = "SELECT * FROM ivr_entries WHERE ivr_id = {$id} ORDER BY selection + 0 DESC";
        $result = $this->db->select($sql);
        return $result;
    }

    public function getContextIncludesRoutes($context) {
        $sql = "SELECT include, time, userules, seq FROM customcontexts_includes 
                LEFT OUTER JOIN timegroups_details
                ON  customcontexts_includes.timegroupid = timegroups_details.timegroupid 
                LEFT OUTER JOIN  outbound_route_sequence 
                ON REPLACE(include,'outrt-','') = outbound_route_sequence.route_id
                WHERE context = '$context' ORDER BY sort, seq";
        $results = $this->db->select($sql);
        return $results;
    }

    public function getContextIncludesList($context) {

        $sql = "SELECT  
                        customcontexts_contexts_list.context, 
                        customcontexts_contexts_list.description AS contextdescription, 
                        customcontexts_includes_list.include, 
                        customcontexts_includes_list.description, 
                        IF(saved.include is null, 'no', 
                            IF(saved.timegroupid is null, IF(saved.userules is null, 'yes', saved.userules),
                        saved.timegroupid)) AS allow, 
                        IF(saved.sort is null,customcontexts_includes_list.sort,saved.sort) AS sort, 
                        COUNT(preemptcheck.context) AS preemptcount 
					
					FROM customcontexts_contexts_list 
					
					INNER JOIN customcontexts_includes_list 
					ON customcontexts_contexts_list.context = customcontexts_includes_list.context 
					
					LEFT OUTER JOIN (SELECT * from customcontexts_includes WHERE context = '$context')  AS saved 
					ON customcontexts_includes_list.include = saved.include 
					
					LEFT OUTER JOIN customcontexts_contexts_list preemptcheck 
					ON customcontexts_includes_list.include = preemptcheck.context 
					
					LEFT OUTER JOIN  outbound_route_sequence 
					ON REPLACE(customcontexts_includes_list.include,'outrt-','') = outbound_route_sequence.route_id
					
					GROUP BY 
                        customcontexts_contexts_list.context, 
                        customcontexts_contexts_list.description, 
                        customcontexts_includes_list.include, 
                        customcontexts_includes_list.description, 
                        IF(saved.include is null, 'no', 
                            IF(saved.timegroupid is null, 'yes', saved.timegroupid)), 
                        saved.sort,  
                        customcontexts_contexts_list.description
					ORDER BY 
                        IF(saved.sort is null,201,saved.sort), 
                        customcontexts_includes_list.sort,
                        outbound_route_sequence.seq,
                        customcontexts_contexts_list.description, 
                        customcontexts_includes_list.description 
		";

        $results = $this->db->select($sql);

//        $tmparray = array();
//        foreach ($results as $val) {
//            $tmparray[] = array($val[0], $val[1], $val[2], $val[3], $val[4], $val[5], $val[6]);
//        }

        return $results;
    }


    public function getExtMap() {
        $extmap = array();
        $sql = "SELECT `data` FROM `module_xml` WHERE `id` = 'extmap_serialized'";
        $extmap_serialized = $this->db->select($sql);

        if ($extmap_serialized) {
            $extmap = unserialize($extmap_serialized);
        }

        return $extmap;
    }

}