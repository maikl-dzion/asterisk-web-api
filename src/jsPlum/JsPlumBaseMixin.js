
const JsPlumBaseMixin = {

    data: function() {

        var labelText = '';

        var connectionOverlays = [
            [ "Arrow",
                {
                    location: 1,
                    visible:true,
                    id: "arrow",
                    width  : 11,
                    length : 11,
                    foldback : 0.8,
                    events:{
                        // click: () => { alert("вы нажали на стрелку наложения") },
                    },
                }
             ],
             [ "Label",
                {
                    location: 0.1,
                    label: labelText,
                    id: "label",
                    cssClass: "aLabel",
                    events:{
                        // tap:() => { alert("hey"); },
                    },
                }
             ]
        ];

        var connectorTypeArr = [
            "Flowchart",
            "Bezier",
            "Straight",
            "StateMachine",
        ];

        var connectorParams =  [connectorTypeArr[0], {
                                    // stub        : [90, 90],
                                    // gap         : 11,
                                    // cornerRadius: 19,
                                    // curviness   : 180,
                                    // midpoint    : 0.2,
                                    // alwaysRespectStubs: true,

                                  stub: [40, 60],
                                  gap: 10,
                                  cornerRadius: 12,
                                  curviness : 150,
                                  alwaysRespectStubs: false,

                                }];

        var endpointDefaultParam = {
            endpoint  : ["Dot", {
                          radius: 12,
                          cssClass   : 'dotPointDefaultClass',
                          hoverClass : 'dotPointDefaultHover'
                        }],

            paintStyle: {  //-- цвет точки background
                fill : 'green',
                stroke:"green",
                strokeWidth:1,
            } ,

            connectorStyle: { // --цвет и толщина линии
                stroke: 'green',
                strokeWidth: 2
            },

            overlays: [
                [ "Label", {
                   label:"",
                   id:"label",
                   location:[0.5, 0.5],
                   cssClass:"defaultLabelClass"
                }],
            ],

            scope     : "blue",
            connector : ["Flowchart"],
            ConnectionOverlays : connectionOverlays,
            maxConnections: -1,

            // parameters: {
            //     "p1":34, "p2":new Date(),
            //     "p3":() => { var t = 'test' }
            // }

            // dropOptions: exampleDropOptions,
        };

        var pointSourceDefault = this.objAssign(endpointDefaultParam);
        pointSourceDefault['isSource'] = true;
        // pointSourceDefault['paintStyle'] = { fill : 'green' };

        var pointTargetDefault = this.objAssign(endpointDefaultParam);
        pointTargetDefault['isTarget'] = true;
        pointTargetDefault['paintStyle'] = { fill : 'orange' };

        return {
            endpointDefaultParam,
            pointSourceDefault,
            pointTargetDefault,
            connectorParams,
            connectionOverlays,
        }

    }, // --- DATA

    methods: {

        getJsPlumb(){
            return jsPlumb;
        },

        getInstance(){
            return instance;
        },

        clearInstance(){
            instance = {};
            return instance;
        },

        getPlumInstance(args = null) {
            return this.getJsPlumb().getInstance(args);
        },

        getConnections() {
            var inst = this.getInstance();
            this.connections = inst.getConnections();
            return this.connections;
        },

        getElemDataAttr(elemId, elem = null){
            var type   = getAttr(elemId, 'data-type');
            var uid    = getAttr(elemId, 'data-id');
            var state  = getAttr(elemId, 'data-drag-state');
            var item   = getAttr(elemId, 'data-item');
            var params = getAttr(elemId, 'data-params');

            return {
                 uid,
                 type,
                 item,
                 state,
                 params  ,
                 id : uid,
                 itemType : type,
            }
        },

        // --- СОЗДАНИЕ НОВОГО ДИВА
        getCreateDiv(className, id = '', args = null){
            var container  = document.createElement("div");
            if(!id) id = jsPlumbUtil.uuid();
            container.id = id;
            container.className = className;
            return container;
        },

        // --- ПОИСК И ПОДГРУЗКА ЕЛЕМЕНТА
        getElementsSelect(selector){
            var elements = jsPlumb.getSelector(selector);
            return elements;
        },

        // --- ВОЗВРАТ ЕЛЕМЕНТА НА СТАРОЕ МЕСТО
        setOldPosition(curElem){
            var type = getAttr(curElem.id, 'data-type');
            if(type != 'ivr') type = type + 's';
            var selector = '.' +type+ '-drag-box';
            var parent = document.querySelector(selector);
            parent.appendChild(curElem);

            curElem.style.position = 'relative';
            curElem.style.left = '0px';
            curElem.style.top  = '0px';
            //curElem.style.marginLeft = '20px';
            //curElem.style.marginTop = '20px';
        },


        getLinkNumber(nextElem) {
            var num = '';
            var classList = nextElem.classList;
            for(var i in classList) {
                if(classList[i] == 'jtk-overlay') {
                    num = nextElem.innerHTML;
                    break;
                }
            }
            return num;
        },

        // --- УДАЛЕНИЕ СВЯЗИ
        deleteLink(connect){
            var connectId = connect.id;
            var sourceId  = connect.sourceId;
            var targetId  = connect.targetId;

            var sourceData = this.getElemDataAttr(sourceId);
            var targetData = this.getElemDataAttr(targetId);

            this.linkDeleteDb(sourceData, targetData, connect); // УДАЛЯЕМ СВЯЗЬ В БАЗЕ

            delete this.linkItems[connectId];
            instance.deleteConnection(connect);
        },

        // --- ДОБАВЛЕНИЕ НОВОЙ СВЯЗИ
        addLink(info) {

            var sourceId  = info.sourceId;
            var targetId  = info.targetId;
            var connectId = info.connection.id;

            var sourceData = this.getElemDataAttr(sourceId);
            var sourceUid  = sourceData.id;
            var sourceType = sourceData.type;

            var targetData = this.getElemDataAttr(targetId);
            var targetUid  = targetData.id;
            var targetType = targetData.type;

            var newLabel = this.linkUpdateDb(sourceData, targetData, info); // ИЗМЕНЯЕМ СВЯЗЬ В БАЗЕ

            var link = {
                connectId ,
                sourceId  ,
                targetId  ,
                sourceType,
                targetType,
                sourceUid ,
                targetUid ,
            };

            this._set(this.linkItems, connectId, link);
            info.connection.getOverlay("label").setLabel(newLabel);
        },


        // // --- ДОБАВИТЬ НОВЫЙ ОБЪЕКТ
        // addElem(x, y) {
        //
        //     var div  = document.createElement("div");
        //     var id = jsPlumbUtil.uuid();
        //     var className = 'atc-icon-users col-md-3 col-sm-6 col-xs-12 dragItemsStyle dragItem jtk-draggable jtk-endpoint-anchor';
        //
        //     var innerHtml = `
        //        <div class="info-block">
        //            <div>Внутрений номер</div>
        //            <div>user-679</div>
        //            <div>679</div>
        //        </div>
        //     `;
        //
        //     div.id = id;
        //     div.className = className;
        //     div.innerHTML = innerHtml;
        //     div.style.position = "absolute";
        //     div.style.left = x + "px";
        //     div.style.top  = y + "px";
        //
        //     div.dataset.id   = "679";
        //     div.dataset.type = "user";
        //
        //     instance.getContainer().appendChild(div);
        //
        //     this.initElemDefault(div);
        //
        //     return div;
        // },


        // --- ИНИЦИАЛИЗИРОВАТЬ СВЯЗЬ
        initConnect(params) {
            instance.connect({
                source: params.source ,
                target: params.target ,

                type:"basic",
                // paintStyle:{ strokeWidth:2, stroke:"rgb(92, 150, 188)" },
                paintStyle : { strokeWidth:2, stroke:"rgb(92, 150, 188)" },
                // connector:"Bezier",
                // anchors:[ "BottomCenter", "TopCenter" ],
            });
        },

        // --- ИНИЦИАЛИЗИРОВАТЬ СВЯЗЬ ПО UUID
        initConnectUuid(sourceUuid, targetUuid) {
            instance.connect({ uuids:[sourceUuid, targetUuid] });
        },

        // --- УСТАНАВЛИВАЕМ МНОЖЕСТВЕННЫЕ ТОЧКИ СВЯЗЕЙ
        setMapPointSource(currentElem, positions) {
            var num = 0;
            var pointSource= Object.assign({}, this.pointSourceDefault);
            pointSource['maxConnections'] = 1;
            pointSource['paintStyle']['fill'] = 'none';

            var addPointArr = [];
            for(var i in positions) {
                num++;
                var x = positions[i];
                pointSource['overlays'][0][1]['label'] = num.toString();

                var point = instance.addEndpoint(
                    currentElem,
                    {
                        anchor: [x, 1.1, 0, 0],
                        connector : this.connectorParams,
                        parameters:{ "num": num },
                        uuid: currentElem +'-num-'+ num,
                    },
                    pointSource,
                );

                addPointArr[num] = point;
            }

            return addPointArr;
        },


        setForwardingCall(currentElem, itemsArr, itemParam) {
            var item = this.searchArr(itemsArr, 'extension', itemParam.id);
            var tel = '';
            try {
                if(item['followMeList'].tel)
                   tel = item['followMeList'].tel;
            }catch (e) {
                return false;
            }

            var div = document.createElement('div');
            div.className = "userCallForwarding";
            div.innerHTML = `<div style="padding-top:6px;float:left;" >${tel}</div>
                             <i class="material-icons" style="color:brown; float:right;">subdirectory_arrow_left</i>
                             <div style="clear:both" ></div>`;
            var parent = getElem(currentElem);
            parent.appendChild(div);
        },


        // jsPlumb.getConnections({}).forEach(function (conn) {
        //     jsPlumb.detach(conn);
        // });
        //
        // jsPlumb.selectEndpoints({}).each($.proxy(function (ele) {
        //     var uuid = ele.getUuid();
        //     jsPlumb.deleteEndpoint(uuid);
        // }, this));
        //
        // elemSearchInBundle(elemNumber) {
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
        //
        // // --- СОЗДАТЬ НОВЫЙ ОБЪЕКТ
        // createNewElem(pos, data, event = null) {
        //
        //     var item   = data.item;
        //     var itemId = data.itemId;
        //     var params = data.params;
        //     var itemName = item[params.name];
        //     var infoClass = this.infoClass;
        //
        //     var x = pos.x;
        //     var y = pos.y;
        //
        //     var div  = document.createElement("div");
        //     var id   = jsPlumbUtil.uuid();
        //     var className = params.iconClass + ' ' + this.itemClass;
        //
        //     var innerHtml = `
        //        <div class="${infoClass}" >
        //           <div >${params.title}</div>
        //           <div >${itemName}</div>
        //           <div >${itemId}</div>
        //        </div>
        //     `;
        //
        //     div.id = id;
        //     div.className = className;
        //     div.style.position = "absolute";
        //     div.style.left = x + "px";
        //     div.style.top  = y + "px";
        //
        //     div.dataset.id   = itemId;
        //     div.dataset.type = params.typeName;
        //     div.dataset.dragState = "drag";
        //
        //     div.innerHTML = innerHtml;
        //
        //     instance.getContainer().appendChild(div);
        //
        //     this.initElemDefault(div);
        //
        //     return div;
        // },

        // --- DRAG-СТАТУС ЕЛЕМЕНТА
        // drop - находиться в работе,в зоне canvas
        // drag  или  false - не в работе
        checkElemActionStatus(elemId, dragState = 'drop') {
            var stateValue = getAttr(elemId, 'data-drag-state');
            if(stateValue && stateValue == dragState) {
                return stateValue;
            }
            return false;;
        },


        // --- ЗАГРУЖАЕМ ЕЛЕМЕНТЫ
        elementsLoader(elements, loadType = 'drag', params = null) {
            switch(loadType) {
                case 'drag' :
                    for (var i = 0; i < elements.length; i++) {
                        var element = elements[i];
                        this.initDragElementInPlum(element);
                    }
                    break;

                case 'drop' :
                    for (var i = 0; i < elements.length; i++) {
                        var element = elements[i];
                        this.initDropElementInPlum(element);
                    }
                    break;
            }
        },

    },//  --- METHODS

}

