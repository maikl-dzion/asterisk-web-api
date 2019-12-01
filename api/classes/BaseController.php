
<?php

class BaseController {

    protected $db;
    public $getter;
    public $postData = array();
    public $results  = array();
    public $params   = array();

    public function __construct($db, $params = array(), $getter = false){
        $this->db = $db;
        $this->params = $params;
        if($getter) $this->getter = $getter;
    }

    protected function fetchData($sql) {
        return $this->db->select($sql);
    }

    protected function query($sql) {
        return $this->db->query($sql);
    }

    public function getPostData() {
        $result = array();
        $method = $_SERVER['REQUEST_METHOD'];
        switch($method) {
            case 'POST' :
                $postData = (array)json_decode(file_get_contents('php://input'));
                // lg($postData);
                if(!empty($postData)) {
                    $postData = $this->formattedInArray($postData);
                    $_POST = $postData;
                    $this->postData = $postData;
                    $result = $postData;
                }
                break;
        }
        return $result;
    }

    public function formattedInArray($data) {
        $result = array();
        foreach($data as $key => $values) {
            $type = is_object($values);
            if($type) {
                $result[$key] = $this->formattedInArray($values);
            }
            else {
                $result[$key] = $values;
            }
        }
        return $result;
    }

    public function getRequestParam($param = '') {
        $result = '';
        if(!empty($_GET[$param]))
            $result = $_GET[$param];
        return $result;
    }

    protected function getQueryStringParams() {
        // [QUERY_STRING] => remote_request_rest_api_service=1&action=ComponentsDataController&funcName=getUserInfo&extension=33
    }

}