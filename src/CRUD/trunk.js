
const TrunkUpdate = {

    install(Vue, options) {

        Vue.mixin({

            data: function() {

                var editTrunkModel = {

                    "display" : "trunks" ,
                    "action" : "edittrunk" ,

                    "extdisplay"     : "" ,
                    "sv_usercontext" : "" ,
                    "usercontext"    : "" ,

                    "sv_channelid"   : "" ,
                    "trunk_name"     : "" ,
                    "outcid"         : "" ,
                    "channelid"      : "" ,

                    //"peerdetails" : "" ,
                    //"userconfig" : "" ,
                    //"register" : "579659:JVbgf2z7v8@sip.zadarma.com/579659" ,

                    //"prepend_digit"  : {} ,
                    //"pattern_prefix" : {} ,
                    //"pattern_pass"   : {} ,

                    "tech"   : "sip" ,
                    "provider" : "" ,
                    "sv_trunk_name" : "" ,
                    "npanxx" : "" ,
                    "keepcid" : "off" ,
                    "maxchans" : "" ,
                    "autopop" : "" ,
                    "dialoutprefix" : "" ,
                    "Submit" : "Сохранить изменения" ,

                };

                return {
                    editTrunkModel,
                }
            },

            methods: {

                // --- ПРОВЕРКА ИМЕНИ ---
                checkNewTrunkName(fieldName) {

                    var newItemName = this.item[fieldName];
                    if(!newItemName) return false;

                    this.getItemsDataController('getTrunksList').then(itemsList => {
                        for(var i in itemsList) {
                            var item = itemsList[i];
                            if(item.name == newItemName) {
                                var fieldValue = newItemName;
                                var message = `Это название "${newItemName}" уже используется,
                                                    <br> выберите другое название! <br>`;
                                infoPanelRun([message], 'error', { 'time' : 4000});
                                this.item[fieldName] = '';
                                return false;
                            }
                        }
                    });
                },

                trunkSetList(item) {

                    var peerDetails = '';
                    for(var name in item.peerdetails) {
                        var val = item.peerdetails[name];
                        peerDetails += name +'='+ val + "\n";
                    }

                    item.peerdetails = peerDetails;
                    item.userconfig = peerDetails;
                    return item;
                },

                setNewTrunkItem(params) {

                    this.item.outcid = this.item.trunk_name;
                    this.item.channelid = this.item.trunk_name;
                    this.item.sv_channelid = this.item.trunk_name;

                    this.item.usercontext = this.item.usercontext;
                    this.item.peerdetails.fromuser = this.item.usercontext;
                    this.item.peerdetails.defaultuser = this.item.usercontext;

                    this.item.register = this.item.usercontext + ':'
                        + this.item.peerdetails.secret + '@'
                        + this.item.peerdetails.host + '/'
                        + this.item.usercontext;

                    this.item.userconfig = this.item.peerdetails;

                },

                deleteTrunk(item, params) {
                    var itemId = item[params.auto];
                    var url = 'display=trunks&action=deltrunk&extdisplay=OUT_' + itemId;
                    return url;
                    //return this.send('get' , url, null);
                },

                // --- ФОРМИРУЕМ ПОЛЯ ДЛЯ РЕДАКТИРОВАНИЯ
                trunkFieldsFormatted(data) {
                    var item = Object.assign({}, this.editTrunkModel);

                    // var test = {'model' : item, 'data'  : data }; lg(test);

                    for(var fieldName in data) {
                        var value = data[fieldName];
                        switch (fieldName) {
                            case 'name' :
                                item['sv_channelid']  = value;
                                item['trunk_name']    = value;
                                break;

                            case 'usercontext' :
                                item['usercontext']    = value;
                                item['sv_usercontext'] = value;
                                break;

                            case 'trunkid' :
                                item['extdisplay'] = 'OUT_' + value;
                                break;

                            default :
                                if(fieldName in item)
                                    item[fieldName] = data[fieldName];
                                break;
                        }
                    }

                    // var test = {'model' : item, 'data'  : data }; lg(test);
                    return item;
                },

                // -- ОБНОВЛЕНИЕ СВЯЗИ
                trunkLinkUpdate(sourceData, targetData) {

                    // var delimiter = '-';
                    var savePermit = false;
                    var actionType = 'add';

                    var params   = this.trunkParams;
                    var sourceItemId = sourceData.id;
                    var item = this.searchArr(this.trunks, params.auto, sourceItemId);

                    var trunkId = item[params.auto];
                    var trunkName = item[params.name];
                    var usercontext = item['usercontext'];

                    // --- кого подключаем
                    var targetItemId = targetData.id;
                    var targetType   = targetData.type;

                    // var inRoute = {};
                    var inBoundRoute = this.getDidRouteModelFields();

                    for(var i in this.didRoutes) {
                        var route = this.didRoutes[i];
                        if(route.extension != usercontext) continue;

                        for(var fieldName in route) {
                            if(inBoundRoute[fieldName]) {
                                inBoundRoute[fieldName] = route[fieldName];
                            }
                        }

                        inBoundRoute['extdisplay'] = usercontext;
                        inBoundRoute['action'] = 'edtIncoming';
                        actionType = 'edit';
                        break;
                    }

                    if(actionType == 'add') {
                        var desc = trunkName + '__inbound__tr' + trunkId;
                        inBoundRoute['description'] = desc;
                        inBoundRoute['extension']   = usercontext;
                    }

                    var prefNum = '1';
                    var gotoName, extName = '';

                    switch(targetType){
                        case 'group' :
                            savePermit = true;
                            gotoName = 'Ring_Groups';
                            extName  = 'ext-group';
                            break;

                        case 'queue' :
                            savePermit = true;
                            gotoName = 'Queues';
                            extName  = 'ext-queues';
                            break;

                        case 'ivr' :
                            savePermit = true;
                            gotoName = 'IVR';
                            extName  = 'ivr-' +targetItemId;
                            targetItemId = 's';
                            break;

                        case 'user' :
                            savePermit = true;
                            gotoName = 'Extensions';
                            extName  = 'from-did-direct';
                            break;
                    }

                    if(!savePermit) return false;

                    var targetLine = ',' + targetItemId+ ',' + prefNum;
                    inBoundRoute['goto0'] = gotoName;
                    inBoundRoute[gotoName + '0'] = extName + targetLine;
                    var postData =  Object.assign({}, inBoundRoute);

                    this.saveDefault(postData).then(response => {
                        // var resp = response;
                        infoPanelRun(['Успешное сохранение'], 'ok', 1000);
                        this.getCoreSettings(() => {
                            this.createObjectsBundle();
                        });
                    });

                },

                trunkLinkDelete(sourceData, targetData) {
                    // [Терминировать_звонок0] => app-blackhole,hangup,1
                    // var delimiter = '-';

                    var savePermit = false;
                    var params   = this.trunkParams;
                    var sourceItemId = sourceData.id;
                    var item = this.searchArr(this.trunks, params.auto, sourceItemId);

                    var trunkId = item[params.auto];
                    var trunkName = item[params.name];
                    var usercontext = item['usercontext'];

                    var inBoundRoute = this.getDidRouteModelFields();
                    var destionation = '';
                    for(var i in this.didRoutes) {
                        var route = this.didRoutes[i];
                        if(route.extension != usercontext) continue;

                        for(var fieldName in route) {
                            if(inBoundRoute[fieldName]) {
                               inBoundRoute[fieldName] = route[fieldName];
                            }
                            // else {
                            //     inBoundRoute[fieldName] = route[fieldName];
                            // }
                        }

                        var determinate = 'Терминировать_звонок';
                        inBoundRoute['extdisplay'] = usercontext;
                        inBoundRoute['action'] = 'edtIncoming';
                        inBoundRoute['goto0']  =  determinate;
                        inBoundRoute[determinate + '0'] = 'app-blackhole,hangup,1';
                        savePermit = true;
                        break;
                    }

                    if(savePermit) {
                        this.saveDefault(inBoundRoute).then(resp => {
                            infoPanelRun(['Успешное удаление связи'], 'ok', 1000);
                            this.getCoreSettings(() => { this.createObjectsBundle(); });
                        });
                    }
                    //lg(inBoundRoute);
                },

            } // --- Methods
        })

    } //  Install
};


