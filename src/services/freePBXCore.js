
var FreePBXCore = {

    data: function() {
        return {

            userInfo : '',

            coreInfo: {},
            coreItem: {},

            users    : [],
            trunks   : [],
            didRoutes: [],
            outRoutes: [],
            customContexts: [],
            customContextList: [],
            ringGroups    : [],
            devices       : [],
            sip           : [],
            queues        : [],
            ivrItems      : [],
            findmefollow  : [],
            soundRecordList : [],

            objectsBundleArch : {},

            extMap : [],
            frameworkUsage : [],

            trunkParams : {
                header    : 'Внешние номера',
                title     : 'Внешний номер',
                uid       : 'trunkid',
                iconClass : 'atc-icon-trunks',
                typeName  : 'trunk',
                num       : 'usercontext',

                auto      : 'trunkid',
                name      : 'name',
                desc      : 'name',
                type      : 'trunk',
                list      : '',
            },

            groupParams : {
                header    : 'Группы',
                title     : 'Группа',
                uid       : 'grpnum',
                iconClass : 'atc-icon-groups',
                typeName  : 'group',
                num       : 'grpnum',

                auto      : 'grpnum',
                name      : 'description',
                desc      : 'description',
                type      : 'group',
                list      : 'grplist',
            },

            queueParams : {
                header    : 'Очереди',
                title     : 'Очередь',
                uid       : 'extension',
                iconClass : 'atc-icon-queues',
                typeName  : 'queue',
                num       : 'extension',

                auto      : 'extension',
                name      : 'descr',
                desc      : 'descr',
                type      : 'queue',
                list      : '',
            },

            userParams : {
                header    : 'Внутрение номера',
                title     : 'Внутрений номер',
                uid       : 'extension',
                iconClass : 'atc-icon-users',
                typeName  : 'user',
                num       : 'extension',

                auto      : 'extension',
                name      : 'name',
                desc      : 'name',
                type      : 'user',
                list      : '',
            },

            ivrParams : {
                header    : 'Голосовое меню',
                title     : 'Голосовое меню',
                uid       : 'id',
                iconClass : 'atc-icon-ivr',
                typeName  : 'ivr',
                num       : 'id',

                auto      : 'id',
                name      : 'description',
                desc      : 'description',
                type      : 'ivr',
                list      : '',
            },

        }
    },

    //created: function () {
        //this.getCoreSettings();
    //},

    methods: {

        // --------------------------
        // --- ЗАГРУЗКА МОДЕЛЕЙ -----

        // -- следуй за мной
        getFollowMeModel() {
            return followMeModelFields;
        },

        // --  пользователь (extension)
        getUserModel() {
            return extensionFields;
        },

        // -- группа
        getGroupModel() {
            return groupModelFields;
        },

        // -- Внешние номера
        getTrunkModel() {
            return trunkModelFields;
        },

        // -- голосовое меню
        getIvrModel() {
            return ivrModelFields;
        },

        // -- очереди
        getQueueModel() {
            return queueModelFields;
        },

        // -- исходящий маршрут
        getOutRouteModel() {
            return outRouteModelFields;
        },

        // -- custom context
        getCustomContextModel() {
            return customContextModelFileds;
        },

        getDidRouteModelFields() {
            return didModelFields;
        },

        // --------------------------
        // -- ПОЛУЧЕНИЕ ДАННЫХ ------
        getCoreInfo(callback) {
            // this.httpRun('api/GetCoreInfo', this.responseCoreInfo);
            var url = localApiUrl + 'index.php?action=getCoreInfo';
            if(!callback)
               this.httpRun(url, this.responseCoreInfo);
            else
                this.httpRun(url, callback);
        },

        responseCoreInfo(response) {
            this.coreInfo = response;
        },

        getCoreItem(fieldName) {
            var item = {};
            if(this.coreInfo[fieldName]) {
                item = this.coreInfo[fieldName];
            }
            return item;
        },

        cdrDataController(funcName) {
            var url = 'action=CdrDataController&funcName=' + funcName;
            return this.send('get', url, {}, 'local');
        },

        getItemsDataController(funcName, args = '') {
            if(args) args = '&' +args;
            var url = 'action=ComponentsDataController&funcName=' + funcName + args;
            return this.send('get', url, {}, 'local');
        },

        getOutRoutes(cb = null, args = '') {
            this.getItemsDataController('getOutRoutes', args).then(resp => {
                this.outRoutes = resp;
                if(cb) cb(resp);
            });
        },

        getDidRoutes(cb = null, args = '') {
            this.getItemsDataController('getDidRoutes', args).then(resp => {
                this.didRoutes = resp;
                if(cb) cb(resp);
            });
        },

        getCustomContextList(cb = null, args = '') {
            this.getItemsDataController('getCustomContextList', args).then(resp => {
                this.customContextList = resp;
                this.customContexts    = resp;
                if(cb) cb(resp);
            });
        },

        getUsersList(cb = null, args = '') {
            this.getItemsDataController('getUsersList', args).then(resp => {
                this.users = resp;
                if(cb) cb(resp);
            });
        },

        getSoundRecordList(cb = null, args = '') {
            this.getItemsDataController('getSoundRecordList', args).then(resp => {
                this.soundRecordList = resp;
                if(cb) cb(resp);
            });
        },

        getUserInfo(extension = 0, type = 'edit', cb = null) {
            var args = 'extension=' + extension + '&type=' + type;
            if(!cb) return this.getItemsDataController('getUserInfo', args);

            this.getItemsDataController('getUserInfo', args).then(resp => {
                this.userInfo = resp;
                if(cb) cb(resp);
            });
        },

        getUserRecordInfo(extension = 0, type = '') {
            var args = 'action=getUserRecordInfo&display=extensions&extdisplay=' + extension + '&type=' + type;
            return this.send('get', args, null);
        },

        getAsteriskConf() {
            var args = 'action=_getAsteriskConf&rest_full_api=1';
            return this.send('get', args, null);
        },

        //#########################
        // ------------------------
        _getPbxConfigInit(display = '', args = '', method = 'get', getUrl = false) {
            if(display) display = '&display=' + display;
            if(args)    args = '&' + args;
            var url = 'get_free_pbx_config_load=1' + display + args;
            if(getUrl) return url;
            return this.send(method, url, null, 'local');
        },

        getPbxExtensions(itemId = 0) {
            var url = 'type=&extdisplay=' + itemId;
            return this._getPbxConfigInit('extensions', url);
        },

        getAsteriskCliCommand(command = '') {
            var url = 'type=tool&cli_command_text=' + command;
            return this._getPbxConfigInit('cli', url);
        },

        getPbxCdrReports(itemId = 0) {
            var url = '';
            return this._getPbxConfigInit('cdr', url);
        },
        //---------------------------
        //###########################

        groupItemList(item, list = null) {
            var result = [];
            var itemList = [];
            if(!list) {
                itemList = item.grplist.split('-');
                for (var i in itemList) {
                    var listId = this.typeOfDigit(itemList[i]);
                    var _type   = '';
                    var obj = {
                        id : listId,
                        prefix : itemList[i],
                        type   : _type,
                    }
                    result[i] = obj;
                }
            }
            //else { }
            return result;
        },

        queueItemList(item, list = null) {
            var result = [];
            var itemList = [];
            if(!list) {
                itemList = Object.assign({}, item.ext_numbers);
                for (var i in itemList) {
                    var listArr = itemList[i].split(',');
                    var _type   = '';
                    var obj = {
                        id     : listArr[0],
                        prefix : listArr[1],
                        type   : _type,
                    }
                    result[i] = obj;
                }
            }
            //else { }
            return result;
        },

        ivrItemList(item, list = null) {
            var result = [];
            var itemList = [];
            if(!list) {
                itemList = Object.assign({}, item.entries);
                // lg(itemList); return;
                for (var i in itemList.goto) {
                    var listArr = itemList.goto[i].split(',');
                    var extNum  = itemList.ext[i];
                    var _type   = '';
                    var obj = {
                        id     : listArr[1],
                        prefix : extNum,
                        from   : listArr[0],
                        type   : _type,
                    }
                    result[extNum] = obj;
                }
            }
            //else { }
            return result;
        },

        trunkItemList(item, list = null) {
            var result = [];
            var itemList = [];
            if(!list) {
                var usercontext = item.usercontext;
                var route = this.searchArr(this.didRoutes, 'extension', usercontext);
                if(route) {
                    var destination = route.destination;
                    var _type = '';
                    var listArr = destination.split(',');
                    if(destination.indexOf('ivr') + 1) {
                        listArr[1] = this.typeOfDigit(listArr[0]);
                        _type = 'ivr';
                    }

                    var obj = {
                        id     : listArr[1],
                        prefix : listArr[2],
                        from   : listArr[0],
                        type   : _type,
                    }
                    result.push(obj);
                }
            }
            return result;
        },

        getInfoObjectsDetails(itemId = 0, type = 0) {
            var url = '&action=getInfoObjetsDetails&item_id=' + itemId + '&type=' + type;
            return this.send('get', url, null, 'local');
        },

        saveInfoObjectsDetails(postData, itemId = 0) {
            var url = '&action=saveInfoObjetsDetails&item_id=' + itemId;
            return this.send('post', url, postData, 'local');
        },

        getCoreSettings(callback) {
            this.getCoreInfo(response => {
                this.coreInfo = response;

                // this.users   = [];
                // this.trunks  = [];
                // this.devices = [];
                // this.didRoutes  = [];
                // this.outRoutes  = [];
                // this.ringGroups = [];
                // this.customContexts = [];

                this.findmefollow = this.coreInfo['findmefollow'];
                this.users      = this.coreInfo['users'];
                this.trunks     = this.coreInfo['trunks'];
                this.didRoutes  = this.coreInfo['DID'];
                this.outRoutes  = this.coreInfo['routes'];
                this.ringGroups = this.coreInfo['ringgroups'];
                this.devices    = this.coreInfo['devices'];
                this.customContexts = this.coreInfo['custom_contexts'];
                this.customContextList = this.coreInfo['custom_contexts'];
                this.queues     = this.coreInfo['queues'];
                this.ivrItems   = this.coreInfo['ivr_details'];

                this.setUsersForwardingCalls();
                this.getSoundRecordList();

                // lg(this.coreInfo['ivr_details']);
                // this.setCustomContextIncludes();
                if(callback) callback();
            });
        },

        getExtMap(callback) {
            this.send('get', '&display=_getExtMap').then(response =>{
                this.extMap = response['extMap'];
                this.frameworkUsage = response['frameworkUsage'];
                if(callback)
                    callback(response);
            });
        },

        findExtMap(findNum, extMap = null) {
            var findObj = { find : false, value : '' };
            if(!extMap) extMap = this.frameworkUsage;
            for(var name in extMap) {
               switch(name) {
                   case 'core' :
                   case 'featurecodeadmin' :
                   case 'queues' :
                   case 'ringgroups' :
                   case 'parking' :
                       var items = extMap[name];
                       for (var num in items) {
                           var extValue = items[num];
                           if (findNum == num) {
                               findObj.find = true;
                               findObj.value = extValue;
                               return findObj;
                           }
                       }
                       break;
               }
            }

            // if(!extMap) extMap = this.extMap;
            // for(var num in extMap) {
            //     var extValue = extMap[num];
            //     if(findNum == num) {
            //         findObj.find  = true;
            //         findObj.value = extValue;
            //         return findObj;
            //     }
            // }
            return findObj;
        },

        findExtMapRecursive(newNum, extMap = null) {
            var obj = this.findExtMap(newNum, extMap);
            if(obj.find) {
                newNum++;
                newNum = this.findExtMapRecursive(newNum, extMap);
            }
            return newNum;
        },

        setUsersForwardingCalls() {
            for(var i in this.users) {
                var itemId   = this.users[i].extension;
                var followMe = this.searchArr(this.findmefollow, 'grpnum', itemId);
                if(!followMe['grplist']) continue;

                this.users[i]['followMeList'] = {
                    tel: followMe['grplist'],
                    time: followMe['grptime'],
                };
                // this.users[i]['followMeTime'] = followMe['grptime'];
            }
        },


        // --- проверяем на присутствие в массиве
        isDropElement(itemId) {
            for(var i in this.dropElementItems) {
                var elem = this.dropElementItems[i];
                if(elem.id == itemId) {
                    return false
                }
            }
            return true;
        },

        // --- производим поиск по типу и формируем bundle
        getItemBundle(type, itemId = 0) {

            var item  = {};
            var items = [];
            var params = {};

            switch(type) {
                case 'user' :
                    items = Object.assign({}, this.users);
                    params = Object.assign({}, this.userParams);
                    break;

                case 'group' :
                    items = Object.assign({}, this.ringGroups);
                    params = Object.assign({}, this.groupParams);
                    break;

                case 'queue' :
                    items = Object.assign({}, this.queues);
                    params = Object.assign({}, this.queueParams);
                    break;

                case 'ivr' :
                    items = Object.assign({}, this.ivrItems);
                    params = Object.assign({}, this.ivrParams);
                    break;

                case 'trunk' :
                    items = Object.assign({}, this.trunks);
                    params = Object.assign({}, this.trunkParams);
                    break;
            }

            if(itemId) {
                item = this.searchArr(items, params.auto, itemId);
            }

            return  { item, items, params };
        },

        createObjectsBundle(data = null) {

            var objectsBundle = [

                {   boxClass : 'trunks-drag-box',
                    items :this.trunks,
                    params:this.trunkParams,
                    name : 'trunk',
                },

                {   boxClass : 'users-drag-box',
                    items :this.users,
                    params:this.userParams,
                    name : 'user',
                },

                {   boxClass : 'groups-drag-box',
                    items :this.ringGroups,
                    params:this.groupParams,
                    name : 'group',
                },

                {   boxClass : 'queues-drag-box',
                    items :this.queues,
                    params:this.queueParams,
                    name : 'queue',
                },

                {   boxClass : 'ivr-drag-box',
                    items :this.ivrItems,
                    params:this.ivrParams,
                    name : 'ivr',
                },
            ];

            this.objectsBundle = objectsBundle;
            this.objectsBundleArch = Object.assign({}, objectsBundle);

            return objectsBundle;
        },

        findObjectsBundle(type, itemId = 0, get = 'items') {
            for(var i in this.objectsBundle) {
                var bundle = this.objectsBundle[i];
                if(type != bundle.name) continue;
                var params = bundle.params;
                var items  = bundle.items;
                if(itemId) {
                    for(var x in items) {
                        var item =  items[x];
                        if(item[params.auto] == itemId) {
                            return item;
                        }
                    }
                }
                var obj = false;
                switch(get) {
                    case 'items' : obj = items;  break;
                    default      : obj = bundle; break;
                }
                return obj;
            }
            return false;
        },

        findItemInBundle(itemId, type) {
            var items = [];
            var itemsBundle = this.objectsBundle;

            //if(!type) infoPanelRun(['Нет типа объекта', 'findItemInBundle()'], 'warn', { not_close : true, });

            for(var i in itemsBundle) {
                var items  = itemsBundle[i].items;
                var params = itemsBundle[i].params;
                var name   = itemsBundle[i].name;
                if(type) {
                    if(type == name) {
                        var item = this.searchArr(items, params.auto, itemId);
                        if (Object.keys(item).length != 0)  {
                            return { item , params, items, id: itemId };
                        }
                    }
                }
                else {
                    var item = this.searchArr(items, params.auto, itemId);
                    if (Object.keys(item).length != 0)  {
                        return { item , params, items, id: itemId };
                    }
                }
            }
            return false;
        },

        asterReload(callback) {
            this.reloadStatus  = false;
            this.reloadMessage = '';
            var postData = { 'handler' : 'reload' };
            if(!callback) {
                this.httpRun(this.postApiUrl, this.responseReload, 'POST', postData);
            }
            else {
                this.httpRun(this.postApiUrl, callback, 'POST', postData);
            }
        },

        asteriskReboot(cb = null) {
            // message: "Благополучно перезагружено"
            // num_errors: 0
            // retrieve_conf: ""
            // status: true
            // test: "abc"
            this.reloadStatus  = false;
            this.reloadMessage = '';
            var postData = { handler : 'reload' };
            return this.saveDefault(postData);
        },

        responseReload(response) {
            this.reloadStatus  = response['status'];
            this.reloadMessage = response['message'];
        },


        // getContextIncludesItem(context, outRouteName = '') {
        //     var args = 'index.php?action=getContextIncludesList&context=' + context + '&route=' + outRouteName;
        //     return this.httpPromise(this.localApiUrl + args , 'GET');
        // },
        //
        // setCustomContextIncludes() {
        //     // var customContexts = this.customContexts;
        //     for(var i in this.customContexts) {
        //         var item = this.customContexts[i];
        //         this.getContextIncludesItem(item.context).then(
        //             response => {
        //                 this.customContexts[i]['includes'] = response;
        //             });
        //     }
        // },

        // ------------------------------------
        // -- ДОБАВЛЕНИЕ, РЕДАКТИРОВАНИЯ, УДАЛЕНИЯ
        editItem(item, typeName) {
            // alert(typeName);
            switch (typeName) {
                case 'context' :

                    break;
            }
            this.asterReload();
        },

        deleteItem(item, typeName) {
            // alert(typeName);
            switch (typeName) {
                case 'context'   : this.customContextDelete(item); break;
                case 'out-route' : this.outRouteDelete(item);      break;
            }
            this.asterReload();
        },

        customContextDelete(item) {
            var contextName = item['context'];
            var data = {
                type    : 'setup',
                display : 'customcontexts',
                extdisplay : contextName,
                action : 'del',
            }; 
            this.httpRun(this.postApiUrl, this.responseDelete, 'GET', data);
        },

        outRouteDelete(item) {
            var data = {  
                display    : 'routing',
                extdisplay : item['route_id'],
                action     : 'delroute',
            };
            this.httpRun(this.postApiUrl, this.responseDelete, 'GET', data);
        },


        responseDelete(response) {
            // lg(response);
            console.log(response);
            this.getCoreSettings();
        },

        //--- добавить новую очередь
        addQueue(item, extensions) {
            var queueItem = this.getQueueModel();
            for(var fieldName in queueItem) {
                if(item[fieldName]) {
                    queueItem[fieldName] = item[fieldName];
                }
            }
            // queueItem.members = extensions.join(',');
            var postData = queueItem;
            return this.httpPromise(this.postApiUrl, 'POST', postData);
        },

    },
};
