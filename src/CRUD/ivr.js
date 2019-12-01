
const IvrUpdate = {

    install(Vue, options) {

        Vue.mixin({

            data: function() {

                var editIvrModel = {
                    display: 'ivr',
                    action : 'save',
                    Submit : 'Submit',
                    type: '',
                    id  : '',
                    name: '',
                    description : '',
                    announcement: '',
                    directdial: '',
                    timeout_time : '',
                    invalid_loops: '',
                    timeout_loops: '',
                    //invalid_destination : 'app-blackhole,hangup,1',
                    //timeout_destination : 'app-blackhole,hangup,1',
                    invalid_destination : '',
                    timeout_destination : '',
                    invalid_retry_recording : '',
                    invalid_recording : '',
                    entries: {},
                };

                return {
                    editIvrModel,
                }
            },

            methods: {

                // --- ПРОВЕРКА ИМЕНИ
                checkNewIvrName(fieldName) {

                    var newItemName = this.item[fieldName];
                    if(!newItemName) return false;

                    this.getItemsDataController('getIvrList').then(itemsList => {
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

                // --- УСТАНОВКА НОВОГО IVR
                setNewIvrItem(params) {
                    this.getExtMap(resp => {
                        this.getItemsDataController('getIvrList').then(itemsList => {
                            var len = itemsList.length;
                            var newItemNum = ++len;
                            this.item['name'] = 'ivr-name-' + newItemNum;
                            this.item['description'] = 'ivr-desc-' + newItemNum;
                        });
                    });
                },

                // --- ФОРМИРУЕМ ПОЛЯ ДЛЯ РЕДАКТИРОВАНИЯ
                ivrFieldsFormatted(data) {
                    var item = Object.assign({}, this.editIvrModel);
                    for(var i in data) {
                        if(i in item)
                            item[i] = data[i];
                    }
                    return item;
                },

                // -- ФОРМИРУЕМ СТРОКУ СВЯЗИ
                setIvrGoto(target) {
                    var targetUid  = target.id;
                    var goto = false;
                    switch (target.type) {
                        case 'user'  : goto = 'from-did-direct,' + targetUid + ',1'; break;
                        case 'group' : goto = 'ext-group,' + targetUid + ',1';       break;
                        case 'queue' : goto = 'ext-queues,' + targetUid + ',1';      break;
                        case 'ivr'   : goto = 'ivr-' +targetUid+ ',s,1';             break;
                    }
                    return goto;
                },

                // -- ОБНОВЛЕНИЕ СВЯЗИ
                ivrLinkUpdate(sourceData, targetData, extNum) {

                    var params  = this.ivrParams;
                    var sourceId = sourceData.id;
                    var item = this.searchArr(this.ivrItems, params.uid, sourceId);
                    var entries = item.entries;
                    var goto = false;
                    for(var i in entries.ext) {
                        if(entries.ext[i] == extNum) {
                            goto = this.setIvrGoto(targetData);
                            break;
                        }
                    }

                    if(goto) {
                        entries.goto[i] = goto;
                    }
                    else {
                        goto = this.setIvrGoto(targetData);
                        entries.goto.push(goto);
                        entries.ext.push(extNum);
                        entries.ivr_ret.push(0);
                    }

                    this.editItemLink(item, params);
                },

                // -- УДАЛЕНИЕ СВЯЗИ
                ivrLinkDelete(sourceData, targetData, extNum) {

                    var params  = this.ivrParams;
                    var sourceId = sourceData.id;
                    var item = this.searchArr(this.ivrItems, params.uid, sourceId);
                    var entries = item.entries;
                    var goto = false;

                    for(var i in entries.ext) {
                        if(entries.ext[i] == extNum) {
                            delete entries.goto[i];
                            delete entries.ext[i];
                            delete entries.ivr_ret[i];
                            break;
                        }
                    }

                    this.editItemLink(item, params);
                },


                deleteIvr(item, params) {
                    var itemId = item[params.auto];
                    var url = 'display=ivr&action=delete&id=' + itemId;
                    return url;
                },

            }
        })

    } //  Install
};


