
var JsPlumController = {

    // mixins  : [JsPlumMixin],

    data: function() {
        return {

        }
    },

    methods: {

        jsPlumStart(){

            instance  = {};

            var containerIdName  = 'canvas';   //-- id основного контейнера
            var dragItemClass    = 'dragItem'; //-- класс по которому производим привязку для drag
            var winClassName     = '.statemachine-demo .' + dragItemClass;
            var dropZoneContainerId = 'dropZoneContainer';
            var dragItemsZoneId     = 'dragItemsZone';

            var labelText   = '';
            var newElements = [];
            var jsPlumb     = this.getJsPlumb();

            instance = jsPlumb.getInstance({
                Endpoint: ["Dot", { radius: 8 }],
                Connector:"Flowchart",
                HoverPaintStyle: {stroke: "#1e8151", strokeWidth: 2 },
                ConnectionOverlays: this.connectionOverlays,
                Container: containerIdName
            });

            instance.registerConnectionType("basic", {
                anchor:"Continuous",
                connector : this.connectorParams
            });

            var canvas  = document.getElementById(containerIdName);
            var windows = jsPlumb.getSelector(winClassName);
            window.jsp  = instance;

            instance.bind("connection", info => {
                if(!this.newDropConnectedStatus) {
                   this.addLink(info);
                }
                else {
                   var nextElem = info.sourceEndpoint.canvas.nextElementSibling;
                   if(nextElem) {
                       var newlabel = this.getLinkNumber(nextElem);
                       info.connection.getOverlay("label").setLabel(newlabel);
                   }
                }
            });

            instance.bind("click", this.deleteLink);
            instance.on(canvas, "dblclick", (e) => {
                // this.addElem(e.offsetX, e.offsetY);
            });

            instance.bind("connectionDrag", (connection) => {
                console.log("---connectionDragStart---");
                console.log(connection);
                var s1 = connection.suspendedElement;
                var s2 = connection.suspendedElementType;
            });

            instance.bind("connectionDragStop", (connection) => {
                console.log("--connectionDragStop---");
                console.log(connection);
            });

            instance.bind("connectionMoved", (params) => {
                console.log("---connectionMoved---");
                console.log(connection);
            });

            instance.bind('beforeDrop', (ci) => { // Before new connection is created
                var src = ci.sourceId;
                var con = instance.getConnections({source:src}); // Get all source el. connection(s) except the new connection which is being established
                if(con.length!=0 && $('#'+src).hasClass('exit')){
                    for(var i = 0; i <con.length; i++){
                        instance.detach(con[i]);
                    }
                }

                return true; // true for establishing new connection
            });


            // --- ИНИЦИАЛИЗАЦИЯ ОБЪЕКТОВ (ЕЛЕМЕНТОВ)
            instance.batch(() => {

                var loadType = 'drag';
                this.elementsLoader(windows, loadType);

                instance.droppable(jsPlumb.getSelector("#dropZoneContainer"), {
                    drop : (e) => {
                        this.dropZoneState = true;
                    },
                });
            });

            jsPlumb.fire("jsPlumbDemoLoaded", instance);
        },

    },

};