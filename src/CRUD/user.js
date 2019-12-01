
const UserUpdate = {

    install(Vue, options) {

        Vue.mixin({

            data: function() {

                var editUserModel = {
                    "display" : "extensions" ,
                    "type" : "" ,
                    "action" : "edit" ,
                    "extdisplay" : "" ,
                    "extension"  : "" ,
                    "name" : "" ,
                    "cid_masquerade" : "" ,
                    "sipname" : "" ,
                    "outboundcid" : "" ,
                    "ringtimer" : "0" ,
                    "cfringtimer" : "0" ,
                    "concurrency_limit" : "0" ,
                    "callwaiting" : "disabled" ,
                    "answermode" : "disabled" ,
                    "call_screen" : "0" ,
                    "pinless" : "disabled" ,
                    "emergency_cid" : "" ,
                    "tech" : "sip" ,
                    "hardware" : "" ,
                    "newdid_name" : "" ,
                    "newdid" : "" ,
                    "newdidcid" : "" ,
                    "devinfo_secret_origional" : "" ,
                    "devinfo_secret" : "" ,
                    "devinfo_dtmfmode" : "rfc2833" ,
                    "devinfo_canreinvite" : "no" ,
                    "devinfo_context" : "from-internal" ,
                    "devinfo_host" : "dynamic" ,
                    "devinfo_trustrpid" : "yes" ,
                    "devinfo_sendrpid" : "no" ,
                    "devinfo_type" : "friend" ,
                    "devinfo_nat" : "no" ,
                    "devinfo_port" : "5060" ,
                    "devinfo_qualify" : "yes" ,
                    "devinfo_qualifyfreq" : "60" ,
                    "devinfo_transport" : "udp" ,
                    "devinfo_avpf" : "no" ,
                    "devinfo_icesupport" : "no" ,
                    "devinfo_dtlsenable" : "no" ,
                    "devinfo_dtlsverify" : "no" ,
                    "devinfo_dtlssetup" : "actpass" ,
                    "devinfo_dtlscertfile" : "" ,
                    "devinfo_dtlsprivatekey" : "" ,
                    "devinfo_encryption" : "no" ,
                    "devinfo_callgroup" : "" ,
                    "devinfo_pickupgroup" : "" ,
                    "devinfo_disallow" : "" ,
                    "devinfo_allow" : "" ,
                    "devinfo_dial" : "" ,
                    "devinfo_accountcode" : "" ,
                    "devinfo_mailbox" : "" ,
                    "devinfo_vmexten" : "" ,
                    "devinfo_deny" : "0.0.0.0/0.0.0.0" ,
                    "devinfo_permit" : "0.0.0.0/0.0.0.0" ,
                    "noanswer_dest" : "goto0" ,
                    "busy_dest" : "goto1" ,
                    "chanunavail_dest" : "goto2" ,
                    "customcontext" : "from-internal" ,
                    "qnostate" : "usestate" ,
                    "faxattachformat" : "pdf" ,
                    "vm" : "disabled" ,
                    "recording_in_external" : "recording_in_external=dontcare" ,
                    "recording_out_external" : "recording_out_external=dontcare" ,
                    "recording_in_internal" : "recording_in_internal=dontcare" ,
                    "recording_out_internal" : "recording_out_internal=dontcare" ,
                    "recording_ondemand" : "recording_ondemand=disabled" ,
                    "recording_priority" : "10" ,
                    "dictenabled" : "disabled" ,
                    "dictformat" : "ogg" ,
                    "dictemail" : "" ,
                    "langcode" : "" ,
                    "goto0" : "" ,
                    "noanswer_cid" : "" ,
                    "goto1" : "" ,
                    "busy_cid" : "" ,
                    "goto2" : "" ,
                    "chanunavail_cid" : "" ,
                    "Submit" : "Сохранить" ,
                    "followMeList" : {},
                };

                return {
                    editUserModel,
                    followMeEdit : { tel : '', time : ''} ,
                }
            },

            methods: {

                // --- ПРОВЕРКА НОМЕРА
                checkNewExtension(fieldName) {

                    var newItemNum = this.item[fieldName];
                    if(!newItemNum) return false;

                    this.getExtMap(resp => {
                        var res = this.findExtMap(newItemNum);
                        if(res.find) {
                            var fValue = res.value;
                            fValue = 'Этот номер "' +newItemNum+ '" уже используется,выберите другой номер! <br> (' +fValue+ ')';
                            infoPanelRun([fValue], 'error', { 'time' : 4000});
                            // this.item[fieldName] = '';
                        }
                    });
                },

                // --- ФОРМИРОВАНИЕ НОВОГО ПОЛЬЗОВАТЕЛЯ
                setNewUserItem(params) {
                    this.getExtMap(resp => {
                        this.getItemsDataController('getUsersList').then(itemsList => {

                            var newItemNum = 30;
                            var len = 0;
                            var secret = '';
                            // var secret = generateNewSecret(23);
                            var res = this.getNewItemExtension(newItemNum, params, itemsList);
                            newItemNum = res.newItemNum;
                            len = res.len;
                            secret = 'User_' + newItemNum;
                            this.item['extension'] = newItemNum;
                            this.item['name'] = 'User-' + len;
                            this.item['devinfo_secret'] = secret;
                            
                        });
                    });
                },

                // --- ФОРМИРУЕМ ПОЛЯ ДЛЯ РЕДАКТИРОВАНИЯ
                userFieldsFormatted(data) {
                    var item = Object.assign({}, this.editUserModel);
                    for(var fieldName in data) {

                        switch (fieldName) {
                            case 'extension' :
                                item['extension']  = data[fieldName];
                                item['extdisplay'] = data[fieldName];
                                break;

                            default :
                                if(fieldName in item)
                                    item[fieldName] = data[fieldName];
                                break;
                        }
                    }

                    return item;
                },

                //  --- СЛЕДУЙ ЗА МНОЙ
                followMeSave() {

                    var itemModel = this.getFollowMeModel();
                    var extType = 'ext-local';
                    var itemId  = this.item.extension;
                    var pref    = 'dest';
                    var tel     = '';

                    if(!this.followMeEdit.time)
                        this.followMeEdit.time = 20;

                    var time = this.followMeEdit.time;

                    if(!this.followMeEdit.tel) {
                        alert('Не вписан номер телефона');
                        return false;
                    }
                    else {
                        tel = this.followMeEdit.tel;
                        var len = tel.length;
                        var end = tel.charAt(len-1);
                        if(end != "#") {
                            tel = tel + '#';
                        }
                    }

                    itemModel["account"] = itemId;
                    itemModel["grplist"] = tel;
                    itemModel["grptime"] = time;
                    itemModel["Follow_Me0"] = extType + ',' + itemId + ',' + pref;

                    this.saveDefault(itemModel, cb = null).then(response => {
                        var res = response;
                        infoPanelRun(['Перенаправление успешно сохранено'], 'ok', 500);
                    });
                },

                deleteUser(item, params) {
                    var itemId = item[params.auto];
                    var url = 'type=&display=extensions&action=del&extdisplay=' + itemId;
                    return url;
                },

                userContextDelete(sourceData, targetData) {

                    var userItem = this.searchArr(this.users, this.userParams.auto, sourceData.id);

                    this.getExtensionInfo(sourceData.id)
                        .then(userData => {
                            // var postData = this.createExtensionContext(userData, contextName);
                            var secret = userData['secret'];
                            if(!secret) secret = 'User_' + sourceData.id;
                            var contextName = '';
                            var postData  = this.userFieldsFormatted(userItem);
                            postData['devinfo_context'] = contextName;
                            postData['customcontext']   = contextName;
                            postData['devinfo_secret_origional'] =  secret,
                            postData['devinfo_secret'] =  secret;
                            return this.saveDefault(postData);
                        })
                        .then(resp => {
                            infoPanelRun(['Успешное удаление связи'], 'ok');
                            this.updateItemsBundle();
                        });
                },

                userContextUpdate(sourceData, targetData) {

                    var userItem = this.searchArr(this.users, this.userParams.auto, sourceData.id);

                    var trunkItem = this.searchArr(this.trunks, this.trunkParams.auto, targetData.id);
                    var trunkContext = trunkItem['usercontext'];
                    var contextName  = '';

                    for(var i in this.customContextList) {
                        var contextItem = this.customContextList[i];
                        var contextArr  = contextItem['context'].split('_');
                        if(contextArr.length > 1)
                            if(contextArr[1] == trunkContext) {
                                contextName = contextItem['context'];
                                break;
                            }
                    }

                    if(contextName)
                        this.getExtensionInfo(sourceData.id)
                          .then(userData => {
                              // var postData = this.createExtensionContext(userData, contextName);
                              var secret = userData['secret'];
                              var postData  = this.userFieldsFormatted(userItem);
                              postData['devinfo_context'] = contextName;
                              postData['customcontext']   = contextName;
                              postData['devinfo_secret_origional'] =  secret,
                              postData['devinfo_secret'] =  secret;
                              return this.saveDefault(postData);
                          })
                          .then(resp => {
                              infoPanelRun(['Успешное сохранение'], 'ok');
                              this.updateItemsBundle();
                          });
                },

                userEditInfoForm(itemId, item, type = 'user') {

                    var respData = {};

                    this.getUserRecordInfo(itemId).then(resp => {
                        respData = resp;
                        return this.getUserInfo(itemId, 'edit');
                    }).then(userInfo => {
                        for(var fieldName in respData) {
                            var respValue = respData[fieldName];
                            userInfo[fieldName] = respValue;
                        }
                        this.item = this.editItemFormatted(userInfo, type);
                        this.item['followMeList'] = item['followMeList'];
                        this.item.customcontext = this.item.devinfo_context;
                    });
                },

                // getFollowMeObj(itemId = false, localItem = false) {
                //     if(!itemId) itemId = this.id;
                //     var autoField = 'grpnum';
                //     var followMe = this.searchArr(this.findmefollow, autoField, itemId);
                //
                //     if(!followMe['grplist']) return false;
                //
                //     if(localItem) {
                //         return { num : followMe['grplist'], time : followMe['grptime'] }
                //     }
                //
                //     this.followMeObj.num  = followMe['grplist'];
                //     this.followMeObj.time = followMe['grptime'];
                //     return this.followMeObj;
                // },

            }
        })

    } //  Install
};


