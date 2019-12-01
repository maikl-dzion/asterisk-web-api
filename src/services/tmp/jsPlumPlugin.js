

const JsPlumPlugin = {
    install(Vue, options) {
        //Vue.component(MyComponent.name, MyComponent)

        Vue.mixin({

            data: function () {
                return {
                   containerIdent : 'canvas',
                   dropZoneState  : false,
                   // objClassName   : '.statemachine-demo .item-box',
                   objClassName   : '.statemachine-demo ._object-box',
                   canvas  : {} ,
                   windows : {} ,
                   plumInstance : {},
                   jsPlumb : {},

                   label_ : '',
                }
            },

            methods: {

                dragZoneMove(event) {
                    //this.dropZoneState = true;
                    event.target.style.border = '2px grey dotted';
                },

                dragZoneOut(event) {
                    //this.dropZoneState = false;
                    event.target.style.border = '2px white dotted';
                },

                dragInstanceInit(dragContainerIdent = null) {

                    if(!dragContainerIdent)
                        dragContainerIdent = 'drag-objects-container';

                    var jsPlumb = this.getJsPlumb();
                    var instance = jsPlumb.getInstance({
                        Container: dragContainerIdent
                    });

                    var loadDragItem = (elem) => {
                        instance.draggable(elem, {
                            drag: (e) => {
                                elem.style.position = 'absolute';
                            },
                            start : (e) => {
                                var el = elem;
                            },
                            stop : (e) => {
                                // elem.style.position = 'absolute';
                                // elem.style.display = 'none';
                                // var dropZone = this.dropZoneState;
                                // elem.style.display = 'block';
                                // var cont = e.e.target.closest('#canvas');
                            },
                            // containment: 'dragContainerElements',
                            // scope : "container-construct-elem",
                        });
                    };

                    var windows = jsPlumb.getSelector('.dragItem');

                    instance.batch(() => {
                        for (var i = 0; i < windows.length; i++) {
                            loadDragItem(windows[i]);
                        }
                    });

                    jsPlumb.fire("jsPlumbDraggableLoaded", instance);
                },


                dropZoneInit(containerIdent = null) {

                    if(!containerIdent)
                        containerIdent = 'dropZoneContainer';

                    var jsPlumb = this.getJsPlumb();
                    var instance = jsPlumb.getInstance({
                        Container: dragContainerIdent
                    });

                    instance.batch(() => {
                        var dropElem = jsPlumb.getSelector('#' + containerIdent);
                        instance.droppable(dropElem, {
                                drop : (event) => {
                                    this.dropZoneState = true;
                                    // dropElem.style.border = '4px red solid;';
                                },
                                 //start : (event) => {var e = event;},
                                 //stop  : (event) => {var e = event;}
                        });
                    });

                    jsPlumb.fire("jsPlumbDroppableLoaded", instance);
                },



                plumInstanceInit() {

                    var jsPlumb = this.getJsPlumb();
                    this.jsPlumb = jsPlumb;

                    this.plumInstance = jsPlumb.getInstance({
                        //isSource:true,
                        //isTarget:true,
                        Endpoint: ["Dot", {radius: 5}],
                        Connector:"Flowchart",
                        HoverPaintStyle: {stroke: "#1e8151", strokeWidth: 2 },
                        ConnectionOverlays: [
                            [ "Arrow", {
                                location: 1,
                                id: "arrow",
                                length: 14,
                                foldback: 0.8
                            } ],
                            [ "Label", { label: this.label_, id: "label", cssClass: "aLabel" }]
                        ],

                        Container: this.containerIdent
                    });

                    var connectorParam =  ["Flowchart", {
                                             stub: [40, 60],
                                             gap: 10,
                                             cornerRadius: 5,
                                             alwaysRespectStubs: true
                                           }];
                    this.plumInstance
                        .registerConnectionType(
                            "basic", {
                              anchor:"Continuous",
                              connector : connectorParam
                            }
                        );

                    this.canvas  = document.getElementById(this.containerIdent);
                    this.windows = jsPlumb.getSelector(this.objClassName);
                    window['jsp'] = this.plumInstance;

                    this.plumInstance.bind("click", this.deleteConnect);
                    this.plumInstance.bind("connection", this.addConnect);

                    this.batch();

                    jsPlumb.fire("jsPlumbDemoLoaded", this.plumInstance);
                },

                batch() {
                    this.plumInstance.batch(() => {
                        for (var i = 0; i < this.windows.length; i++) {
                            this.initElem(this.windows[i], true);
                        }
                    });
                    this.containerDroppable();
                },

                containerDroppable() {
                    var dropElem = jsPlumb.getSelector('#dropZoneContainer');
                    this.plumInstance.droppable(dropElem, {
                        drop : (event) => {
                            this.dropZoneState = true;
                            // dropElem.style.border = '4px red solid;';
                        },
                        //start : (event) => {var e = event;},
                        //stop  : (event) => {var e = event;}
                    });
                },

                // --- ИНИЦИАЛИЗАЦИИ ОБЪЕКТА
                initElem(elem){

                    // this.plumInstance.draggable(elem, {});

                    this.plumInstance.draggable(elem, {
                        drag: (event) => {
                            elem.style.position = 'absolute';
                        },
                        start : (event) => {
                            var e = event;
                        },
                        stop : (event) => {
                            var e = event;
                            elem.style.display = 'none';
                            var cont = e.target.closest('#canvas');
                        },
                        // containment: 'dragContainerElements',
                        // scope : "container-construct-elem",
                    });

                    this.plumInstance.makeSource(elem, {
                        filter: ".ep",
                        anchor: "Continuous",
                        connectorStyle: { stroke: "#5c96bc", strokeWidth: 2, outlineStroke: "transparent", outlineWidth: 4 },
                        connectionType:"basic",
                        extract:{
                            "action":"the-action"
                        },
                        maxConnections: -1,
                        onMaxConnections: function (info, e) {
                            alert("Maximum connections (" + info.maxConnections + ") reached");
                        }
                    });

                    this.plumInstance.makeTarget(elem, {
                        dropOptions: { hoverClass: "dragHover" },
                        anchor: "Continuous",
                        allowLoopback: true
                    });

                    this.plumInstance.fire("jsPlumbDemoNodeAdded", elem);
                },


                // --- ДОБАВИТЬ НОВЫЙ ОБЪЕКТ
                addElem (x, y){
                    var div = document.createElement("div");
                    var id  = jsPlumbUtil.uuid();
                    div.className = "item-box";
                    div.id = id;
                    var substr = id.substring(0, 7);
                    div.innerHTML  = `<div class="ep"></div>`;
                    div.style.left = x + "px";
                    div.style.top  = y + "px";
                    this.plumInstance.getContainer().appendChild(div);
                    this.initElem(div);
                    return div;
                },

                deleteConnect(connect) {
                    var sourceId = connect.sourceId;
                    delete this.linkItems[sourceId];
                    this.formConnectionArray(sourceId, 'del', connect);
                    this.plumInstance.deleteConnection(connect);
                },

                addConnect(info) {

                    var sourceId = info.sourceId;
                    var targetId = info.targetId;
                    // var newLabel = info.connection.id;
                    var newLabel = '';
                    var link = {
                        'source': sourceId,
                        'target': targetId,
                    };
                    this.formConnectionArray(link, 'add');
                    info.connection.getOverlay("label").setLabel(newLabel);

                },

                formConnectionArray(data, type, param = null) {
                    switch(type) {
                        case 'add' :
                            this.connectionItems.push(data);
                            break;

                        case 'del' :
                            for(var key in this.connectionItems) {
                                var item = this.connectionItems[key];
                                if(data == item['source']) {
                                    delete this.connectionItems[key];
                                }
                            }
                            break;
                    }
                },







                jsPlumRun(){

                    var linkLabel   = '';
                    var newElements = [];
                    var jsPlumb = this.getJsPlumb();

                    var instance = jsPlumb.getInstance({
                        //isSource:true,
                        //isTarget:true,
                        Endpoint: ["Dot", {radius: 5}],
                        Connector:"Flowchart",
                        HoverPaintStyle: {stroke: "#1e8151", strokeWidth: 2 },
                        ConnectionOverlays: [
                            [ "Arrow", {
                                location: 1,
                                id: "arrow",
                                length: 14,
                                foldback: 0.8
                            } ],
                            [ "Label", { label: linkLabel, id: "label", cssClass: "aLabel" }]
                        ],

                        Container: "canvas"
                    });

                    var connectorParam =  ["Flowchart", { stub: [40, 60], gap: 10, cornerRadius: 5, alwaysRespectStubs: true } ];
                    instance.registerConnectionType("basic", { anchor:"Continuous", connector : connectorParam });

                    var canvas  = document.getElementById("canvas");
                    var windows = jsPlumb.getSelector(".statemachine-demo .item-box");
                    window.jsp = instance;


                    var getCreateDiv = (className, id = '', args = null) => {
                        var container  = document.createElement("div");
                        if(!id) id = jsPlumbUtil.uuid();
                        container.id = id;
                        container.className = className;
                        return container;
                    };

                    // --- УДАЛЕНИЕ СВЯЗИ
                    var deleteLink = (connect) => {
                        var sourceId = connect.sourceId;
                        delete this.linkItems[sourceId];
                        instance.deleteConnection(connect);
                    };

                    // --- ДОБАВЛЕНИЕ НОВОЙ СВЯЗИ
                    var addLink = (info) => {
                        var sourceId = info.sourceId;
                        var targetId = info.targetId;
                        // var newLabel = info.connection.id;
                        var newLabel = '';
                        var link = {
                            'source' : sourceId,
                            'target' : targetId,
                        };
                        this.linkItems[sourceId] = link;
                        info.connection.getOverlay("label").setLabel(newLabel);
                    };

                    // --- ДОБАВИТЬ НОВЫЙ ОБЪЕКТ
                    var addElem = (x, y) => {
                        var div  = document.createElement("div");
                        var id = jsPlumbUtil.uuid();
                        div.className = "item-box";
                        div.id = id;
                        div.innerHTML  = id.substring(0, 7) + "<div class=\"ep\"></div>";
                        div.style.left = x + "px";
                        div.style.top  = y + "px";
                        instance.getContainer().appendChild(div);
                        initElem(div);
                        return div;
                    };

                    // --- ЗАГРУЗИТЬ ОБЪЕКТ
                    var loadElem = (left, top, params, row) => {
                        // var itemsContainer = document.getElementById('trunks-container');
                        var title   = params.title;
                        var name    = row[params.name];
                        var rowNum  = '';
                        if(params.num) {
                            rowNum = row[params.num];
                        }

                        var div  = document.createElement("div");
                        var id = jsPlumbUtil.uuid();
                        div.id = id;
                        div.className = params.iconClass + " item-box";
                        var dataId=row[params.uid];
                        var dataType=params.typeName;
                        div.setAttribute('data-id', dataId);
                        div.setAttribute('data-type', dataType);
                        var linkCont = `<div class="ep link-point"></div>`;
                        var infoCont = `<div class="info-box">
                                    <div >${params.title}</div>
                                    <div >${row[params.name]}</div>
                                    <div >${rowNum}</div>
                                </div>`;
                        var innerHtml = linkCont + infoCont;
                        // var subStr    = id.substring(0, 7);
                        div.innerHTML  = innerHtml;
                        // div.style.marginLeft = x + "px";
                        // div.style.marginTop  = y + "px";

                        div.style.left = left + "px";
                        div.style.top  = top  + "px";

                        // var wrapper = getCreateDiv('wrapper-item-box');
                        // wrapper.appendChild(div);

                        var result = div;
                        return result;
                    };

                    var renderItems = (items, contClassName, coords, params) => {
                        var container = getCreateDiv(contClassName);
                        var headerDiv = getCreateDiv('objects-header');
                        var _nnerHtml =` <h3 >Заголовок</h3> `;
                        headerDiv.innerHTML = _nnerHtml;
                        container.appendChild(headerDiv);
                        var left = startLeft = coords.left;
                        var top  = startTop  = coords.top;
                        var ch   = 0;
                        for(var i in items) {
                            ch++;
                            var item = items[i];
                            var div  = loadElem(left, top, params, item);
                            newElements.push(div);
                            container.appendChild(div);
                            left = left + 150;
                            if(ch == 3) {
                                left = startLeft;
                                top = top + 120;
                                ch  = 0;
                            }

                        }
                        return container;
                    };

                    var loaderSystemObjects = () => {
                        var systemObjects = this.coreInfo;
                        var container = getCreateDiv('dragContainerElements', 'dragContainerElements');
                        for (var name in systemObjects) {
                            var items  = systemObjects[name];
                            var coords = { left : 13 , top : 75, };
                            var firstClassName = 'objects-container';
                            var className, classTitle = '';
                            var params    = {};
                            var countItems  = 0;
                            switch (name) {
                                case 'trunks' :
                                    params = this.trunkParams;
                                    classTitle = params.header;
                                    className  = params.typeName + 's-box';
                                    countItems = 1;
                                    break;

                                case 'users' :
                                    params = this.userParams;
                                    classTitle = params.header;
                                    className = params.typeName + 's-box';
                                    countItems = 1;
                                    break;
                            }

                            if(countItems) {
                                var names = { name : className, title : classTitle };
                                this.objContainerNames.push(names);
                                firstClassName += ' ' + className;
                                var itemsCont = renderItems(items, firstClassName, coords, params);
                                container.appendChild(itemsCont);
                            }
                        }

                        return container;
                    }

                    // --- ИНИЦИАЛИЗИРОВАТЬ СВЯЗЬ
                    var initConnect = (params) => {
                        instance.connect({
                            source: params.source ,
                            target: params.target ,
                            // type:"basic",
                            paintStyle:{ strokeWidth:3, stroke:"rgb(92, 150, 188)" },
                            // connector:"Straight",
                            anchors:[ "BottomCenter", "TopCenter" ],
                        });
                    };

                    // --- ИНИЦИАЛИЗАЦИИ ОБЪЕКТА
                    var initElem = (el) => {

                        instance.draggable(el, {
                            drag: (event) => {
                                var ev = event;
                            },
                            start : (event) => {
                                // el.style.marginLeft = '';
                                // el.style.marginTop  = '';
                                //
                                // el.style.left = event.e.offsetY;
                                // el.style.top  = event.e.offsetX;

                                this.startLeft  = event.e.pageX;
                                this.startRight = event.e.pageY;

                            },
                            stop : (event) => {
                                if(!this.dropContainerState) {
                                    // event.drag.canDrag();
                                    // var elem = document.getElementById(event.el.id);
                                    // elem.style.left = this.startLeft;
                                    // elem.style.right = this.startRight;
                                }
                                else {
                                    instance.getContainer().appendChild(el);
                                    this.dropContainerState = false;
                                }
                            },
                            // containment: 'dragContainerElements',
                            // scope : "container-construct-elem",
                        });

                        instance.droppable(el, {
                            drop : (e) => {
                                var event = e;
                                var state = this.dropContainerState;
                            },
                            start : (e) => {
                                var event = e;
                            },
                            stop : (e) => {
                                var event = e;
                            },
                            // containment: 'dragContainerElements',
                        });

                        instance.makeSource(el, {
                            filter: ".ep",
                            anchor: "Continuous",
                            connectorStyle: { stroke: "#5c96bc", strokeWidth: 2, outlineStroke: "transparent", outlineWidth: 4 },
                            connectionType:"basic",
                            extract:{
                                "action":"the-action"
                            },
                            maxConnections: -1,
                            onMaxConnections: function (info, e) {
                                alert("Maximum connections (" + info.maxConnections + ") reached");
                            }
                        });

                        instance.makeTarget(el, {
                            dropOptions: { hoverClass: "dragHover" },
                            anchor: "Continuous",
                            allowLoopback: true
                        });

                        instance.fire("jsPlumbDemoNodeAdded", el);
                    };

                    this.initElemIn = function(el) {
                        initElem(el);
                    }

                    instance.bind("click", deleteLink);
                    instance.bind("connection", addLink);
                    instance.on(canvas, "dblclick", (e) => {
                        // addElem(e.offsetX, e.offsetY);
                    });

                    // instance.bind("endpointClick", (params) => {var p = params;});
                    // instance.bind("beforeDrop", (params) => {var p = params;});
                    // instance.bind("connectionDragStop", function(info){console.log(info.target.position())})

                    // --- Инициализация объектов
                    instance.batch(() => {

                        for (var i = 0; i < windows.length; i++) {
                            initElem(windows[i], true);
                        }

                        // var dragObjectsContainer = loaderSystemObjects();
                        // var dropContainer = getCreateDiv('dropContainerElements', 'dropContainerElements');
                        // instance.getContainer().appendChild(dragObjectsContainer);
                        // instance.getContainer().appendChild(dropContainer);
                        //
                        // for(var i in newElements) {
                        //     var newElem = newElements[i];
                        //     initElem(newElem);
                        // }

                        instance.droppable(jsPlumb.getSelector("#dropContainerElements"), {
                            drop  : (e) => {
                                this.dropContainerState = true;
                            },
                            //start : function(e) {var event = e; },
                            //stop  : function(e) {var event = e; }
                        });

                        instance.draggable(jsPlumb.getSelector("#dragContainerElements"), {
                            drag  : (e) => {var event = e; },
                            start : (e) => {var event = e; },
                            stop  : (e) => {var event = e; },
                        });
                        // instance.connect({ source: "trunk-34",  target: "user-22"  , type:"basic" });
                    });

                    jsPlumb.fire("jsPlumbDemoLoaded", instance);

                },

            },

            mounted() {

            },

        });  //  Mixin


    } //  install(Vue, options)
};  // const JsPlumPlugin



