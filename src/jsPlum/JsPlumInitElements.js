
const JsPlumInitElements = {

    data: function() {
        return {

        }
    }, // --- DATA

    methods: {

        // ############################################################
        // ############################################################
        // --- DRAG ЕЛЕМЕНТЫ  (Функции для работы с елементами ИЗ МЕНЮ)

        // --- ИНИЦИАЛИЗАЦИИ ОБЪЕКТА В КОНСТРУКТОРЕ
        initDropElementInPlum(el) {
            instance.draggable(el, this.dropElemSetEvents(el));
            instance.fire("jsPlumbDemoNodeAdded_2", el);
        },

        // --- ФУНКЦИИ ПЕРЕНОСА DROPPABLE ITEM
        dropElemSetEvents(el) {
            var dragStateName = 'drop';
            return {
                start : (event) => { var el = event.el; },
                drag  : (event) => { var curElem = event.el; },
                stop  : (event) => {

                    var curElem   = event.el;
                    var curElemId = curElem.id;
                    var _left = this.typeOfDigit(curElem.style.left);
                    var _top  = this.typeOfDigit(curElem.style.top);
                    var elParam = this.getElemDataAttr(curElemId);
                    var postData  = {
                        _left,
                        _top,
                        _type   : elParam.type,
                        item_id : elParam.id,
                    };

                    this.saveInfoObjectsDetails(postData)
                        .then(response => {
                            // lg(response);
                        });
                },
            }
        },

        elementFormattedStart(item, params) {
            var itemId = item[params.auto];
            var type   = params.type;
            var pos = { left : 520, top : 70 };
            var elParam = { id : itemId, type };

            switch (type) {
                case  'group' :
                case  'trunk' :
                case  'queue' :
                case  'ivr'   :

                    // this.getInfoObjectsDetails(itemId, type).then(response => {
                    this.getInfoObjectsDetails().then(response => {
                        if (Object.keys(response).length != 0) {
                            this.infoObjectsDetails = response;
                            this.objSetPositionStart = true;
                            this.newDropElementsAddToCanvas(elParam, pos); // --- ДОБАВЛЯЕМ ЕЛЕМЕНТ В ВИРТУАЛЬНЫЙ ДОМ VUE
                            this.setEventGlobalBus('new_drop_elements_run', {}); // --- АКТИВИРУЕМ В КОНСТРУКТОРЕ ЕЛЕМЕНТЫ ( JsPlum )
                        }
                        else {

                        }
                    });
                    break;
            }
        },

        // --- ИНИЦИАЛИЗАЦИИ ОБЪЕКТА ИЗ МЕНЮ
        initDragElementInPlum(el) {
            instance.draggable(el, this.dragElemSetEvents(el));
            instance.fire("jsPlumbDemoNodeAdded_1", el);
        },

        // --- ФУНКЦИИ ПЕРЕНОСА DRAGGABLE ITEM
        dragElemSetEvents(el) {
            var dragStateName = 'drop';
            return {

                start : (event) => { var el = event.el; },
                drag  : (event) => {  // --- ПРОЦЕСС ПЕРЕНОСА
                    var curElem = event.el;
                    curElem.style.position = 'absolute';
                    curElem.style.left = event.pageY;
                    curElem.style.top  = event.pageX;
                },
                stop : (event) => {  // --- КОНЕЦ ПЕРЕНОСА

                    // this.getInfoObjectsDetails(0).then(response => {
                           // lg(response);
                    // });

                    var curElem   = event.el;
                    var curElemId = curElem.id;
                    var left = this.typeOfDigit(curElem.style.left);
                    var top  = this.typeOfDigit(curElem.style.top);
                    var pos  = { left, top };

                    this.setOldPosition(curElem);
                    if(!this.dropZoneState) return false;

                    //-- ЕСЛИ НАХОДИМСЯ В ЗОНЕ КОНСТРУКТОРА
                    this.dropZoneState = false;
                    var elParam = this.getElemDataAttr(curElemId);

                    // --- ДОБАВЛЯЕМ ЕЛЕМЕНТ В ВИРТУАЛЬНЫЙ ДОМ VUE
                    this.newDropElementsAddToCanvas(elParam, pos, event);

                    // --- АКТИВИРУЕМ В КОНСТРУКТОРЕ ЕЛЕМЕНТЫ ( JsPlum )
                    this.setEventGlobalBus('new_drop_elements_run', {});

                    // setTimeout(() => {
                    //     this.newDropElementsInitInPlum();   // --- ИНИЦИАЛИЗИРУЕМ ЕЛЕМЕНТ в jsPlum
                    // }, 50);
                },
            }
        },


        // --- ДОБАВЛЯЕМ ЕЛЕМЕНТ В ВИРТУАЛЬНЫЙ ДОМ VUE
        newDropElementsAddToCanvas(elParam, pos, event = null, initType = 'global') {
            var type   = elParam.type;
            var itemId = elParam.id;
            var objectElem = {};
            var itemList   = [];
            var initState = false;

            switch(type) {

                case 'user'  :
                    initState  = true;
                    objectElem = this.addDropElement(elParam, pos, event);
                    break;

                case 'group' :
                    initState = true;
                    objectElem = this.addDropElement(elParam, pos, event);
                    if(objectElem.connect_state) return true;

                    var sourceElemId = objectElem.elem_id;
                    itemList = this.groupItemList(objectElem.item);
                    this.connectionsFormatted(itemList, pos, sourceElemId, type);
                    break;

                case 'queue' :
                    initState  = true;
                    objectElem = this.addDropElement(elParam, pos, event);
                    if(objectElem.connect_state) return true;

                    var sourceElemId = objectElem.elem_id;
                    itemList = this.queueItemList(objectElem.item);
                    this.connectionsFormatted(itemList, pos, sourceElemId, type);
                    break;

                case 'ivr' :
                    initState = true;
                    objectElem = this.addDropElement(elParam, pos, event);
                    if(objectElem.connect_state) return true;

                    var sourceElemId = objectElem.elem_id;
                    itemList = this.ivrItemList(objectElem.item);
                    this.connectionsFormatted(itemList, pos, sourceElemId, type);
                    break;

                case 'trunk' :
                    initState = true;
                    objectElem = this.addDropElement(elParam, pos, event);
                    if(objectElem.connect_state) return true;

                    var sourceElemId = objectElem.elem_id;
                    itemList = this.trunkItemList(objectElem.item);
                    // lg(itemList); return false;
                    this.connectionsFormatted(itemList, pos, sourceElemId, type);
                    break;
            }

            if(initState) {
                return { 'elem' : objectElem };
            }

            return false;
        },

        // --- ИНИЦИАЛИЗИРУЕМ ЕЛЕМЕНТ в jsPlum
        newDropElementsInitInPlum() {

                // setTimeout(() => {

                if(this.newDropElements.length){
                    for (var i in this.newDropElements) {

                        var objectElem = this.newDropElements[i];
                        var tagElementId = objectElem.elem_id;

                        this.initDropElementInPlum(tagElementId);
                        this.dropElementSetPoints(tagElementId, objectElem);
                    }
                }

                if(this.newConnectedParams.length) {

                    this.newDropConnectedStatus = true;

                    for (var i in this.newConnectedParams) {
                        var connItem = this.newConnectedParams[i];
                        var itemType = connItem.type;
                        var connect  = connItem.connect;
                        var connNum  = connItem.num;
                        switch(itemType) {
                            case 'ivr'   :
                            case 'queue' :

                                var sourceObj = this.searchArr(this.dropItemsPoints, 'el', connect.source);
                                var targetObj = this.searchArr(this.dropItemsPoints, 'el', connect.target);
                                // var sourceUuid = pointObj.getUuid();

                                var targetUuid = '';
                                for(var num in targetObj.targetArr) {
                                    var point = targetObj.targetArr[num];
                                    targetUuid = point.getUuid();
                                }

                                for(var num in sourceObj.sourceArr) {
                                    if(parseInt(connNum) != parseInt(num)) continue;
                                    var point = sourceObj.sourceArr[num];
                                    var sourceUuid = point.getUuid();
                                    this.initConnectUuid(sourceUuid, targetUuid);
                                }

                                break;

                            default :
                                this.initConnect(connect);
                                break;
                        }
                    }
                }

                this.objSetPositionStart    = false;
                this.newDropConnectedStatus = false;
                this.newDropElements = [];
                this.newConnectedParams = [];

                // }, 50);
        },


        _getItemPositions(elParam, pos) {

            if(!this.objSetPositionStart)
                return pos;

            var itemId = elParam.id;
            var type   = elParam.type;

            for(var i in this.infoObjectsDetails) {
                var info = this.infoObjectsDetails[i];
                if(info.item_id == itemId && info._type == type) {
                    return { left : info._left, top : info._top};
                }
            }

            return pos;
        },

        // --- ДОБАВЛЯЕМ НОВЫЙ ЕЛЕМЕНТ в МАССИВ (in Canvas)
        addDropElement(elParam, pos, event = null ,addType = 'global') {

                var objectElem = {};
                var itemId = elParam.id;
                var type   = elParam.type;
                pos = this._getItemPositions(elParam, pos);
                var left = pos.left;
                var top  = pos.top;

                var tagElementId = this.createIdDropElem(type, itemId);
                var itemBundle = this.getItemBundle(type, itemId);

                objectElem['id']   = itemId;
                objectElem['type'] = type;
                objectElem['left'] = left;
                objectElem['top']  = top;
                objectElem['elem_id'] = tagElementId;
                objectElem['item']   = itemBundle.item;
                objectElem['params'] = itemBundle.params;
                objectElem['bundle'] = itemBundle;
                objectElem['connect_state'] = false;

                if(this.isDropElement(itemId)) {
                    this.dropElementItems.push(objectElem);  // --- добавляем в массив елементов (на конструкторе)
                    this.newDropElements.push(objectElem);   // --- добавляем елемент в массив для инициализации в draggable и установки параметров
                }
                else {
                    objectElem['connect_state'] = true;
                }

                return objectElem;
        },


        // --- УСТАНАВЛИВАЕМ ТОЧКИ СОЕДИНЕНИЯ ПРИ ПЕРЕНОСЕ НА КОНСТРУКТОР
        dropElementSetPoints(currentElem, itemParam) {

            var pointTarget = Object.assign({}, this.pointTargetDefault);
            pointTarget['overlays'] = {};

            var pointSource = Object.assign({}, this.pointSourceDefault);
            pointSource['overlays'][0][1]['label'] = '';

            var anchorsSource  = { anchors: [0.5, 1, 0, 0], connector : this.connectorParams, };
            var anchorsTarget  = { anchors: [0.5, 0, 0, 0], uuid: currentElem, };
            var pointPositions = [-0.5, 0, 0.5, 1, 1.5];

            var pointsObject = {
                el : currentElem,
                type : itemParam.type,
                sourceArr : [],
                targetArr : [],
            }

            var sourcePointArr = [];
            var targetPointArr = [];
            var targetPoint = {};

            var multiPointFl = false;

            switch (itemParam.type) {
                case 'ivr' :
                    multiPointFl = true;
                    targetPoint    = instance.addEndpoint(currentElem, anchorsTarget ,pointTarget);
                    sourcePointArr = this.setMapPointSource(currentElem, pointPositions);
                    targetPointArr.push(targetPoint);
                    break;

                case 'group' :
                    multiPointFl = true;
                    targetPoint = instance.addEndpoint(currentElem, anchorsTarget, pointTarget);
                    var sp = instance.addEndpoint(currentElem, anchorsSource, pointSource);
                    sourcePointArr.push(sp);
                    targetPointArr.push(targetPoint);
                    break;

                case 'queue' :
                    // instance.addEndpoint(currentElem, anchorsSource, this.pointSourceDefault);
                    multiPointFl = true;
                    targetPoint = instance.addEndpoint(currentElem, anchorsTarget,pointTarget);
                    sourcePointArr = this.setMapPointSource(currentElem, pointPositions);
                    targetPointArr.push(targetPoint);
                    break;

                case 'trunk' :
                    pointSource['maxConnections'] = 1;
                    instance.addEndpoint(currentElem, anchorsSource, pointSource);
                    instance.addEndpoint(currentElem, anchorsTarget,pointTarget);
                    break;

                case 'user' :
                    multiPointFl = true;
                    targetPoint = instance.addEndpoint(currentElem, anchorsTarget,pointTarget);
                    targetPointArr.push(targetPoint);
                    this.setForwardingCall(currentElem, this.users, itemParam);
                    instance.addEndpoint(currentElem, anchorsSource, pointSource);

                default :
                    //instance.addEndpoint(currentElem, anchorsSource, pointSource);
                    //instance.addEndpoint(currentElem, anchorsTarget,pointTarget);
                    break;
            }


            if(multiPointFl) {
                pointsObject.sourceArr = sourcePointArr;
                pointsObject.targetArr = targetPointArr;
                this.dropItemsPoints.push(pointsObject);
            }
        },


        connectionsFormatted(itemList, pos, sourceElemId, type) {

            var newPos = {
                left : parseInt(pos.left + 120),
                top  : parseInt(pos.top),
            };

            var num = 0;

            // lg(itemList);  return false;

            for(var i in itemList) {
                num++;
                var list   = itemList[i];
                var listId = list.id;
                var listType = list.type;
                var result = this.findItemInBundle(listId, listType);
                // var result = this.findObjetsBundle(listType, listId);
                if(!result) continue;

                var listType = result.params.type;
                var listElementId    = this.createIdDropElem(listType, listId);
                var listDocumentItem = this.getElem(listElementId);

                var targetElemId = listElementId;
                if(!listDocumentItem) {
                    var listParam = {
                        type: listType,
                        id  : listId,
                    };
                    newPos.top = parseInt(newPos.top + 90);
                    var dropElem = this.newDropElementsAddToCanvas(listParam, newPos, event);
                    targetElemId = dropElem.elem.elem_id;
                }

                var connParams = {
                    source : sourceElemId,
                    target : targetElemId,
                };

                var connectObject = {
                    'num'     : num,
                    'type'    : type,
                    'connect' : Object.assign({}, connParams)
                };

                this.newConnectedParams.push(connectObject);
            }

            // return this.newConnectedParams;
        },

































        // // --- ДОБАВЛЯЕМ И АКТИВИРУМ ЕЛЕМЕНТ НА КОНСТРКУТОРЕ
        // addDropElement(elemParam, pos, event = null ,addType = 'item') {
        //
        //         var left = pos.left;
        //         var top  = pos.top;
        //         var itemId = elemParam.id;
        //         var type   = elemParam.type;
        //         var elementId = type + '-connect-drop-' + itemId;
        //
        //         var addItemState = false;
        //
        //         var item    = {};
        //         var objElem = {};
        //         var itemParams  = {};
        //         var items   = [];
        //
        //         objElem['id']   = itemId;
        //         objElem['type'] = type;
        //         objElem['left'] = left;
        //         objElem['top']  = top;
        //         objElem['elem_id'] = elementId;
        //
        //         for(var i in this.dropElementItems) {
        //             var el = this.dropElementItems[i];
        //             if(el.id == itemId) {
        //                 return false
        //             }
        //         }
        //
        //         switch(type) {
        //             case 'user' :
        //                 addItemState = true;
        //                 items = Object.assign({}, this.users);
        //                 itemParams = Object.assign({}, this.userParams);
        //                 break;
        //
        //             case 'group' :
        //                 addItemState = true;
        //                 items = Object.assign({}, this.ringGroups);
        //                 itemParams = Object.assign({}, this.groupParams);
        //
        //                 break;
        //
        //             case 'queue' :
        //                 addItemState = true;
        //                 items = Object.assign({}, this.queues);
        //                 itemParams = Object.assign({}, this.queueParams);
        //                 break;
        //
        //             case 'ivr' :
        //                 addItemState = true;
        //                 items = Object.assign({}, this.ivrItems);
        //                 itemParams = Object.assign({}, this.ivrParams);
        //                 break;
        //
        //             case 'trunk' :
        //                 addItemState = true;
        //                 items = Object.assign({}, this.trunks);
        //                 itemParams = Object.assign({}, this.trunkParams);
        //                 break;
        //
        //         }
        //
        //         if(!addItemState)  return false;
        //
        //         item = this.searchArr(items, itemParams.auto, itemId);
        //         objElem['item']   = item;
        //         objElem['params'] = itemParams;
        //         this.dropElementItems.push(objElem);  // добавляем елемент в общий массив
        //         this.elementConnectionsInit(elemParam, pos, objElem, event);
        //
        //         setTimeout(() => {
        //             this.initDropElementInPlum(elementId);   // инициализируем елемент
        //             this.dropElemSetParams(elementId, elemParam);
        //             if(this.newConnectedParams.length) {
        //                for(var i in this.newConnectedParams) {
        //                    var connectParams = this.newConnectedParams[i];
        //                    this.initConnect(connectParams);
        //                }
        //                this.newConnectedParams = [];
        //             }
        //
        //             // this.dropElemSetConnections(itemId, elemParam, event, pos);
        //         }, 50);
        //
        //         return objElem;
        // },

        elementConnectionsInit(params, pos, objElem, event) {
            var item = {};
            var itemList = [];

            var leftNum = parseInt(pos.left.replace(/[^\d]/g, '')) + 120;
            var topNum  = parseInt(pos.top.replace(/[^\d]/g, ''));

            var newPos = {
                left : leftNum + 'px',
                top  : topNum,
            };

            var connectParams = {
                 source : objElem.elem_id,
                 target : '',
            };

            var connectState = false;

            switch (params.type) {
                case 'group' :
                    item   = this.searchArr(this.ringGroups, this.groupParams.auto, params.id);
                    itemList = item.grplist.split('-');
                    for(var i in itemList) {

                        var subItemId = itemList[i];
                        var subItem = this.findItemInBundle(subItemId);

                        var elemParam = {
                            id   : subItemId,
                            type : subItem.params.typeName,
                        };

                        topNum = topNum + 100;
                        newPos.top = topNum + 'px';

                        var subObjElem = this.addDropElement(elemParam, newPos, event, 'sub');

                        connectParams.target = subObjElem.elem_id;

                        connectState = true;

                    }
                    break;

                case 'queue' :
                    item   = this.searchArr(this.queues, this.queueParams.auto, params.id);
                    itemList = item.ext_numbers;
                    for(var i in itemList) {
                        var tmp = itemList[i].split(',');
                        var subItemId = tmp[0];
                        var subItem = this.findItemInBundle(subItemId);

                        if(!subItem) continue;

                        var elemParam = {
                            id   : subItemId,
                            type : subItem.params.typeName,
                        };

                        topNum = topNum + 100;
                        newPos.top = topNum + 'px';

                        var subObjElem = this.addDropElement(elemParam, newPos, event, 'sub');
                        connectParams.target = subObjElem.elem_id;
                        connectState = true;

                    }
                    break;

            }

            if(connectState) {
                this.newConnectedParams.push(connectParams);
            }

        },


        // findItemInBundle(elemNumber) {
        //
        //     var itemId = 0;
        //     var params = {};
        //     var item   = {};
        //     var pos = elemNumber.indexOf("#");
        //     if(pos == -1) {  // --- user
        //         itemId = elemNumber;
        //         params = this.userParams;
        //         item   = this.searchArr(this.users, params.auto, itemId);
        //     }
        //     else {   // --- ivr group queue
        //         itemId = elemNumber.substring(0, pos);
        //         var itemsBundle = this.objectsBundle;
        //         var items = [];
        //         for(var i in itemsBundle) {
        //             items  = itemsBundle[i].items;
        //             params = itemsBundle[i].params;
        //             item = this.searchArr(items, params.auto, itemId);
        //             if (Object.keys(item).length != 0) {
        //                 return { item , params, itemId };
        //             }
        //         }
        //     }
        //
        //     if (Object.keys(item).length == 0) {
        //         return false;
        //     }
        //
        //     return { item , params, itemId };
        // },


    }, //  --- METHODS
}

