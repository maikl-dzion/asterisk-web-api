
const OutBoundRoute = {

    install(Vue, options) {

        Vue.mixin({
            data: function() {
                return {
                    // editTrunkModel,
                    outBoundRoute : {},
                    customContextItem : {},

                    extenNum       : '',
                    newRouteName   : '',
                    newRouteId     : '',
                    newContextName : '',
                }
            },

            methods: {

                  setOutRoundRouteModel () {
                      this.outBoundRoute      = this.getOutRouteModel();
                      this.customContextItem  = this.getCustomContextModel();
                  },

                  // --- Формируем новый исходящий маршрут
                  createOutRoute(trunkId, trunkContext, outRoute = null) {
                      var newOutRoute = this.getOutRouteModel();  // -- получаем модель исходящего маршрута
                      var routeName  = trunkId +'_'+ trunkContext + '_outroute_auto'; // формируем имя исходящего маршрута
                      newOutRoute['routename']     = routeName;
                      newOutRoute['trunkpriority'][0] = trunkId;
                      return newOutRoute;
                  },

                  // --- Формируем новый custom context
                  createCustomContext(routeId, trunkContext, contextItem = null) {
                      var newContextItem  = this.getCustomContextModel();
                      var contextName  = routeId +'_'+ trunkContext + '_customcontext_auto';
                      newContextItem['extdisplay']  = contextName;
                      newContextItem['description'] = contextName;
                      return newContextItem;
                  },

                  outRouteInsertId(resp) {
                      // resp['result'][1] = '/admin-lte/admin/config.php?display=routing&extdisplay=75';
                      try {
                          var respArr    = resp['result'][1].split('&');
                          var extdisplay = respArr[1].split('=');
                          var routeId    = extdisplay[1];
                          return routeId;
                      }catch(e) {
                          lg('Ошибка после создания исходящего маршрута');
                          return false;
                      }
                  },

                  // --- Получаем custom context для редактирования
                  getCustomContextItem(context, routeName) {
                     var args = 'action=getContextItem&context=' + context + '&route=' + routeName;
                     return this.send('get' , args, null, 'local');
                  },

                  getExtensionInfo(extension) {
                      var args = 'action=getExtensionInfo&extension=' + extension;
                      return this.send('get' , args, null, 'local');
                  },

                  createExtensionContext(item, newContextName) {
                        // var extension = item['extension'];
                        // var name      = item['name'];
                        // var secret    = item['secret'];
                        var extension = item['id'];
                        var name      = item['description'];
                        var secret    = item['secret'];
                        var extension = {
                            'display' : 'extensions',
                            'type'    : '',
                            'action'  : 'edit',
                            'extdisplay' : extension,
                            'extension'  : extension,
                            'name'       : name,

                            //'devinfo_secret_origional' : secret,
                            //'devinfo_secret'  : secret,
                            'devinfo_context' : newContextName,
                            'customcontext'   : newContextName,
                            'Submit'  : 'Сохранить',
                        };
                        return extension;
                  },

                  // --- СОЗДАНИЕ ИСХОДЯЩЕЙ ЛИНИИ(МАРШРУТА)
                  addOutRouteLine(trunkData, callBack = null) {

                        var trParams  = this.trunkParams;
                        var trunkId   = trunkData.id;
                        var trunkItem = this.searchArr(this.trunks, trParams.auto, trunkId);
                        var trunkName = trunkItem[trParams.name];
                        var trunkContext = trunkItem['usercontext'];

                        this.spinPreLoader(true, 'Создаем исходящий маршрут', 'Создаем исходящий маршрут');

                        // --- ФОРМИРУЕМ ИСХОДЯЩИЙ МАРШРУТ
                        var newOutRoute = this.createOutRoute(trunkId, trunkContext);

                        var customContextItem = {};
                        var newRouteId   = '';
                        var newRouteName = '';
                        var newContextName = '';

                        this.saveDefault(newOutRoute)
                            .then(resp     => {  // ---  СОЗДАНИЕ НОВОГО ИСХОДЯЩЕГО МАРШРУТА
                                newRouteId = this.outRouteInsertId(resp);  // --- получаем id route
                                if(newRouteId) return this.asteriskReboot();
                            }).then(reload => {  // --- ВЫПОЛНЯЕМ ЗАПРОС НА СОЗДАНИЕ CUSTOM CONTEXT
                                if(!reload.status) { lg("Сreate new OUT ROUTE");return false; }
                                customContextItem = this.createCustomContext(newRouteId, trunkContext); // --- ФОРМИРУЕМ CUSTOM CONTEXT
                                return this.saveDefault(customContextItem);
                            })
                            .then(resp   => { return this.asteriskReboot(); })
                            .then(reload => {     // --- ПОЛУЧАЕМ CUSTOM CONTEXT ДЛЯ РЕДАКТИРОВАНИЯ
                                if(!reload.status) {  lg("Сreate new CUSTOM CONTEXT"); return false; }
                                newRouteName   = newOutRoute['routename'];
                                newContextName = customContextItem['extdisplay'];
                                return this.getCustomContextItem(newContextName, newRouteName);
                            })
                            .then(contextData => { return this.saveDefault(contextData);}) // --- РЕДАКТИРОВАНИЕ CUSTOM CONTEXT
                            .then(resp        => { return this.asteriskReboot(); })
                            .then(reload      => {
                                if(!reload.status) { lg("Edit new CUSTOM CONTEXT"); return false; }
                                this.spinPreLoader(false);
                                if(callBack) callBack();
                            });

                  },  // --- addOutRouteLine

                  // addOutBoundRoute(sourceData, targetData) {
                  //
                  //     this.setOutRoundRouteModel();
                  //
                  //     var sourceParam  = this.userParams;
                  //     var sourceItemId = sourceData.id;
                  //     var sourceItem = this.searchArr(this.users, sourceParam.auto, sourceItemId);
                  //     var sourceName = sourceItem[sourceParam.name];
                  //     this.extenNum  = sourceItemId;
                  //
                  //     var trParam  = this.trunkParams;
                  //     var targetItemId = targetData.id;
                  //     var targetItem = this.searchArr(this.trunks, trParam.auto, targetItemId);
                  //     var targetName = targetItem[trParam.name];
                  //
                  //     // var routeName  = 'out_' + targetName + '_trankid_' + targetItemId; // формируем имя исходящего маршрута
                  //     // this.outBoundRoute['routename'] = routeName;
                  //     // this.outBoundRoute['trunkpriority'] = targetItemId;
                  //
                  //     // this.newContextName = 'out_74951336279_trankid_3_contextid_80';
                  //     // this.newRouteName   = 'out_74951336279_trankid_3';
                  //     // this.getCustomContextItem(this.newContextName, this.newRouteName).then(resp => {
                  //     //       lg(resp);
                  //     // });
                  //     // return false;
                  //
                  //     // --- ФОРМИРУЕМ ИСХОДЯЩИЙ МАРШРУТ
                  //     this.outBoundRoute = this.createOutRoute(targetName, targetItemId, this.outBoundRoute);
                  //     this.newRouteName  = this.outBoundRoute['routename'];
                  //     this.spinPreLoader(true, 'Создаем исходящий маршрут', 'Создаем исходящий маршрут');
                  //     // --- ВЫПОЛНЯЕМ ЗАПРОС НА СОЗДАНИЕ НОВОГО ИСХОДЯЩЕГО МАРШРУТА
                  //     this.saveDefault(this.outBoundRoute)
                  //         .then(resp => {
                  //             try {
                  //                 // --- ФОРМИРУЕМ CUSTOM CONTEXT
                  //                this.newRouteId = this.outRouteInserId(resp);
                  //                this.customContextItem = this.createCustomContext(this.newRouteName, this.newRouteId, this.customContextItem);
                  //                return this.asteriskReboot(); // ПЕРЕГРУЖАЕМ ASTERISK
                  //             }catch(e) {
                  //                 lg('Ошибка после создания исходящего маршрута == step-1');
                  //             }
                  //         })
                  //         .then(reload => {
                  //             if(reload.status) {// --- ВЫПОЛНЯЕМ ЗАПРОС НА СОЗДАНИЕ CUSTOM CONTEXT
                  //                 this.loadingPopUpMessage += "<br> ВЫПОЛНЯЕМ ЗАПРОС НА СОЗДАНИЕ CUSTOM CONTEXT";
                  //                 return this.saveDefault(this.customContextItem);
                  //             }
                  //             lg('Ошибка при перезагрузке Asterisk:"create new OUT ROUTE" == step-2');
                  //         })
                  //
                  //         .then(resp => { return this.asteriskReboot(); }) // ПЕРЕГРУЖАЕМ ASTERISK
                  //
                  //         .then(reload => {
                  //             if(reload.status) { // --- ПОЛУЧЕНИЕ СОЗДАННОГО CUSTOM CONTEXT
                  //                 this.loadingPopUpMessage += "<br> ПОЛУЧЕНИЕ СОЗДАННОГО CUSTOM CONTEXT";
                  //                 return this.getCustomContextItem(this.newContextName, this.newRouteName);
                  //             }
                  //             lg('Ошибка при перезагрузке Asterisk:"create new CUSTOM CONTEXT" == step-3');
                  //         })
                  //         .then(resp => {
                  //             this.loadingPopUpMessage += "<br> РЕДАКТИРОВАНИЕ CUSTOM CONTEXT";
                  //             var postData = resp;
                  //             return this.saveDefault(postData);
                  //         })
                  //
                  //         .then(resp   => { return this.asteriskReboot(); }) // ПЕРЕГРУЖАЕМ ASTERISK
                  //
                  //         .then(reload => {
                  //             if(reload.status) {
                  //                 this.loadingPopUpMessage += "<br> ПОЛУЧАЕМ ПОЛЬЗОВАТЕЛЬСКИЕ ДАННЫЕ";
                  //                 return this.getExtensionInfo(this.extenNum);
                  //             }
                  //             lg('Ошибка при перезагрузке Asterisk == step-4');
                  //         })
                  //         .then(resp => {
                  //              this.loadingPopUpMessage += "<br> СОХРАНЯЕМ ПОЛЬЗОВАТЕЛЬСКИЕ ДАННЫЕ";
                  //              var item = resp;
                  //              var postData = this.createExtensionContext(item, this.newContextName);
                  //              return this.saveDefault(postData);
                  //         })
                  //
                  //         .then(resp   => { return this.asteriskReboot(); }) // ПЕРЕГРУЖАЕМ ASTERISK
                  //
                  //         .then(reload => {
                  //             this.loadingPopUpMessage += "<br> ИСХОДЯЩИЙ МАРШРУТ УСПЕШНО СОЗДАН";
                  //             this.spinPreLoader(false);
                  //             if(reload.status) {
                  //                 infoPanelRun(['Исходящий маршрут успешно создан'], 'ok');
                  //                 return;
                  //             }
                  //             lg('Ошибка при перезагрузке Asterisk == step-5');
                  //         });
                  //
                  // },  // --- addOutBoundRoute


            } // --- methods

        }) // --- Vue.mixin
    } // --- install
};


