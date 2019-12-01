
// var linkItems = {};

const ConstructorLinks = Vue.component('constructorLinks', {
    template: '#constructorLinks',
    name    : 'constructorLinks',
    mixins  : [JsPlumController],
    data: function () {

        var dragContainerNames = [
            {name: 'users-drag-box' , title: 'Внутренние номера'},
            {name: 'trunks-drag-box', title: 'Внешние номера'},
            {name: 'groups-drag-box', title: 'Группы'},
            {name: 'ivr-drag-box'   , title: 'Голосовое меню'},
            {name: 'queues-drag-box', title: 'Очереди'},
        ];

        return {

            modalFormState : false,

            pageTitle: 'Конструктор связей',
            smallTitle: 'constructor links',

            containerClass: 'drag-container row',
            itemClass     : 'col-md-3 col-sm-6 col-xs-12 dragItemsStyle dragItem',
            infoClass     : 'info-block',

            searchItemValue: '',

            itemUid : '',
            itemType: '',
            actionType: '',
            itemParams : {},
            params : {},
            item   : {},
            // itemData   : {},

            modalTitle: 'Редактирование',
            dialogVuetify: false,

            dropZoneState: false,

            links: {},
            linkItems: {},
            connections: [],

            infoObjectsDetails : [],
            objSetPositionStart : false,

            itemsPointObjects  : [],

            dragContainerNames,
            objectsBundle: [],
            dynamicComponent : 'group-controller',
            isComponentState :  false,
            compileMessage : '',

            //createNewElementName  : 'create-new-element',
            //createNewElementState : false,
        }
    },

    created: function () {

        this.updateItemsBundle();
        this.getExtMap(() => {});

        // setTimeout(() => {
        //     this.dragContainerToggle('users-drag-box');
        // }, 200);

        // this.getPbxExtensions(33).then(info => {
            // lg(info);
        // })

        // this.getAsteriskCliCommand('sip show peer 187').then(info => {
             // lg(info);
        // });
    },

    // computed: { },

    methods: {


        fileLoaderModalOpen() {
            this.fileLoaderState = true;
            var modalId = this.getItemModalId('file-loader');
            setTimeout(() => {
                $('#' + modalId).modal("show");
            }, 50);
        },


        updateItemsBundle(callback) {
            this.getCoreSettings(() => {
                this.createObjectsBundle();
                if(callback) callback();
            });
        },

        _deleteItem(item, params, delType = 'drop') {

            var deleteMethod = false;
            var postData = {};
            var deleteTitle = '';
            var url  = '';
            var type = params.type;
            var itemId = item[params.auto];

            switch (type) {
                case 'group' :
                    deleteMethod = 'post';
                    deleteTitle = 'Группа удалена';
                    postData = this.deleteGroup(item, params);
                    break;

                case 'queue' :
                    deleteMethod = 'post';
                    deleteTitle = 'Очередь удалена';
                    postData = this.deleteQueue(item, params);
                    break;

                case 'trunk' :
                    deleteMethod = 'get';
                    deleteTitle = 'Внешний номер удален';
                    url = this.deleteTrunk(item, params);
                    break;

                case 'ivr' :
                    deleteMethod = 'get';
                    deleteTitle = 'IVR удален';
                    url = this.deleteIvr(item, params);
                    break;

                case 'user' :
                    deleteMethod = 'get';
                    deleteTitle = 'Пользователь удален';
                    url = this.deleteUser(item, params);
                    break;
            }

            if(deleteMethod) {

                this.send(deleteMethod , url, postData).then(resp => {
                    var res = resp;
                    infoPanelRun([deleteTitle], 'ok', 1000);
                    this.updateItemsBundle(() => {
                        this.dropElementsDelete(type, itemId)
                    });
                    // this.dropElementsDelete(type, itemId);
                });
            }
        },

        clearCanvas() {

            this.newConnectedParams = [];
            this.dropElementItems   = [];
            this.dropElementItems = [];
            this.dropConnectedObjects = [];
            this.dropItemsPoints = [];
            this.dropItemsConnects = [];
            this.infoObjectsDetails = [];
            this.objSetPositionStart = false;
            this.itemsPointObjects  = [];

            instance.deleteEveryEndpoint();
        },

        systemReload() {

            this.loadingPopUpTitle   = '';
            this.loadingPopUpDisplay = 'block';
            this.loadingPopUpMessage = '... Идет перезагрузка Asterisk <p>';

            this.asteriskReboot().then(response => {

                // message: "Благополучно перезагружено"
                // num_errors: 0
                // retrieve_conf: ""
                // status: true
                // test: "abc"

                var resp = response;
                this.loadingPopUpMessage = resp.message;
                setTimeout(() => {
                    this.loadingPopUpDisplay = 'none';
                }, 200);

            });
        },

        searchItems(bundle) {
            var params = bundle.params;
            // var items  = bundle.items;
            // let type   = params.typeName;
            var searchVal = this.searchItemValue;
            var type = params.type;
            var items , newArr = [];

            items = bundleControl(this.objectsBundleArch, type);

            switch (type) {
                case 'user' :

                      this._for(items, (i, item) => {
                          if(item.extension.indexOf(searchVal) != '-1') {
                              newArr.push(item);
                          }
                      });

                      this.objectsBundle = bundleControl(this.objectsBundle, type, 'set', newArr);

                      break;
            }

            function bundleControl(bundle, type, action = 'get', newItems = null) {
                for(var i in bundle) {
                    if(bundle[i].name != type) continue;
                    if(action == 'set') {
                        bundle[i].items = newItems;
                        return bundle;
                    }
                    else {
                        return bundle[i].items;
                    }
                }
            }
        },

        setActionType(action) {
            this.actionType = action;
        },

        getLinkItems() {
            // this.linkItems = linkItems;
            return this.linkItems;
        },

        dragContainerToggle(className, dragClass = 'drag-container') {
            $('.' + dragClass).hide();
            // $('.drag-container').css({'display': 'none'});
            $('.' + className).show();
            $('.items-button-toggle').css({'background': 'none', 'color' : 'white'});
            $('#control-button-' + className).css({'background': 'burlywood', 'color' : 'white'});
        },

        // --- ОБРАБОТКА ПОСЛЕ СОХРАНЕНИЯ (emit)
        toUpdateItem(data) {

            var itemId = data.id;   // при добавлении нового здесь будет 0
            var item   = data.item; // item для сохранения
            var action = data.action;
            var params = data.params;
            var type   = params.type;

            this.getCoreSettings(() => {
                this.createObjectsBundle();
                var findItem  = this.findObjectsBundle(type, itemId);
                if(action != 'add') {  // --- после обновления
                    this.dropElementsUpdate(type, itemId, findItem);
                    return true;
                }

                // --- после добавления нового itema
                switch (type) {
                    case 'queue' :
                    case 'group' :
                         itemId = item['account'];
                         this.addNewItemToCanvas(type, itemId);
                         break;

                    case 'user'  :
                         itemId = item['extension'];
                         this.addNewItemToCanvas(type, itemId);
                         break;

                    case 'trunk' :
                         var usercontext = item['usercontext'];
                         item   = this.searchArr(this.trunks, 'usercontext', usercontext);
                         itemId = item['trunkid'];
                         this.addNewItemToCanvas(type, itemId);
                        //--- СОЗДАЕМ ИСХОДЯЩИЙ МАРШРУТ
                         this.addOutRouteLine({ id : itemId, type },
                                              () => { infoPanelRun(['Исходящий маршрут создан'], 'ok') });
                         break;

                    case 'ivr'   :
                         var itemName = item['name'];
                         item = this.searchArr(this.ivrItems, 'name', itemName);
                         itemId = item['id'];
                         this.addNewItemToCanvas(type, itemId);
                         break;
                }
            });

            // alertMessageShow('Успешное сохранение');
        },

        dropElementsUpdate(type, itemId, item) {
            // var id   = data.id;
            // var item = data.item;
            // var params = data.params;
            // var type   = params.type;
            // var item  = this.findObjectsBundle(type, id);

            for(var i in this.dropElementItems) {
                var obj = this.dropElementItems[i];
                if(obj.id == itemId && obj.type == type) {
                    this.dropElementItems[i]['item'] = item;
                }
            }
        },

        dropElementsDelete(type, itemId) {
            var elemArr = this.dropElementItems;
            var newElemArr = [];
            for(var i in elemArr) {
                var dropItem = elemArr[i];
                if(dropItem.id != itemId && dropItem.type != type) {
                    newElemArr.push(dropItem);
                }
            }
            this.dropElementItems = newElemArr;
        },

        setDinamicComponentName(itemType = '') {
            if(!itemType) itemType = this.itemType;
            this.dynamicComponent = itemType + '-controller';
            return this.dynamicComponent;
        },

        // --- УДАЛЯЕМ СВЯЗЬ ИЗ БАЗЫ ДАННЫХ
        linkDeleteDb(sourceData, targetData, connect) {
            var extNum = connect.canvas.nextSibling.innerHTML; // Получаем номер точки соединения
            switch (sourceData.type) {
                case 'ivr'   :
                    this.ivrLinkDelete(sourceData, targetData, extNum);  // Удаляем связь в базе
                    break;

                case 'group' :
                    this.groupLinkDelete(sourceData, targetData);  // Удаляем связь в базе
                    break;

                case 'queue' :
                    this.queueLinkDelete(sourceData, targetData, extNum);  // Удаляем связь в базе
                    break;

                case 'trunk' :
                    this.trunkLinkDelete(sourceData, targetData);  // Удаляем связь в базе
                    break;

                case 'user' :
                    this.userContextDelete(sourceData, targetData);     // Удаляем связь в базе
                    break;
            }
        },

        // --- ЗАПИСЫВАЕМ СВЯЗЬ В БАЗУ ДАННЫХ
        linkUpdateDb(sourceData, targetData, info) {
            var newLabel = '';
            var nextElem = info.sourceEndpoint.canvas.nextElementSibling;
            switch (sourceData.type) {
                case 'ivr'   :
                    var extNum  = this.getLinkNumber(nextElem);          // Получаем номер точки соединения
                    this.ivrLinkUpdate(sourceData, targetData, extNum);  // Обновляем связь в базе
                    newLabel = extNum;
                    break;

                case 'group' :
                    this.groupLinkUpdate(sourceData, targetData);  // Обновляем связь в базе
                    break;

                case 'queue' :
                    var extNum  = this.getLinkNumber(nextElem);           // Получаем номер точки соединения
                    this.queueLinkUpdate(sourceData, targetData, extNum); // Обновляем связь в базе
                    newLabel = extNum;
                    break;

                case 'trunk' :
                    this.trunkLinkUpdate(sourceData, targetData);     // Обновляем связь в базе
                    break;

                case 'user' :
                    if(targetData.type = 'trunk') {
                        this.userContextUpdate(sourceData, targetData) // Обновляем связь в базе
                    }
                    break;

            }
            return newLabel;
        },

        //--  РЕДАКТИРУЕМ СВЯЗЬ (ОБЪЕКТ ОПРЕДЕЛЯЕТСЯ ДИНАМИЧЕСКИ)
        editItemLink(item, params) {
            var saveLink = false;
            this.isComponentState = false;
            var type      = params.typeName;
            this.itemType = params.typeName;
            this.setDinamicComponentName();
            this.actionType  = 'edit_link';
            this.item     = item;
            this.itemUid  = item[params.uid];
            this.connections = this.getConnections();
            this.itemParams = params;
            this.params     = params;
            this.itemParams['connections'] = this.connections;
            this.itemParams['links']       = this.links;

            switch(type) {
                case 'ivr'   :
                case 'queue' :
                    this.item = this.editItemFormatted(item, type);
                    saveLink = true;
                    break;

                case 'group' :
                    this.item = this.editItemFormatted(item, type);
                    this.item['action'] = "edtGRP";
                    saveLink = true;
                    break;
            }

            if(saveLink) {
                this.save(type);
            }
        },

        //--  ОТКРЫВАЕМ МОДАЛЬНОЕ ОКНО ДЛЯ РЕДАКТИРОВАНИЯ
        //   (ВЫЗЫВАЕМ ДИНАМИЧЕСКИЙ КОМПОНЕНТ)
        editItemModal(item, params) {

            this.links  = {};
            this.actionType  = 'edit';
            this.isComponentState = false;
            var modalPermit = false;

            var type = params.typeName;
            this.itemType = params.typeName;

            this.item     = item;
            this.connections = this.getConnections();

            var itemId   = item[params.uid];
            this.itemUid = itemId;

            this.itemParams = params;
            this.params     = params;
            this.itemParams['connections'] = this.connections;
            this.itemParams['links']       = this.links;

            var modalId = this.getItemModalId(this.itemType);
            // var modalId = 'modal-edit-item-' + this.itemType;

            this.setDinamicComponentName();

            switch(type) {
                case 'group' :
                    this.item = this.editItemFormatted(item, type);
                    item['action'] = "edtGRP";
                    modalPermit = true;
                    break;


                case 'queue' :
                    this.item = this.editItemFormatted(item, type);
                    modalPermit = true;
                    break;

                case 'ivr'   :
                case 'trunk' :
                    this.item = this.editItemFormatted(item, type);
                    modalPermit = true;
                    break;

                case 'user' :

                    this.userEditInfoForm(itemId, item, type);

                    // this.getUserRecordInfo(itemId).then(respData => {
                    //     this.getUserInfo(itemId, 'edit', (userInfo) => {
                    //         for(var fieldName in respData) {
                    //             var respValue = respData[fieldName];
                    //             userInfo[fieldName] = respValue;
                    //         }
                    //         this.item = this.editItemFormatted(userInfo, type);
                    //         this.item['followMeList'] = item['followMeList'];
                    //         this.item.customcontext = this.item.devinfo_context;
                    //     });
                    // });

                    modalPermit = true;
                    break;
            }

            // lg({i : item, res : this.item});

            if(!modalPermit) return false;
            this.isComponentState = true;
            setTimeout(() => {
                $('#' + modalId).modal("show");
            }, 50);
        },

        addItemModal(bundle) {

            var params = bundle.params;
            var items  = bundle.items;
            var type   = params.type;

            this.itemUid = 0;
            this.isComponentState = false;
            var modalPermit = false;

            this.connections = this.getConnections();

            this.itemParams = params;
            this.itemType = type;
            this.actionType = 'add';

            this.setDinamicComponentName();

            var modalId = this.getItemModalId(type);

            switch(this.itemType) {
                case 'ivr'   :
                    this.item = this.getIvrModel();
                    this.setNewIvrItem(params);
                    modalPermit = true;
                    break;

                case 'group' :
                    this.item = this.getGroupModel();
                    this.setNewGrpItem(params);
                    modalPermit = true;
                    break;

                case 'queue' :
                    this.item = this.getQueueModel();
                    this.setNewQueueItem(params);
                    modalPermit = true;
                    break;

                case 'user'  :
                    this.item = this.getUserModel();
                    this.setNewUserItem(params);
                    modalPermit = true;
                    break;

                case 'trunk' :
                    this.item = this.getTrunkModel();
                    this.setNewTrunkItem(params);
                    modalPermit = true;
                    break;
            }

            if(!modalPermit) return false;

            this.isComponentState = true;

            setTimeout(() => {
                $('#' + modalId).modal("show");
            }, 50);

        },

        plumControllerReady(params = null) {
            this.getJsPlumb().ready(this.jsPlumStart);
        },

    },

    mounted(){

        setTimeout(() => {
            this.plumControllerReady();
            this.dragContainerToggle('queues-drag-box');
            $(document).ready(function() {});
            // this.renderAsHtml();
        }, 200);

        this.getEventGlobalBusOn('new_drop_elements_run', data => {
            setTimeout(() => {
                this.newDropElementsInitInPlum();   // --- ИНИЦИАЛИЗИРУЕМ ЕЛЕМЕНТ в jsPlum
            }, 50);
        });
    }

});

