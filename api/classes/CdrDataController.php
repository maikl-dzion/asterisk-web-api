<?php

class CdrDataController extends BaseController {

//    public $getter = '';

//    public function __construct($getter = '') {
//        parent::__construct();
//    }

    // ##################################
    // --- ПУБЛИЧНЫЕ МЕТОДЫ (ИНТЕРФЕЙС КЛАССА)
    public function getCdrData($itemId = 0) {
        $results = array();
        // '2019-03-01 00:00:00' AND '2019-03-31 23:59:59'
        // calldate BETWEEN '{$curDate} 00:00:00' AND '{$curDate} 23:59:59'

        $curDate = date('Y-m-d');
        $sql = "SELECT   `calldate`, `clid`, `did`, `src`, `dst`, `dcontext`, 
                         `channel`,`dstchannel`, `lastapp`, `lastdata`, `duration`,
                         `billsec`, `disposition`, `amaflags`, `accountcode`, `uniqueid`, `userfield`, 
                         unix_timestamp(calldate) as `call_timestamp`, 
                         `recordingfile`, `cnum`, `cnam`, `outbound_cnum`, `outbound_cnam`, `dst_cnam`  
                         FROM cdr  WHERE 
                         /** calldate BETWEEN '{$curDate} 00:00:00' AND '{$curDate} 23:59:59' **/
                         calldate BETWEEN '2019-03-01 00:00:00' AND '2019-03-31 23:59:59'           
                         ORDER BY calldate DESC LIMIT 100";

        $users = $this->getter->getUsersList();
        $calls = $this->fetchData($sql);

//        foreach ($users as $userKey => $user) {
//            $extension = $user['extension'];
//            $userName  = $user['name'];
//
//            foreach ($calls as $callKey => $call) {
//
//                if($call['src'] == $extension) {
//                    $call ['user_phone1'] = $extension;
//                    $call ['user_name1']  = $userName;
//                    $call ['call_vector1']  = 1;
//                }
//                elseif($call['dst'] == $extension) {
//                    $call ['user_phone2'] = $extension;
//                    $call ['user_name2']  = $userName;
//                    $call ['call_vector2']  = 2;
//                }
//                else {
//                    $call ['user_phone3'] = '';
//                    $call ['user_name3']  = '';
//                    $call ['call_vector3']  = 3;
//                }
//                $results[] = $call;
//            }
//        }

        foreach ($calls as $callKey => $call) {

            $src = $call['src'];
            $dst = $call['dst'];
            $call['call_vector'] = 'external';

            foreach ($users as $userKey => $user) {
                $extension = $user['extension'];
                $userName  = $user['name'];

                if($src == $extension) {
                    $call ['user_phone_src'] = $extension;
                    $call ['user_name_src']  = $userName;
                    $call ['vector_src']  = 1;
                }

                if($dst == $extension) {
                    $call ['user_phone_dst'] = $extension;
                    $call ['user_name_dst']  = $userName;
                    $call ['vector_dst']  = 1;
                }
            }

            if(!empty($call ['vector_dst']) &&
               !empty($call ['vector_src']) ) {
                $call['call_vector'] = 'internal';
            }

            $results[] = $call;
        }

        // lg($results);

        return $results;
    }


//    protected function findUserList($$users) {
//
//        foreach ($users as $userKey => $user) {
//            $extension = $user['extension'];
//            $userName  = $user['name'];
//        }
//
//    }

    // ##################################
    // --- ЗАКРЫТЫЕ МЕТОДЫ (ВНУТРЕННЯ ЛОГИКА КЛАССА)

}

