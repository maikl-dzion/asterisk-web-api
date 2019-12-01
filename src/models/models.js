
const extensionFields = {
    "display": "extensions",
    "type": "",
    "action": "add",
    "extdisplay": "",
    "extension": "",
    "name": "",
    "cid_masquerade": "",
    "sipname": "",
    "outboundcid": "",
    "ringtimer": "0",
    "cfringtimer": "0",
    "concurrency_limit": "0",
    "callwaiting": "disabled",
    "answermode": "disabled",
    "call_screen": "0",
    "pinless": "disabled",
    "emergency_cid": "",
    "tech": "sip",
    "hardware": "generic",
    "newdid_name": "",
    "newdid": "",
    "newdidcid": "",
    "devinfo_secret_origional": "",
    //"devinfo_secret": "1949a33ab188f749dfdda3b3aa75e798",
    //"devinfo_dtmfmode": "rfc2833",
    "devinfo_secret": "",
    "devinfo_dtmfmode": "rfc2833",
    "devinfo_canreinvite": "no",
    "devinfo_context": "from-internal",
    "devinfo_host": "dynamic",
    "devinfo_trustrpid": "yes",
    "devinfo_sendrpid": "no",
    "devinfo_type": "friend",
    "devinfo_nat": "no",
    "devinfo_port": "5060",
    "devinfo_qualify": "yes",
    "devinfo_qualifyfreq": "60",
    "devinfo_transport": "udp",
    "devinfo_avpf": "no",
    "devinfo_icesupport": "no",
    "devinfo_dtlsenable": "no",
    "devinfo_dtlsverify": "no",
    "devinfo_dtlssetup": "actpass",
    "devinfo_dtlscertfile": "",
    "devinfo_dtlsprivatekey": "",
    "devinfo_encryption": "no",
    "devinfo_callgroup": "",
    "devinfo_pickupgroup": "",
    "devinfo_disallow": "",
    "devinfo_allow": "",
    "devinfo_dial": "",
    "devinfo_accountcode": "",
    "devinfo_mailbox": "",
    "devinfo_vmexten": "",
    "devinfo_deny": "0.0.0.0\/0.0.0.0",
    "devinfo_permit": "0.0.0.0\/0.0.0.0",
    "noanswer_dest": "goto0",
    "busy_dest": "goto1",
    "chanunavail_dest": "goto2",
    "qnostate": "usestate",
    "vm": "disabled",
    "recording_in_external": "recording_in_external=dontcare",
    "recording_out_external": "recording_out_external=dontcare",
    "recording_in_internal": "recording_in_internal=dontcare",
    "recording_out_internal": "recording_out_internal=dontcare",
    "recording_ondemand": "recording_ondemand=disabled",
    "recording_priority": "10",
    "dictenabled": "disabled",
    "dictformat": "ogg",
    "dictemail": "",
    "langcode": "",
    "goto0": "",
    "noanswer_cid": "",
    "goto1": "",
    "busy_cid": "",
    "goto2": "",
    "chanunavail_cid": "",
    "Submit": "Сохранить",
    // "request_api_alliance" : true, // --ПЕРЕМЕННАЯ ДЛЯ ОБРАЩЕНИЯ к FreePBX
};





const followMeModelFields = {

    "display" : "findmefollow" ,
    "action" : "edtGRP" ,
    "account" : "50" ,
    "ddial_value" : "" ,
    "pre_ring" : "0" ,
    "strategy" : "ringallv2" ,
    "grptime" : "20" ,
    "grplist" : "54" ,
    "annmsg_id" : "" ,
    "ringing" : "Ring" ,
    "grppre" : "" ,
    "dring" : "" ,
    "remotealert_id" : "" ,
    "toolate_id" : "" ,
    "changecid" : "default" ,
    "goto0" : "Follow_Me" ,
    "Follow_Me0" : "ext-local,50,dest" ,
    "Submit" : "Применить изменения" ,

}


const _trunkSecret = 'JVbgf2z7v8';
const _trunkHost   = 'sip.zadarma.com';
const _trunkDefaultName = '7-495-975-98-46-test';
const _trunkUserContext = '579659';

const peerDetails = {

    'secret'     : _trunkSecret,
    'fromuser'   : '',
    'defaultuser': '',

    'host'       : _trunkHost,
    'fromdomain' : _trunkHost,

    'type'       : 'friend',
    'insecure'   : 'invite,port',
    'dtmfmode'   : 'auto',
    'disallow'   : 'all',
    'allow'      : 'alaw&ulaw',
    'directmedia': 'yes',
    'qualify'    : 'yes&no',
    'allowguest' : 'no',
    'nat' : 'no',
    'allowexternalinvites' : 'no',
    'alwaysauthreject' : 'yes',
};


const trunkModelFields = {

    "trunk_name"     : _trunkDefaultName,
    "sv_channelid"   : "",
    "channelid"      : "",
    "outcid"         : "",

    "usercontext"    : _trunkUserContext,
    "sv_usercontext" : "",

    "display"        : "trunks",
    "extdisplay"     : "",
    "action"         : "addtrunk",

    "tech"           : "sip",
    "provider"       : "",
    "sv_trunk_name"  : "",
    "sv_usercontext" : "",
    "npanxx"         : "",
    "keepcid"        : "off",
    "maxchans"       : "",
    "prepend_digit"  : [],
    "pattern_prefix" : [],
    "pattern_pass"   : [],
    "autopop"        : "",
    "dialoutprefix"  : "",
    "peerdetails"    : Object.assign({}, peerDetails),
    "userconfig"     : Object.assign({}, peerDetails),
    "register"       : "",
    "Submit"         : "Сохранить изменения",

};


// var peerDetails = {
//     'type'       : 'friend',
//     'secret'     : 'JVbgf2z7v8',
//     'insecure'   :'invite,port',
//     'host'       : 'sip.zadarma.com',
//     'fromuser'   : '579659',
//     'fromdomain' : 'sip.zadarma.com',
//     'dtmfmode'   : 'auto',
//     'disallow'   : 'all',
//     'defaultuser': '579659',
//     'allow'      : 'alaw&ulaw',
//     'directmedia': 'yes',
//     'qualify'    : 'no',
//     'allowguest' : 'no',
//     'alwaysauthreject' : 'yes',
// };
//
// var trunkModelFields = {
//
//     "display"        : "trunks",
//     "extdisplay"     : "OUT_5",
//     "action"         : "edittrunk",
//     "tech"           : "sip",
//     "provider"       : "",
//     "sv_trunk_name"  : "",
//     "sv_usercontext" : "579659",
//     "sv_channelid"   : "7-495-975-98-46",
//     "npanxx"         : "",
//     "trunk_name"     : "7-495-975-98-46",
//     "outcid"         : "7-495-975-98-46",
//     "keepcid"        : "off",
//     "maxchans"       : "",
//     "prepend_digit"  : [],
//     "pattern_prefix" : [],
//     "pattern_pass"   : [],
//     "autopop"        : "",
//     "dialoutprefix"  : "",
//     "channelid"      : "7-495-975-98-46",
//     "peerdetails"    : peerDetails ,
//     "usercontext"    : "579659",
//     "userconfig"     : peerDetails,
//     "register"       : "579659:JVbgf2z7v8@sip.zadarma.com/579659",
//     "Submit"         : "Сохранить изменения",
//
// };


const queueModelFields = {

    "display" : "queues" ,
    "action" : "add" ,
    "account" : "0" ,
    "name" : "df" ,
    "password" : "" ,
    "callconfirm_id" : "None" ,
    "prefix" : "" ,
    "queuewait" : "0" ,
    "alertinfo" : "" ,
    "members" : "" ,
    "dynmembers" : "" ,
    "dynmemberonly" : "no" ,
    "use_queue_context" : "0" ,
    "strategy" : "ringall" ,
    "cwignore" : "0" ,
    "weight" : "0" ,
    "music" : "inherit" ,
    "rtone" : "0" ,
    "joinannounce_id" : "None" ,
    "skip_joinannounce" : "" ,
    "monitor-format" : "" ,
    "monitor_type" : "" ,
    "monitor_heard" : "0" ,
    "monitor_spoken" : "0" ,
    "maxwait" : "" ,
    "timeoutpriority" : "app" ,
    "timeout" : "15" ,
    "timeoutrestart" : "no" ,
    "retry" : "5" ,
    "wrapuptime" : "0" ,
    "memberdelay" : "0" ,
    "agentannounce_id" : "" ,
    "reportholdtime" : "no" ,
    "autopause" : "no" ,
    "autopausebusy" : "no" ,
    "autopauseunavail" : "no" ,
    "autopausedelay" : "0" ,
    "maxlen" : "0" ,
    "joinempty" : "yes" ,
    "leavewhenempty" : "no" ,
    "penaltymemberslimit" : "0" ,
    "announcefreq" : "0" ,
    "announceposition" : "no" ,
    "announceholdtime" : "no" ,
    "breakouttype" : "announcemenu" ,
    "announcemenu" : "none" ,
    "callback" : "none" ,
    "pannouncefreq" : "0" ,
    "eventwhencalled" : "no" ,
    "eventmemberstatus" : "no" ,
    "servicelevel" : "60" ,
    "qregex" : "" ,
    "goto0" : "" ,
    "goto0" : "Терминировать_звонок",
    "Терминировать_звонок0" : "app-blackhole,hangup,1",
    "cron_schedule" : "never" ,
    "Submit" : "Применить изменения" ,

};

const groupModelFields = {
    "display"   : "ringgroups" ,
    "action"    : "addGRP" ,
    "account"   : "600" ,
    "description" : "groups 2" ,
    "strategy"   : "ringall" ,
    "grptime"    : "20" ,
    "grplist"    : "" ,
    "annmsg_id"  : "" ,
    "ringing"    : "Ring" ,
    "grppre"     : "" ,
    "alertinfo"  : "" ,
    "remotealert_id" : "" ,
    "toolate_id" : "" ,
    "changecid"  : "default" ,
    "recording"  : "always" ,
    "goto0"      : "Терминировать_звонок" ,
    "Терминировать_звонок0" : "app-blackhole,hangup,1" ,
    "Submit"     : "Применить изменения" ,
};


// Array
// (
//     [display] => ringgroups
//     [action] => edtGRP
//     [account] => 601
//     [description] => Админы
//     [strategy] => ringall
//     [grptime] => 20
//     [grplist] => 30 31
//     [annmsg_id] =>
//     [ringing] => Ring
//     [grppre] =>
//     [alertinfo] =>
//     [remotealert_id] =>
//     [toolate_id] =>
//     [changecid] => default
//     [recording] => always
//     [goto0] => Терминировать_звонок
//     [Терминировать_звонок0] => app-blackhole,hangup,1
//     [Submit] => Применить изменения
// )


// var groupModelFields = {
//     "display" : "ringgroups" ,
//     "action" : "addGRP" ,
//     "account" : "601" ,
//     "description" : "groups 2" ,
//     "strategy" : "ringall" ,
//     "grptime" : "20" ,
//     "grplist" : "33" ,
//     "annmsg_id" : "" ,
//     "ringing" : "Ring" ,
//     "grppre" : "" ,
//     "alertinfo" : "" ,
//     "remotealert_id" : "" ,
//     "toolate_id" : "" ,
//     "changecid" : "default" ,
//     "recording" : "always" ,
//     "goto0" : "Терминировать_звонок" ,
//     "Терминировать_звонок0" : "app-blackhole,hangup,1" ,
//     "Submit" : "Применить изменения" ,
// };


const didModelFields = {

    "display" : "did" ,
    "action" : "addIncoming" ,
    "extdisplay" : "" ,
    "didfilter" : "" ,
    "rnavsort" : "description" ,
    "description" : "7-495-975-98-46" ,
    "extension" : "579659" ,
    "cidnum" : "" ,
    "alertinfo" : "" ,
    "grppre" : "" ,
    "mohclass" : "default" ,
    "delay_answer" : "" ,
    "privacyman" : "0" ,
    "pmmaxretries" : "3" ,
    "pmminlength" : "10" ,
    "callrecording" : "" ,
    "cidlookup_id" : "0" ,
    "faxenabled" : "false" ,
    "faxdetection" : "dahdi" ,
    "faxdetectionwait" : "4" ,
    "gotoFAX" : "" ,
    "language" : "" ,
    "goto0" : "" ,
    // "Extensions0" : "from-did-direct,33,1" ,
    "Submit" : "Submit" ,

};



// var didModelFields = {
//
//     "display" : "did" ,
//     "action" : "addIncoming" ,
//     "extdisplay" : "" ,
//     "didfilter" : "" ,
//     "rnavsort" : "description" ,
//     "description" : "6778888" ,
//     "extension" : "12455" ,
//     "cidnum" : "" ,
//     "alertinfo" : "" ,
//     "grppre" : "" ,
//     "mohclass" : "default" ,
//     "delay_answer" : "" ,
//     "privacyman" : "0" ,
//     "pmmaxretries" : "3" ,
//     "pmminlength" : "10" ,
//     "callrecording" : "" ,
//     "cidlookup_id" : "0" ,
//     "faxenabled" : "false" ,
//     "faxdetection" : "dahdi" ,
//     "faxdetectionwait" : "4" ,
//     "gotoFAX" : "" ,
//     "language" : "" ,
//     "goto0" : "Extensions" ,
//     "Extensions0" : "from-did-direct,32,1" ,
//     "Submit" : "Submit" ,
//
// };



//--- ИСХОДЯЩИЙ МАРШРУТ

const outRouteModelFields = {

    "display" : "routing" ,
    "extdisplay" : "" ,
    "action" : "addroute" ,
    "repotrunkdirection" : "" ,
    "repotrunkkey" : "" ,
    "reporoutedirection" : "" ,
    "reporoutekey" : "" ,
    "routename" : "" ,
    "outcid" : "" ,
    "routepass" : "" ,
    "mohsilence" : "default" ,
    "time_group_id" : "" ,
    "route_seq" : "bottom" ,
    "callrecording" : "" ,
    "pinsets" : "" ,
    "prepend_digit"  : [7, 7] ,
    "pattern_prefix" : [7, 8] ,
    "pattern_pass"   : ['XXXXXXXXXX', 'XXXXXXXXXX'] ,
    "match_cid"      : ['', ''] ,
    "npanxx" : "" ,
    "trunkpriority" : ['', '', ''] ,
    "goto0" : "" ,
    "Submit" : "Сохранить изменения" ,

};


const customContextModelFileds = {

    'display' : 'customcontexts',
    'type' : '',
    'action' : 'add',
    'extdisplay'  : '',
    'description' : '',
    'Submit' : 'Сохранить',

}



// var outRouteModelFields = {
//
//     "display" : "routing" ,
//     "extdisplay" : "" ,
//     "action" : "addroute" ,
//     "repotrunkdirection" : "" ,
//     "repotrunkkey" : "" ,
//     "reporoutedirection" : "" ,
//     "reporoutekey" : "" ,
//     "routename" : "2345666" ,
//     "outcid" : "33" ,
//     "routepass" : "" ,
//     "mohsilence" : "default" ,
//     "time_group_id" : "" ,
//     "route_seq" : "bottom" ,
//     "callrecording" : "" ,
//     "pinsets" : "" ,
//     "prepend_digit" : {} ,
//     "pattern_prefix" : {} ,
//     "pattern_pass" : {} ,
//     "match_cid" : {} ,
//     "npanxx" : "" ,
//     "trunkpriority" : {} ,
//     "goto0" : "" ,
//     "Submit" : "Сохранить изменения" ,
//
// };



const ivrModelFields = {
    "display" : "ivr" ,
    "type" : "setup" ,
    "invalid_destination" : "app-blackhole,hangup,1" ,
    "timeout_destination" : "app-blackhole,hangup,1" ,
    "announcement" : "" ,
    "directdial" : "" ,
    "timeout_time" : "10" ,
    "invalid_loops" : "3" ,
    "invalid_retry_recording" : "default" ,
    "invalid_recording" : "default" ,
    "timeout_loops" : "3" ,
    "timeout_retry_recording" : "default" ,
    "timeout_recording" : "default" ,
    "id" : "" ,
    "action" : "save" ,
    "name" : "ivr-name" ,
    "description" : "ivr-desc" ,
    // "entries" : {
    //     ext     : [],  // [0] => 1
    //     goto    : [],  // [0] => ext-queues,312,1
    //     ivr_ret : [],  // [0] => uncheked
    // } ,
    "Submit" : "Submit" ,
};
