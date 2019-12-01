
const GroupUpdate = {

    install(Vue, options) {

        Vue.mixin({

            data: function() {

                // var editGroupModel = {
                //     display : "ringgroups" ,
                //     action : "edtGRP" ,
                //     account : "номер группы" ,
                //     description : "Описание" ,
                //     strategy : "ringall" ,
                //     grptime : "" ,
                //     grplist : "" ,
                //     annmsg_id : "" ,
                //     ringing : "Ring" ,
                //     grppre : "" ,
                //     alertinfo : "" ,
                //     remotealert_id : "" ,
                //     toolate_id : "" ,
                //     changecid : "default" ,
                //     recording : "dontcare" ,
                //     goto0 : "Terminate_Call" ,
                //     Terminate_Call0 : "app-blackhole,hangup,1" ,
                //     Submit : "Submit Changes" ,
                // };

                return {
                    // editGroupModel,
                }
            },

            methods: {

                setNewGrpItem(params) {
                    this.getExtMap(resp => {
                        this.getItemsDataController('getGrpList').then(itemsList => {
                            var newItemNum = 600;
                            var res = this.getNewItemExtension(newItemNum, params, itemsList);
                            this.item['account'] = res.newItemNum;
                            this.item['description'] = 'groups ' + res.len;
                        });
                    });
                },

                deleteGroup(item, params) {

                    var grpnum = item[params.auto];
                    var postData = {
                        display : 'ringgroups',
                        action  : 'delGRP',
                        account : grpnum,
                    };

                    return postData;
                },


                // --- ФОРМИРУЕМ ПОЛЯ ДЛЯ СОХРАНЕНИЯ
                groupFieldsFormatted(data) {
                    var item = Object.assign({}, this.getGroupModel());
                    for(var fieldName in data) {

                        switch (fieldName) {
                            case 'grpnum' :
                                item['account'] = data[fieldName];
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
                groupLinkUpdate(sourceData, targetData) {

                    var prefix    = '#';
                    var delimiter = '-';
                    var savePermit = false;

                    var params   = this.groupParams;
                    var sourceItemId = sourceData.id;
                    var item = this.searchArr(this.ringGroups, params.uid, sourceItemId);

                    // --- кого подключаем
                    var targetItemId = targetData.id;
                    var targetItemType = targetData.type;

                    // --- список елементов
                    var grplist = item.grplist;
                    var grpListArr = grplist.split(delimiter);

                    switch(targetItemType){
                        case 'user' :
                               savePermit = true;
                               break;

                        case 'group' :
                        case 'queue' :
                        case 'ivr' :
                            savePermit = true;
                            targetItemId = targetItemId + prefix;
                            break;

                    }

                    if(!savePermit) return false;

                    //--- прозводим поверку на наличие в массиве
                    for(var i in grpListArr) {
                        if(grpListArr[i] == targetItemId)
                             return false;
                    }

                    grpListArr.push(targetItemId);
                    item.grplist = grpListArr.join(delimiter);
                    this.editItemLink(item, params);
                },

                // -- УДАЛЕНИЕ СВЯЗИ
                groupLinkDelete(sourceData, targetData) {

                    var prefix    = '#';
                    var delimiter = '-';
                    var savePermit = false;

                    var params   = this.groupParams;
                    var sourceItemId = sourceData.id;
                    var item = this.searchArr(this.ringGroups, params.uid, sourceItemId);

                    // --- кого подключаем
                    var targetItemId = targetData.id;
                    var targetItemType = targetData.type;

                    // --- список елементов
                    var grplist = item.grplist;
                    var grpListArr = grplist.split(delimiter);

                    switch(targetItemType){
                        case 'user' :
                            savePermit = true;
                            break;

                        case 'group' :
                        case 'queue' :
                            savePermit = true;
                            targetItemId = targetItemId + prefix;
                            break;
                    }

                    if(!savePermit) return false;

                    for(var i in grpListArr)
                        if(grpListArr[i] == targetItemId)
                          delete grpListArr[i]

                    item.grplist = grpListArr.join(delimiter);
                    this.editItemLink(item, params);
                },

            }
        })

    } //  Install
};


