
const SaveMixin = {

    install(Vue, options) {
        Vue.mixin({

            data: function() {
                return {
                }
            },

            methods: {

                // --- ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ
                getItemTypeName() {
                    return this.params.typeName;
                },

                // --- ФОРМИРУЕМ ПОЛЯ ДЛЯ РЕДАКТИРОВАНИЯ
                editItemFormatted(data, itemType = null) {
                    var item = {};
                    if(!itemType)
                        itemType = this.getItemTypeName();

                    switch (itemType) {
                        case 'queue' :
                            item = this.queueFieldsFormatted(data);
                            break;

                        case 'ivr' :
                            item = this.ivrFieldsFormatted(data);
                            break;

                        case 'group' :
                            item = this.groupFieldsFormatted(data);
                            break;

                        case 'user' :
                            item = this.userFieldsFormatted(data);
                            break;

                        case 'trunk' :
                            item = this.trunkFieldsFormatted(data);
                            break;

                        default :
                            item = data;
                            break;
                    }

                    return item;
                },


                //###############################
                // --- ДЕЙСТВИЯ ПЕРЕД СОХРАНЕНИЕМ
                beforeSave(item, itemType = null) {

                    if(!itemType)
                        itemType = this.getItemTypeName();

                    switch (itemType) {
                        case 'queue' :
                            item = this.queueSetMembers(item);
                            break;

                        case 'group' :
                            item = this.groupSetList(item);
                            break;

                        case 'trunk' :
                            item = this.trunkSetList(item);
                            // lg(item);
                            break;

                        case 'ivr' : break;

                        case 'user' : break;

                    }
                    return item;
                },

                // --- ФОРМИРУЕМ СВЯЗИ В ОЧЕРЕДИ
                queueSetMembers(item) {
                    var members = '';
                    for(var i in item.members) {
                        members += item.members[i] + "\n";
                    }
                    item.members = members;
                    return item;
                },

                // --- ФОРМИРУЕМ СВЯЗИ В ГРУППЕ
                groupSetList(item) {
                    var grpList = item.grplist.split('-');
                    item.grplist = grpList.join("\n");
                    return item;
                },

                //################################


                //###############################
                // -- СОХРАНЕНИЕ ----
                save(type = null, data = null) {
                    if(data) this.item = data;
                    var postData = this.beforeSave(this.item, type);
                    // lg(postData); return false;
                    this.send('post', '', postData).then(response => {
                         this.afterSaveResponse(response);
                    });
                },

                //###############################
                // --- ДЕЙСТВИЯ ПОСЛЕ СОХРАНЕНИЯ
                getResponseData(response = null) {
                    var params = {
                        id     : this.id,
                        item   : this.item,
                        action : this.action,
                        params : this.params,
                        response : response,
                    }
                    return params;
                },

                afterSaveResponse(response) {
                    var responseData = this.getResponseData(response);
                    var emitEventName = 'to_update_item';

                    infoPanelRun(['Успешное сохранение'], 'ok');

                    switch (this.action) {
                        case 'add'  :
                            this.$emit(emitEventName, responseData);
                            break;

                        case 'edit' :
                            this.$emit(emitEventName, responseData);
                            break;

                        case 'edit_link' :
                            this.$emit(emitEventName, responseData);
                            break;
                    }
                },

                getNewItemExtension(newItemNum, params, itemsList) {
                    var auto = params.auto;
                    var len = itemsList.length;
                    if(!len) len = 0;
                    for(var i in itemsList) {
                        var list = itemsList[i];
                        if(parseInt(list[auto]) > newItemNum)
                            newItemNum = list[auto];
                    }

                    newItemNum++;
                    len++;

                    newItemNum = this.findExtMapRecursive(newItemNum);

                    return { newItemNum, len };
                },

                addNewItemToCanvas(type, id) {
                    var pos = { left : 450, top : 80 };
                    // --- ДОБАВЛЯЕМ ЕЛЕМЕНТ В ВИРТУАЛЬНЫЙ ДОМ VUE
                    this.newDropElementsAddToCanvas({ type, id }, pos, {});
                    // --- АКТИВИРУЕМ В КОНСТРУКТОРЕ ЕЛЕМЕНТЫ ( JsPlum )
                    this.setEventGlobalBus('new_drop_elements_run', {});
                },


            }  // --- METHODS
        }) // --- MIXIN
    } // --- INSTALL
};


