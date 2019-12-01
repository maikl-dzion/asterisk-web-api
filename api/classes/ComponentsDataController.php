<?php

class ComponentsDataController extends BaseController {

    // ##################################
    // --- ПУБЛИЧНЫЕ МЕТОДЫ (ИНТЕРФЕЙС КЛАССА)
    public function getGrpList($itemId = 0) {
        $where = $orderBy = '';

        $sql = "SELECT * FROM ringgroups ";
        if($itemId) {
            $where = " WHERE grpnum ='{$itemId}' ";
        }
        else {
            $orderBy = " ORDER BY CAST(grpnum as UNSIGNED) ";
        }

        $results = $this->fetchData($sql . $where . $orderBy);

        return $results;
    }

    public function getQueuesList($itemId = 0) {
        $where = $orderBy = '';
        $sql = "SELECT * FROM queues_config ";
        if($itemId) {
            $where = " WHERE extension ='{$itemId}' ";
        }
        else {
            $orderBy = " ORDER BY extension ";
        }
        $results = $this->fetchData($sql . $where . $orderBy);
        return $results;
    }


    public function getUsersList($itemId = 0) {
        $where = $orderBy = '';
        $sql = "SELECT * FROM users ";
        if($itemId) {
            $where = " WHERE extension ='{$itemId}'";
        }
        else {
            $orderBy = " ORDER BY extension ";
        }
        $results = $this->fetchData($sql . $where . $orderBy);
        return $results;
    }


    public function getIvrList($itemId = 0) {
        $where = $orderBy = '';
        $sql = "SELECT *, announcement announcement_id FROM ivr_details ";
        if($itemId) {
            $where = "WHERE id ='{$itemId}' ";
        }
        else {
            $orderBy = " ORDER BY name ";
        }

        $results = $this->fetchData($sql . $where . $orderBy);
        return $results;
    }


    public function getTrunksList($itemId = 0) {
        $where = $orderBy = '';
        $sql = "SELECT * FROM trunks ";
        if($itemId) {
            $where = "WHERE trunkid ='{$itemId}' ";
        }
        else {
            $orderBy = " ORDER BY  trunkid ";
        }

        $results = $this->fetchData($sql . $where . $orderBy);
        return $results;
    }


    public function getOutRoutes($itemId = 0) {
        $where = $orderBy = '';
        $sql = "SELECT a.*, b.seq FROM `outbound_routes` a
                JOIN `outbound_route_sequence` b 
                ON a.route_id = b.route_id ";

        if($itemId) {
            $where = "";
        }
        else {
            $orderBy = " ORDER BY `seq` ";
        }

        $results = $this->fetchData($sql . $where . $orderBy);
        return $results;
    }


    public function getDidRoutes($itemId = 0) {
        $where = $orderBy = '';
        $sql = "SELECT * FROM incoming ";
        if($itemId) {
            $where = "";
        }
        else {
            $orderBy = " ORDER BY description,extension,cidnum ";
        }

        $results = $this->fetchData($sql . $where . $orderBy);
        return $results;
    }

    public function getCustomContextList($itemId = 0) {
        $where = $orderBy = '';
        $sql = "SELECT * FROM customcontexts_contexts";
        if($itemId) {
            $where = "";
        }
        else {
            $orderBy = "";
        }

        $results = $this->fetchData($sql . $where . $orderBy);
        return $results;
    }

    public function getSoundRecordList($itemId = 0) {
        $where = $orderBy = '';
        $sql = "SELECT * FROM recordings WHERE displayname <> '__invalid' ";
        if($itemId) {
            $where = "AND  id='{$id}'";
        }
        else {
            $orderBy = " ORDER BY displayname ";
        }

        $results = $this->fetchData($sql . $where . $orderBy);
        return $results;
    }


    public function getUserInfo($extension = 0, $type = '') {

        $sipInfo = $deviceInfo = $sipArr = $userInfo = $results = array();

        if(!$extension) $extension = $this->getRequestParam('extension');
        if(!$type) $type = $this->getRequestParam('type');

        $usersSql = "SELECT * FROM users WHERE extension = '{$extension}'";
        $userInfo = $this->fetchData($usersSql);
        $userInfo = $userInfo[0];

        $devSql = "SELECT * FROM devices WHERE id = '{$extension}'";
        $deviceInfo = $this->fetchData($devSql);
        $deviceInfo = $deviceInfo[0];

        $sipSql = "SELECT keyword,data FROM sip WHERE id = '{$extension}'";
        $sipArr = $this->fetchData($sipSql);

        $devinfoName = '';

        switch ($type) {
            case 'edit' : $devinfoName = 'devinfo_'; break;
        }

        $sipInfo = $deviceInfo;

        foreach ($userInfo as $fieldName => $value) {
            switch ($fieldName) {
                case 'extension' :
                    $sipInfo[$fieldName]  = $value;
                    $sipInfo['extdisplay'] = $value;
                    break;
                default :
                    $sipInfo[$fieldName]  = $value;
                    break;
            }
        }

        foreach ($sipArr as $key => $value) {
            $keyword = $devinfoName . $value['keyword'];
            $data    = $value['data'];
            if($value['keyword'] == 'secret') {
                $sipInfo['devinfo_secret_origional'] = $data;
            }
            $sipInfo[$keyword] = $data;
        }

        $results = $sipInfo;

        return $results;
    }

    // ##################################
    // --- ЗАКРЫТЫЕ МЕТОДЫ (ВНУТРЕННЯ ЛОГИКА КЛАССА)

}