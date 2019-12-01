<?php

global $amp_conf, $db;
// Are a crypt password specified? If not, use the supplied.
$REC_CRYPT_PASSWORD = (isset($amp_conf['AMPPLAYKEY']) && trim($amp_conf['AMPPLAYKEY']) != "")?trim($amp_conf['AMPPLAYKEY']):'TheWindCriesMary';
$dispnum = "cdr";
$db_result_limit = 100;

// Check if cdr database and/or table is set, if not, use our default settings
$db_name = !empty($amp_conf['CDRDBNAME'])?$amp_conf['CDRDBNAME']:"asteriskcdrdb";
$db_table_name = !empty($amp_conf['CDRDBTABLENAME'])?$amp_conf['CDRDBTABLENAME']:"cdr";
$system_monitor_dir = isset($amp_conf['ASTSPOOLDIR'])?$amp_conf['ASTSPOOLDIR']."/monitor":"/var/spool/asterisk/monitor";

// if CDRDBHOST and CDRDBTYPE are not empty then we assume an external connection and don't use the default connection
//
if (!empty($amp_conf["CDRDBHOST"]) && !empty($amp_conf["CDRDBTYPE"])) {
    $db_hash = array('mysql' => 'mysql', 'postgres' => 'pgsql');
    $db_type = $db_hash[$amp_conf["CDRDBTYPE"]];
    $db_host = $amp_conf["CDRDBHOST"];
    $db_port = empty($amp_conf["CDRDBPORT"]) ? '' :  ':' . $amp_conf["CDRDBPORT"];
    $db_user = empty($amp_conf["CDRDBUSER"]) ? $amp_conf["AMPDBUSER"] : $amp_conf["CDRDBUSER"];
    $db_pass = empty($amp_conf["CDRDBPASS"]) ? $amp_conf["AMPDBPASS"] : $amp_conf["CDRDBPASS"];
    $datasource = $db_type . '://' . $db_user . ':' . $db_pass . '@' . $db_host . $db_port . '/' . $db_name;
    $dbcdr = DB::connect($datasource); // attempt connection
    if(DB::isError($dbcdr)) {
        die_freepbx($dbcdr->getDebugInfo());
    }
} else {
    $dbcdr = $db;
}



// For use in encrypt-decrypt of path and filename for the recordings
include_once("crypt.php");

switch ($action) {
    case 'cdr_play':
    case 'cdr_audio':
        include_once("$action.php");
        exit;
        break;
    case 'download_audio':
        $file = $db->getOne('SELECT recordingfile FROM ' . $db_name.'.'.$db_table_name . ' WHERE uniqueid = ?',
            array($_REQUEST['cdr_file']));
        db_e($file);
        if ($file) {
            $rec_parts = explode('-',$file);
            $fyear = substr($rec_parts[3],0,4);
            $fmonth = substr($rec_parts[3],4,2);
            $fday = substr($rec_parts[3],6,2);
            $monitor_base = $amp_conf['MIXMON_DIR'] ? $amp_conf['MIXMON_DIR'] : $amp_conf['ASTSPOOLDIR'] . '/monitor';
            $file = "$monitor_base/$fyear/$fmonth/$fday/" . $file;
            download_file($file, '', '', true);
        }
        exit;
        break;
    default:
        break;
}


// FREEPBX-8845
foreach ($_POST as $k => $v) {
    $_POST[$k] = preg_replace('/;/', ' ', $dbcdr->escapeSimple($v));
}

$h_step = 30;


//        $where = "WHERE `uniqueid` IN ('" . implode("','",array_unique($cdr_uids)) . "')";
//        $query = "SELECT `calldate`, `clid`, `did`, `src`, `dst`, `dcontext`, `channel`, `dstchannel`, `lastapp`,
//                                     `lastdata`, `duration`, `billsec`, `disposition`, `amaflags`, `accountcode`, `uniqueid`,
//                                     `userfield`, unix_timestamp(calldate) as `call_timestamp`, `recordingfile`, `cnum`, `cnam`,
//                                     `outbound_cnum`, `outbound_cnam`, `dst_cnam` FROM $db_name.$db_table_name $where";
//        $resultscdr = $dbcdr->getAll($query, DB_FETCHMODE_ASSOC);

$startmonth = empty($_POST['startmonth']) ? date('m') : $_POST['startmonth'];
$startyear = empty($_POST['startyear']) ? date('Y') : $_POST['startyear'];

if (empty($_POST['startday'])) {
    $startday = '01';
} elseif (isset($_POST['startday']) && ($_POST['startday'] > date('t', strtotime("$startyear-$startmonth")))) {
    $startday = $_POST['startday'] = date('t', strtotime("$startyear-$startmonth"));
} else {
    $startday = sprintf('%02d',$_POST['startday']);
}
$starthour = empty($_POST['starthour']) ? '00' : sprintf('%02d',$_POST['starthour']);
$startmin = empty($_POST['startmin']) ? '00' : sprintf('%02d',$_POST['startmin']);

$startdate = "'$startyear-$startmonth-$startday $starthour:$startmin:00'";
$start_timestamp = mktime( $starthour, $startmin, 59, $startmonth, $startday, $startyear );

$endmonth = empty($_POST['endmonth']) ? date('m') : $_POST['endmonth'];
$endyear = empty($_POST['endyear']) ? date('Y') : $_POST['endyear'];

if (empty($_POST['endday']) || (isset($_POST['endday']) && ($_POST['endday'] > date('t', strtotime("$endyear-$endmonth-01"))))) {
    $endday = $_POST['endday'] = date('t', strtotime("$endyear-$endmonth"));
} else {
    $endday = sprintf('%02d',$_POST['endday']);
}
$endhour = empty($_POST['endhour']) ? '23' : sprintf('%02d',$_POST['endhour']);
$endmin = empty($_POST['endmin']) ? '59' : sprintf('%02d',$_POST['endmin']);

$enddate = "'$endyear-$endmonth-$endday $endhour:$endmin:59'";
$end_timestamp = mktime( $endhour, $endmin, 59, $endmonth, $endday, $endyear );

#
# asterisk regexp2sqllike
#
if ( !isset($_POST['outbound_cnum']) ) {
    $outbound_cnum_number = NULL;
} else {
    $outbound_cnum_number = cdr_asteriskregexp2sqllike( 'outbound_cnum', '' );
}

if ( !isset($_POST['cnum']) ) {
    $cnum_number = NULL;
} else {
    $cnum_number = cdr_asteriskregexp2sqllike( 'cnum', '' );
}

if ( !isset($_POST['dst']) ) {
    $dst_number = NULL;
} else {
    $dst_number = cdr_asteriskregexp2sqllike( 'dst', '' );
}

$date_range = "calldate BETWEEN $startdate AND $enddate";

$mod_vars['outbound_cnum'][] = $outbound_cnum_number;
$mod_vars['outbound_cnum'][] = empty($_POST['outbound_cnum_mod']) ? NULL : $_POST['outbound_cnum_mod'];
$mod_vars['outbound_cnum'][] = empty($_POST['outbound_cnum_neg']) ? NULL : $_POST['outbound_cnum_neg'];

$mod_vars['cnum'][] = $cnum_number;
$mod_vars['cnum'][] = empty($_POST['cnum_mod']) ? NULL : $_POST['cnum_mod'];
$mod_vars['cnum'][] = empty($_POST['cnum_neg']) ? NULL : $_POST['cnum_neg'];

$mod_vars['cnam'][] = !isset($_POST['cnam']) ? NULL : $_POST['cnam'];
$mod_vars['cnam'][] = empty($_POST['cnam_mod']) ? NULL : $_POST['cnam_mod'];
$mod_vars['cnam'][] = empty($_POST['cnam_neg']) ? NULL : $_POST['cnam_neg'];

$mod_vars['dst_cnam'][] = !isset($_POST['dst_cnam']) ? NULL : $_POST['dst_cnam'];
$mod_vars['dst_cnam'][] = empty($_POST['dst_cnam_mod']) ? NULL : $_POST['dst_cnam_mod'];
$mod_vars['dst_cnam'][] = empty($_POST['dst_cnam_neg']) ? NULL : $_POST['dst_cnam_neg'];

$mod_vars['did'][] = !isset($_POST['did']) ? NULL : $_POST['did'];
$mod_vars['did'][] = empty($_POST['did_mod']) ? NULL : $_POST['did_mod'];
$mod_vars['did'][] = empty($_POST['did_neg']) ? NULL : $_POST['did_neg'];

$mod_vars['dst'][] = $dst_number;
$mod_vars['dst'][] = empty($_POST['dst_mod']) ? NULL : $_POST['dst_mod'];
$mod_vars['dst'][] = empty($_POST['dst_neg']) ? NULL : $_POST['dst_neg'];

$mod_vars['userfield'][] = !isset($_POST['userfield']) ? NULL : $_POST['userfield'];
$mod_vars['userfield'][] = empty($_POST['userfield_mod']) ? NULL : $_POST['userfield_mod'];
$mod_vars['userfield'][] = empty($_POST['userfield_neg']) ? NULL : $_POST['userfield_neg'];

$mod_vars['accountcode'][] = !isset($_POST['accountcode']) ? NULL : $_POST['accountcode'];
$mod_vars['accountcode'][] = empty($_POST['accountcode_mod']) ? NULL : $_POST['accountcode_mod'];
$mod_vars['accountcode'][] = empty($_POST['accountcode_neg']) ? NULL : $_POST['accountcode_neg'];
$result_limit = (!isset($_POST['limit']) || empty($_POST['limit'])) ? $db_result_limit : $_POST['limit'];

$multi = array('dst', 'cnum', 'outbound_cnum');

foreach ($mod_vars as $key => $val) {
    if (is_blank($val[0])) {
        unset($_POST[$key.'_mod']);
        $$key = NULL;
    } else {
        $pre_like = '';
        if ( $val[2] == 'true' ) {
            $pre_like = ' NOT ';
        }
        switch ($val[1]) {
            case "contains":
                if (in_array($key, $multi)) {
                    $values = explode(',',$val[0]);
                    if (count($values) > 1) {
                        foreach ($values as $key_like => $value_like) {
                            if ($key_like == 0) {
                                $$key = "AND $key $pre_like LIKE '%$value_like%'";
                            } else {
                                $$key .= " OR $key $pre_like LIKE '%$value_like%'";
                            }
                        }
                    } else {
                        $$key = "AND $key $pre_like LIKE '%$val[0]%'";
                    }
                } else {
                    $$key = "AND $key $pre_like LIKE '%$val[0]%'";
                }
                break;
            case "ends_with":
                if (in_array($key, $multi)) {
                    $values = explode(',',$val[0]);
                    if (count($values) > 1) {
                        foreach ($values as $key_like => $value_like) {
                            if ($key_like == 0) {
                                $$key = "AND $key $pre_like LIKE '%$value_like'";
                            } else {
                                $$key .= " OR $key $pre_like LIKE '%$value_like'";
                            }
                        }
                    } else {
                        $$key = "AND $key $pre_like LIKE '%$val[0]'";
                    }
                } else {
                    $$key = "AND $key $pre_like LIKE '%$val[0]'";
                }
                break;
            case "exact":
                if ( $val[2] == 'true' ) {
                    $$key = "AND $key != '$val[0]'";
                } else {
                    $$key = "AND $key = '$val[0]'";
                }
                break;
            case "asterisk-regexp":
                $ast_dids = preg_split('/\s*,\s*/', $val[0], -1, PREG_SPLIT_NO_EMPTY);
                $ast_key = '';
                foreach ($ast_dids as $adid) {
                    if (strlen($ast_key) > 0 ) {
                        if ( $pre_like == ' NOT ' ) {
                            $ast_key .= " and ";
                        } else {
                            $ast_key .= " or ";
                        }
                        if ( '_' == substr($adid,0,1) ) {
                            $adid = substr($adid,1);
                        }
                    }
                    $ast_key .= " $key $pre_like RLIKE '^$adid\$'";
                }
                $$key = "AND ( $ast_key )";
                break;
            case "begins_with":
            default:
                if (in_array($key, $multi)) {
                    $values = explode(',',$val[0]);
                    if (count($values) > 1) {
                        foreach ($values as $key_like => $value_like) {
                            if ($key_like == 0) {
                                $$key = "AND $key $pre_like LIKE '$value_like%'";
                            } else {
                                $$key .= " OR $key $pre_like LIKE '$value_like%'";
                            }
                        }
                    } else {
                        $$key = "AND $key $pre_like LIKE '$val[0]%'";
                    }
                } else {
                    $$key = "AND $key $pre_like LIKE '$val[0]%'";
                }
                break;
        }
    }
}

if ( isset($_POST['disposition_neg']) && $_POST['disposition_neg'] == 'true' ) {
    $disposition = (empty($_POST['disposition']) || $_POST['disposition'] == 'all') ? NULL : "AND disposition != '$_POST[disposition]'";
} else {
    $disposition = (empty($_POST['disposition']) || $_POST['disposition'] == 'all') ? NULL : "AND disposition = '$_POST[disposition]'";
}

$duration = (!isset($_POST['dur_min']) || is_blank($_POST['dur_max'])) ? NULL : "AND duration BETWEEN '$_POST[dur_min]' AND '$_POST[dur_max]'";
$order = empty($_POST['order']) ? 'ORDER BY calldate' : "ORDER BY $_POST[order]";
$sort = empty($_POST['sort']) ? 'DESC' : $_POST['sort'];
$group = empty($_POST['group']) ? 'day' : $_POST['group'];

//Allow people to search SRC and DSTChannels using existing fields
if (isset($cnum)) {
    $cnum_length = strlen($cnum);
    $cnum_type = substr($cnum, 0 ,strpos($cnum , 'cnum') -1);
    $cnum_remaining = substr($cnum, strpos($cnum , 'cnum'));
    $src = str_replace('AND cnum', '', $cnum);

    $cnum = "$cnum_type ($cnum_remaining OR src $src)";
}

if (isset($dst)) {
    $dst_length = strlen($dst);
    $dst_type = substr($dst, 0 ,strpos($dst , 'dst') -1);
    $dst_remaining = substr($dst, strpos($dst , 'dst'));
    $dstchannel = str_replace('AND dst', '', $dst);

    $dst = "$dst_type ($dst_remaining OR dstchannel $dstchannel)";
}

// Build the "WHERE" part of the query
$where = "WHERE $date_range $cnum $outbound_cnum $cnam $dst_cnam $did $dst $userfield $accountcode $disposition $duration";

if ( isset($_POST['need_csv']) && $_POST['need_csv'] == 'true' ) {
    $query = "(SELECT calldate, clid, did, src, dst, dcontext, channel, dstchannel, lastapp, lastdata, duration, billsec, disposition, amaflags, accountcode, uniqueid, userfield, cnum, cnam, outbound_cnum, outbound_cnam, dst_cnam FROM $db_name.$db_table_name $where $order $sort LIMIT $result_limit)";
    $resultcsv = $dbcdr->getAll($query, DB_FETCHMODE_ASSOC);
    cdr_export_csv($resultcsv);
}


$query = "SELECT `calldate`, `clid`, `did`, `src`, `dst`, `dcontext`, `channel`, 
                 `dstchannel`, `lastapp`, `lastdata`, `duration`, `billsec`, `disposition`, `amaflags`, 
                 `accountcode`, `uniqueid`, `userfield`, unix_timestamp(calldate) as `call_timestamp`, 
                 `recordingfile`, `cnum`, `cnam`, `outbound_cnum`, `outbound_cnam`, `dst_cnam`  
          FROM $db_name.$db_table_name $where $order $sort LIMIT $result_limit";

$resultscdr = $dbcdr->getAll($query, DB_FETCHMODE_ASSOC);

// lg($resultscdr);


if ( isset($resultscdr) ) {
    $tot_calls_raw = sizeof($resultscdr);
} else {
    $tot_calls_raw = 0;
}

$resultCdrTable = array();

if ( $tot_calls_raw ) {
    // This is a bit of a hack, if we generated CEL data above, then these are simply the records all related to that CEL
    // event stream.
    //
//    if (!isset($cel)) {
//        echo "<p class=\"center title\">"._("Call Detail Record - Search Returned")." ".$tot_calls_raw." "._("Calls")."</p>";
//    } else {
//        echo "<p class=\"center title\">"._("Related Call Detail Records") . "</p>";
//    }
//    echo "<table id=\"cdr_table\" class=\"cdr\">";

    $i = $h_step - 1;
    $id = -1;  // tracker for recording index


    foreach($resultscdr as $row) {

        $cdrItem = array();

        ++$id;  // Start at table row 1
        ++$i;

        if ($row['recordingfile']) {
            $rec_parts = explode('-',$row['recordingfile']);
            $fyear = substr($rec_parts[3],0,4);
            $fmonth = substr($rec_parts[3],4,2);
            $fday = substr($rec_parts[3],6,2);
            $monitor_base = $amp_conf['MIXMON_DIR'] ? $amp_conf['MIXMON_DIR'] : $amp_conf['ASTSPOOLDIR'] . '/monitor';
            $recordingfile = "$monitor_base/$fyear/$fmonth/$fday/" . $row['recordingfile'];
            if (!file_exists($recordingfile)) {
                $recordingfile = '';
            }
        } else {
            $recordingfile = '';
        }

        //##########################################################
        // echo "  <tr class=\"record\">\n"; #######################

        $cdrItem['call_date']   = cdr_formatCallDate($row['calldate']);
        $cdrItem['record_file'] = cdr_formatRecordingFile($recordingfile, $row['recordingfile'], $id, $row['uniqueid']);
        $cdrItem['uniqueid']    = cdr_formatUniqueID($row['uniqueid']);

        $tcid = $row['cnam'] == '' ? '<' . $row['cnum'] . '>' : $row['cnam'] . ' <' . $row['cnum'] . '>';
        if ($row['outbound_cnum'] != '') {
            $cid = '<' . $row['outbound_cnum'] . '>';
            if ($row['outbound_cnam'] != '') {
                $cid = $row['outbound_cnam'] . ' ' . $cid;
            }
        } else {
            $cid = $tcid;
        }
        // for legacy records
        if ($cid == '<>') {
            $cid = $row['src'];
            $tcid = $row['clid'];
        }
        //cdr_formatSrc($cid, $tcid);

        if ($row['cnum'] != '' || $row['cnum'] != '') {
            $cdrItem['caller_id'] = cdr_formatCallerID($row['cnam'], $row['cnum'], $row['channel']);
            $cdrItem['format_src'] = '';
        } else {
            $cdrItem['caller_id'] = '';
            $cdrItem['format_src'] = cdr_formatSrc($row['src'], $row['clid']);
        }

        $cdrItem['out_caller_id'] = cdr_formatCallerID($row['outbound_cnam'], $row['outbound_cnum'], $row['dstchannel']);
        $cdrItem['did'] = cdr_formatDID($row['did']);
        $cdrItem['format_app']  = cdr_formatApp($row['lastapp'], $row['lastdata']);
        $cdrItem['format_dst']  = cdr_formatDst($row['dst'], $row['dst_cnam'], $row['dstchannel'], $row['dcontext']);
        $cdrItem['disposition'] = cdr_formatDisposition($row['disposition'], $row['amaflags']);
        $cdrItem['duration']    = cdr_formatDuration($row['duration'], $row['billsec']);
        $cdrItem['userfield']   = cdr_formatUserField($row['userfield']);
        $cdrItem['accountcode'] = cdr_formatAccountCode($row['accountcode']);

        $resultCdrTable[] = $cdrItem;

//        echo "    <td></td>\n";
//        echo "    <td></td>\n";
//        echo "  </tr>\n";
    }
    // echo "</table>";
}


//NEW GRAPHS
$group_by_field = $group;
// ConcurrentCalls
$group_by_field_php = array( '', 32, '' );

switch ($group) {
    case "disposition_by_day":
        $graph_col_title = 'Disposition by day';
        $group_by_field_php = array('%Y-%m-%d / ',17,'');
        $group_by_field = "CONCAT(DATE_FORMAT(calldate, '$group_by_field_php[0]'),disposition)";
        break;
    case "disposition_by_hour":
        $graph_col_title = 'Disposition by hour';
        $group_by_field_php = array( '%Y-%m-%d %H / ', 20, '' );
        $group_by_field = "CONCAT(DATE_FORMAT(calldate, '$group_by_field_php[0]'),disposition)";
        break;
    case "disposition":
        $graph_col_title = 'Disposition';
        break;
    case "dcontext":
        $graph_col_title = 'Destination context';
        break;
    case "accountcode":
        $graph_col_title = _("Account Code");
        break;
    case "dst":
        $graph_col_title = _("Destination Number");
        break;
    case "did":
        $graph_col_title = _("DID");
        break;
    case "cnum":
        $graph_col_title = _("Caller ID Number");
        break;
    case "cnam":
        $graph_col_title = _("Caller ID Name");
        break;
    case "outbound_cnum":
        $graph_col_title = _("Outbound Caller ID Number");
        break;
    case "outbound_cnam":
        $graph_col_title = _("Outbound Caller ID Name");
        break;
    case "dst_cnam":
        $graph_col_title = _("Destination Caller ID Name");
        break;
    case "userfield":
        $graph_col_title = _("User Field");
        break;
    case "hour":
        $group_by_field_php = array( '%Y-%m-%d %H', 13, '' );
        $group_by_field = "DATE_FORMAT(calldate, '$group_by_field_php[0]')";
        $graph_col_title = _("Hour");
        break;
    case "hour_of_day":
        $group_by_field_php = array('%H',2,'');
        $group_by_field = "DATE_FORMAT(calldate, '$group_by_field_php[0]')";
        $graph_col_title = _("Hour of day");
        break;
    case "week":
        $group_by_field_php = array('%V',2,'');
        $group_by_field = "DATE_FORMAT(calldate, '$group_by_field_php[0]') ";
        $graph_col_title = _("Week ( Sun-Sat )");
        break;
    case "month":
        $group_by_field_php = array('%Y-%m',7,'');
        $group_by_field = "DATE_FORMAT(calldate, '$group_by_field_php[0]')";
        $graph_col_title = _("Month");
        break;
    case "day_of_week":
        $group_by_field_php = array('%w - %A',20,'');
        $group_by_field = "DATE_FORMAT( calldate, '%W' )";
        $graph_col_title = _("Day of week");
        break;
    case "minutes1":
        $group_by_field_php = array( '%Y-%m-%d %H:%M', 16, '' );
        $group_by_field = "DATE_FORMAT(calldate, '%Y-%m-%d %H:%i')";
        $graph_col_title = _("Minute");
        break;
    case "minutes10":
        $group_by_field_php = array('%Y-%m-%d %H:%M',15,'0');
        $group_by_field = "CONCAT(SUBSTR(DATE_FORMAT(calldate, '%Y-%m-%d %H:%i'),1,15), '0')";
        $graph_col_title = _("10 Minutes");
        break;
    case "day":
    default:
        $group_by_field_php = array('%Y-%m-%d',10,'');
        $group_by_field = "DATE_FORMAT(calldate, '$group_by_field_php[0]')";
        $graph_col_title = _("Day");
}

if ( isset($_POST['need_chart']) && $_POST['need_chart'] == 'true' ) {
    $query2 = "SELECT $group_by_field AS group_by_field, count(*) AS total_calls, sum(duration) AS total_duration FROM $db_name.$db_table_name $where GROUP BY group_by_field ORDER BY group_by_field ASC LIMIT $result_limit";
    $result2 = $dbcdr->getAll($query2, DB_FETCHMODE_ASSOC);

    $tot_calls = 0;
    $tot_duration = 0;
    $max_calls = 0;
    $max_duration = 0;
    $tot_duration_secs = 0;
    $result_array = array();
    foreach($result2 as $row) {
        $tot_duration_secs += $row['total_duration'];
        $tot_calls += $row['total_calls'];
        if ( $row['total_calls'] > $max_calls ) {
            $max_calls = $row['total_calls'];
        }
        if ( $row['total_duration'] > $max_duration ) {
            $max_duration = $row['total_duration'];
        }
        array_push($result_array,$row);
    }
    $tot_duration = sprintf('%02d', intval($tot_duration_secs/60)).':'.sprintf('%02d', intval($tot_duration_secs%60));

    if ( $tot_calls ) {
        $html = "<p class=\"center title\">"._("Call Detail Record - Call Graph by")." ".$graph_col_title."</p><table class=\"cdr\">";
        $html .= "<tr><th class=\"end_col\">". $graph_col_title . "</th>";
        $html .= "<th class=\"center_col\">"._("Total Calls").": ". $tot_calls ." / "._("Max Calls").": ". $max_calls ." / "._("Total Duration").": ". $tot_duration ."</th>";
        $html .= "<th class=\"end_col\">"._("Average Call Time")."</th>";
        $html .= "<th class=\"img_col\"><a href=\"#CDR\" title=\""._("Go to the top of the CDR table")."\"><img src=\"images/scrollup.gif\" alt=\"CDR Table\" /></a></th>";
        $html .= "<th class=\"img_col\"><a href=\"#Graph\" title=\""._("Go to the CDR Graph")."\"><img src=\"images/scrolldown.gif\" alt=\"CDR Graph\" /></a></th>";
        $html .= "</tr>";
        echo $html;

        foreach ($result_array as $row) {
            $avg_call_time = sprintf('%02d', intval(($row['total_duration']/$row['total_calls'])/60)).':'.sprintf('%02d', intval($row['total_duration']/$row['total_calls']%60));
            $bar_calls = $row['total_calls']/$max_calls*100;
            $percent_tot_calls = intval($row['total_calls']/$tot_calls*100);
            $bar_duration = $row['total_duration']/$max_duration*100;
            $percent_tot_duration = intval($row['total_duration']/$tot_duration_secs*100);
            $html_duration = sprintf('%02d', intval($row['total_duration']/60)).':'.sprintf('%02d', intval($row['total_duration']%60));
            echo "  <tr>\n";
            echo "    <td class=\"end_col\">".$row['group_by_field']."</td><td class=\"center_col\"><div class=\"bar_calls\" style=\"width : $bar_calls%\">".$row['total_calls']." - $percent_tot_calls%</div><div class=\"bar_duration\" style=\"width : $bar_duration%\">$html_duration - $percent_tot_duration%</div></td><td class=\"chart_data\">$avg_call_time</td>\n";
            echo "    <td></td>\n";
            echo "    <td></td>\n";
            echo "  </tr>\n";
        }
        echo "</table>";
    }
}

if ( isset($_POST['need_chart_cc']) && $_POST['need_chart_cc'] == 'true' ) {
    $date_range = "( (calldate BETWEEN $startdate AND $enddate) or (calldate + interval duration second  BETWEEN $startdate AND $enddate) or ( calldate + interval duration second >= $enddate AND calldate <= $startdate ) )";
    $where = "WHERE $date_range $cnum $outbound_cnum $cnam $dst_cnam $did $dst $userfield $accountcode $disposition $duration";

    $tot_calls = 0;
    $max_calls = 0;
    $result_array_cc = array();
    $result_array = array();
    if ( strpos($group_by_field,'DATE_FORMAT') === false ) {
        /* not date time fields */
        $query3 = "SELECT $group_by_field AS group_by_field, count(*) AS total_calls, unix_timestamp(calldate) AS ts, duration FROM $db_name.$db_table_name $where GROUP BY group_by_field, unix_timestamp(calldate) ORDER BY group_by_field ASC LIMIT $result_limit";
        $result3 = $dbcdr->getAll($query3, DB_FETCHMODE_ASSOC);
        $group_by_str = '';
        foreach($result3 as $row) {
            if ( $group_by_str != $row['group_by_field'] ) {
                $group_by_str = $row['group_by_field'];
                $result_array = array();
            }
            for ( $i=$row['ts']; $i<=$row['ts']+$row['duration']; ++$i ) {
                if ( isset($result_array[ "$i" ]) ) {
                    $result_array[ "$i" ] += $row['total_calls'];
                } else {
                    $result_array[ "$i" ] = $row['total_calls'];
                }
                if ( $max_calls < $result_array[ "$i" ] ) {
                    $max_calls = $result_array[ "$i" ];
                }
                if ( ! isset($result_array_cc[ $row['group_by_field'] ]) || $result_array_cc[ $row['group_by_field'] ][1] < $result_array[ "$i" ] ) {
                    $result_array_cc[$row['group_by_field']][0] = $i;
                    $result_array_cc[$row['group_by_field']][1] = $result_array[ "$i" ];
                }
            }
            $tot_calls += $row['total_calls'];
        }
    } else {
        /* data fields */
        $query3 = "SELECT unix_timestamp(calldate) AS ts, duration FROM $db_name.$db_table_name $where ORDER BY unix_timestamp(calldate) ASC LIMIT $result_limit";
        $result3 = $dbcdr->getAll($query3, DB_FETCHMODE_ASSOC);
        $group_by_str = '';
        foreach($result3 as $row) {
            $group_by_str_cur = substr(strftime($group_by_field_php[0],$row['ts']),0,$group_by_field_php[1]) . $group_by_field_php[2];
            if ( $group_by_str_cur != $group_by_str ) {
                if ( $group_by_str ) {
                    for ( $i=$start_timestamp; $i<$row['ts']; ++$i ) {
                        if ( ! isset($result_array_cc[ "$group_by_str" ]) || ( isset($result_array["$i"]) && $result_array_cc[ "$group_by_str" ][1] < $result_array["$i"] ) ) {
                            $result_array_cc[ "$group_by_str" ][0] = $i;
                            $result_array_cc[ "$group_by_str" ][1] = isset($result_array["$i"]) ? $result_array["$i"] : 0;
                        }
                        unset( $result_array[$i] );
                    }
                    $start_timestamp = $row['ts'];
                }
                $group_by_str = $group_by_str_cur;
            }
            for ( $i=$row['ts']; $i<=$row['ts']+$row['duration']; ++$i ) {
                if ( isset($result_array["$i"]) ) {
                    ++$result_array["$i"];
                } else {
                    $result_array["$i"]=1;
                }
                if ( $max_calls < $result_array["$i"] ) {
                    $max_calls = $result_array["$i"];
                }
            }
            $tot_calls++;
        }
        for ( $i=$start_timestamp; $i<=$end_timestamp; ++$i ) {
            $group_by_str = substr(strftime($group_by_field_php[0],$i),0,$group_by_field_php[1]) . $group_by_field_php[2];
            if ( ! isset($result_array_cc[ "$group_by_str" ]) || ( isset($result_array["$i"]) && $result_array_cc[ "$group_by_str" ][1] < $result_array["$i"] ) ) {
                $result_array_cc[ "$group_by_str" ][0] = $i;
                $result_array_cc[ "$group_by_str" ][1] = isset($result_array["$i"]) ? $result_array["$i"] : 0;
            }
        }
    }
    if ( $tot_calls ) {
        $html = "<p class=\"center title\">"._("Call Detail Record - Concurrent Calls by")." ".$graph_col_title."</p><table class=\"cdr\">";
        $html .= "<tr><th class=\"end_col\">". $graph_col_title . "</th>";
        $html .= "<th class=\"center_col\">"._("Total Calls").": ". $tot_calls ." / "._("Max Calls").": ". $max_calls ."</th>";
        $html .= "<th class=\"end_col\">"._("Time")."</th>";
        $html .= "</tr>";
        echo $html;

        ksort($result_array_cc);

        foreach ( array_keys($result_array_cc) as $group_by_key ) {
            $full_time = strftime( '%Y-%m-%d %H:%M:%S', $result_array_cc[ "$group_by_key" ][0] );
            $group_by_cur = $result_array_cc[ "$group_by_key" ][1];
            $bar_calls = $group_by_cur/$max_calls*100;
            echo "  <tr>\n";
            echo "    <td class=\"end_col\">$group_by_key</td><td class=\"center_col\"><div class=\"bar_calls\" style=\"width : $bar_calls%\">&nbsp;$group_by_cur</div></td><td>$full_time</td>\n";
            echo "  </tr>\n";
        }

        echo "</table>";
    }
}


/* CDR Table Display Functions */
function cdr_formatCallDate($calldate) {
    return $calldate;
}

function cdr_formatUniqueID($uniqueid) {
    global $amp_conf;

    $system = explode('-', $uniqueid, 2);
    if ($amp_conf['CEL_ENABLED']) {
        $href=$_SERVER['SCRIPT_NAME']."?display=cdr&action=cel_show&uid=" . urlencode($uniqueid);
        return $system[0];
    } else {
        return  $system[0];
    }
}

function cdr_formatChannel($channel) {
    $chan_type = explode('/', $channel, 2);
    return $chan_type[0];
}

function cdr_formatSrc($src, $clid) {
    if (empty($src)) {
        return "UNKNOWN";
    } else {
        $clid = htmlspecialchars($clid);
        return $src;
    }
}

function cdr_formatCallerID($cnam, $cnum, $channel) {
    $dcnum = $cnum == '' && $cnam == '' ? '' : htmlspecialchars('<' . $cnum . '>');
    $dcnam = htmlspecialchars($cnam == '' ? '' : '"' . $cnam . ' "');
    return $dcnam . $dcnum;
}

function cdr_formatDID($did) {
    $did = htmlspecialchars($did);
    return $did;
}

function cdr_formatANI($ani) {
    $ani = htmlspecialchars($ani);
    return $ani;
}

function cdr_formatApp($app, $lastdata) {
    $app = htmlspecialchars($app);
    $lastdata = htmlspecialchars($lastdata);
    return $app;
}

function cdr_formatDst($dst, $dst_cnam, $channel, $dcontext) {
    if ($dst == 's') {
        $dst .= ' [' . $dcontext . ']';
    }
    if ($dst_cnam != '') {
        $dst = '"' . $dst_cnam . '" ' . $dst;
    }
    return $dst;
}

function cdr_formatDisposition($disposition, $amaflags) {
    switch ($amaflags) {
        case 0:
            $amaflags = 'DOCUMENTATION';
            break;
        case 1:
            $amaflags = 'IGNORE';
            break;
        case 2:
            $amaflags = 'BILLING';
            break;
        case 3:
        default:
            $amaflags = 'DEFAULT';
    }
    return $disposition;
}

function cdr_formatDuration($duration, $billsec) {
    $duration = sprintf('%02d', intval($duration/60)).':'.sprintf('%02d', intval($duration%60));
    $billduration = sprintf('%02d', intval($billsec/60)).':'.sprintf('%02d', intval($billsec%60));
    return $duration;
}

function cdr_formatUserField($userfield) {
    $userfield = htmlspecialchars($userfield);
    return $userfield;
}

function cdr_formatAccountCode($accountcode) {
    $accountcode = htmlspecialchars($accountcode);
    return $accountcode;
}

function cdr_formatRecordingFile($recordingfile, $basename, $id, $uid) {

    global $REC_CRYPT_PASSWORD;

    if ($recordingfile) {
        $crypt = new Crypt();
        // Encrypt the complete file
        $audio = urlencode($crypt->encrypt($recordingfile, $REC_CRYPT_PASSWORD));
        $recurl=$_SERVER['SCRIPT_NAME']."?display=cdr&action=cdr_play&recordingpath=$audio";
        $download_url=$_SERVER['SCRIPT_NAME']."?display=cdr&action=download_audio&cdr_file=$uid";
        $playbackRow = $id +1;
        //
        return "<td title=\"$basename\"><a href=\"#\" onClick=\"javascript:cdr_play($playbackRow,'$recurl'); return false;\">
              <img src=\"assets/cdr/images/cdr_sound.png\" alt=\"Call recording\" /></a>
		      <a href=\"$download_url\"><img src=\"assets/cdr/images/cdr_download.png\" alt=\"Call recording\" /></a></td>";

    } else {
        return "";
    }
}

function cdr_formatCNAM($cnam) {
    $cnam = htmlspecialchars($cnam);
    return $cnam;
}

function cdr_formatCNUM($cnum) {
    $cnum = htmlspecialchars($cnum);
    return $cnum;
}

function cdr_formatExten($exten) {
    $exten = htmlspecialchars($exten);
    return $exten;
}

function cdr_formatContext($context) {
    $context = htmlspecialchars($context);
    return $context;
}

function cdr_formatAMAFlags($amaflags) {
    switch ($amaflags) {
        case 0:
            $amaflags = 'DOCUMENTATION';
            break;
        case 1:
            $amaflags = 'IGNORE';
            break;
        case 2:
            $amaflags = 'BILLING';
            break;
        case 3:
        default:
            $amaflags = 'DEFAULT';
    }
    return $amaflags;
}

// CEL Specific Formating:
//

function cdr_cel_formatEventType($eventtype) {
    $eventtype = htmlspecialchars($eventtype);
    return $eventtype;
}

function cdr_cel_formatUserDefType($userdeftype) {
    $userdeftype = htmlspecialchars($userdeftype);
    return $userdeftype;
}

function cdr_cel_formatEventExtra($eventextra) {
    $eventextra = htmlspecialchars($eventextra);
    return $eventextra;
}

function cdr_cel_formatChannelName($channel) {
    $chan_type = explode('/', $channel, 2);
    $type = htmlspecialchars($chan_type[0]);
    $channel = htmlspecialchars($channel);
    return $channel;
}
