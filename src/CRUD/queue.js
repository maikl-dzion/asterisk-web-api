
const QueueUpdate = {

    install(Vue, options) {

        Vue.mixin({

            data: function() {

                var editQueueModel = {

                    "account"  : "" ,
                    "name"     : "" ,

                    "strategy" : "ringall" ,
                    "timeout"  : "15" ,

                    "password" : "5" ,
                    "callconfirm_id" : "None" ,
                    "prefix" : "" ,
                    "queuewait" : "0" ,
                    "alertinfo" : "" ,
                    "members" : "" ,
                    "dynmembers" : "" ,
                    "dynmemberonly" : "no" ,
                    "use_queue_context" : "0" ,
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
                    "goto0" : "Терминировать_звонок" ,
                    "Терминировать_звонок0" : "app-blackhole,hangup,1" ,
                    "cron_schedule" : "never" ,

                    "display" : "queues" ,
                    "action"  : "edit" ,
                    "Submit"  : "Применить изменения" ,
                };

                return {

                    editQueueModel,

                    strategyCalls : [
                        { name : 'ringall',     title : 'звонят-все' },
                        { name : 'leastrecent', title : 'самому-незанятому' },
                        { name : 'fewestcalls', title : 'менее-организованному' },
                        { name : 'random',      title : 'случайный-выбор' },
                        { name : 'rrmemory',    title : 'rrmemory' },
                        { name : 'rrordered',   title : 'rrordered' },
                        { name : 'linear',      title : 'линейное' },
                        { name : 'wrandom',     title : 'случайный-выбор' },
                    ],

                    cwIgnore : [
                        { val : 0, label : 'Нет' },
                        { val : 1, label : 'Да' },
                        { val : 2, label : 'Да + (ringinuse=no)' },
                        { val : 3, label : 'Только звонки очереди (ringinuse=no)' },
                    ],

                }
            },

            methods: {

                deleteQueue(item, params) {
                    var num = item[params.auto];
                    var postData = {
                        display : 'queues',
                        action  : 'delete',
                        account : num,
                    };
                    return postData;
                },

                // --- ПРОВЕРКА НОМЕРА
                checkNewQueueAccount(fieldName) {

                    var newItemNum = this.item[fieldName];
                    if(!newItemNum) return false;

                    this.getExtMap(resp => {
                        var res = this.findExtMap(newItemNum);
                        if(res.find) {
                            var fValue = res.value;
                            fValue = 'Этот номер "' +newItemNum+ '" уже используется,выберите другой номер! <br> (' +fValue+ ')';
                            infoPanelRun([fValue], 'error', { 'time' : 4000});
                            this.item[fieldName] = '';
                        }
                    });
                },

                // --- ФОРМИРОВАНИЕ НОВОЙ ОЧЕРЕДИ
                setNewQueueItem(params) {
                    this.getExtMap(resp => {
                        this.getItemsDataController('getQueuesList').then(itemsList => {

                            var newItemNum = 301;
                            var res = this.getNewItemExtension(newItemNum, params, itemsList);
                            this.item['account'] = res.newItemNum;
                            this.item['name'] = 'queue-' + res.len;

                        });
                    });
                },

                getPbxItemQueue(itemId = 0) {
                    var url = 'extdisplay=' + itemId;
                    return this._getPbxConfigInit('queues', url);
                },

                // --- ФОРМИРУЕМ ПОЛЯ ДЛЯ РЕДАКТИРОВАНИЯ
                queueFieldsFormatted(data) {

                    // lg(data);  return false;
                    // var extension = data['extension'];
                    // this.getPbxItemQueue(extension).then(info => {
                         // lg(info);
                    // });

                    var item = Object.assign({}, this.editQueueModel);

                    for(var fieldName in data) {

                        switch (fieldName) {
                            case 'extension' :
                                item['account'] = data[fieldName];
                                break;

                            case 'descr' :
                                item['name'] = data[fieldName];
                                break;

                            // case 'dest' : item['Терминировать_звонок0'] = data[fieldName]; break;

                            case 'ext_numbers' :
                                item['members'] = data[fieldName];
                                break;

                            default :
                                if(fieldName in item)
                                    item[fieldName] = data[fieldName];
                                break;
                        }
                    }

                    return item;
                },


                // -- ОБНОВЛЕНИЕ СВЯЗИ
                queueLinkUpdate(sourceData, targetData, extNum) {

                    var savePermit = false;
                    var params     = this.queueParams;
                    extNum = parseInt(extNum) - 1;

                    var sourceItemId = sourceData.id;
                    var item = this.searchArr(this.queues, params.uid, sourceItemId);

                    // --- кого подключаем
                    var targetItemId = targetData.id;
                    var targetItemType = targetData.type;

                    // --- список елементов
                    var listArr = item.ext_numbers;

                    var prefix    = ',0';

                    switch(targetItemType){
                        case 'user'   :
                        case 'ivr'    :
                        case 'group'  :
                        case 'queque' :
                            savePermit = true;
                            break;
                    }

                    if(!savePermit) return false;

                    //--- прозводим поверку на наличие в массиве
                    var delIndex = -1;
                    for(var i in listArr) {
                        if(listArr[i] == targetItemId + prefix) {
                             delIndex = i;
                             if(i == extNum) return false;
                        }
                    }


                    listArr[extNum] = targetItemId + prefix;
                    if(delIndex != -1) delete listArr[delIndex];

                    item.ext_numbers = listArr;

                    this.editItemLink(item, params);
                },

                // -- УДАЛЕНИЕ СВЯЗИ
                queueLinkDelete(sourceData, targetData, extNum) {
                    var params     = this.queueParams;
                    extNum         = parseInt(extNum) - 1;
                    var item = this.searchArr(this.queues, params.uid, sourceData.id);

                    delete item.ext_numbers[extNum];
                    this.editItemLink(item, params);
                },

            }
        })

    } //  Install
};


