
const TestPage = Vue.component('testPage', {
    template: '#testPage',
    name    : 'testPage',
    mixins  : [JsPlumController],
    data: function () {
        return {
           userItem    : {},
           cdrReports  : [],
           cdrData     : [],
           commandInfo : {},

           fieldParam : { col : '4', label : 'name'},

           testUserData : {
                name : 'Maikl',
                role : 'Admin',
                email : 'test@mail.ru',
                address : {
                    street  : 'Улица Салова',
                    homeNum : 34,
                    kvNum   : 12,
                },
           },

           cdrModel : {
               "call_date"    : "Дата",
               "record_file"  : "Запись",
               "uniqueid"     : "Идентификатор",
               "caller_id"    : "Кто звонил",
               "format_src"   : "format_src",
               "out_caller_id": "out_caller_id",
               "did"          : "did",
               "format_app"   : "App",
               "format_dst"   : "Кому звонили",
               "disposition"  : "Статус звонка",
               "duration"     : "Длительность",
               "userfield"    : "Userfield",
               "accountcode"  : "Account",
           },

            cdrFilters :  {
                "call_date"    : "",
                "record_file"  : "",
                "uniqueid"     : "",
                "caller_id"    : "",
                "format_src"   : "",
                "out_caller_id": "",
                "did"          : "",
                "format_app"   : "",
                "format_dst"   : "",
                "disposition"  : "",
                "duration"     : "",
                "userfield"    : "",
                "accountcode"  : "",
            }
        }
    },

    created: function () {

        // this.updateItemsBundle();
        // this.getExtMap(() => {});

        // setTimeout(() => {
        //     this.dragContainerToggle('users-drag-box');
        // }, 200);

        this.getPbxExtensions(33).then(userInfo => {
            this.userItem = userInfo;
        });

        var num = 187;
        var astR = 'asterisk -r';
        var sipPeers = 'sip show peers';
        var sipPeer  = 'sip show peer ' + num;
        var sipRegistry = 'sip show registry';
        var sipChannels = 'sip show channels';
        var sipSettings = 'sip show settings';
        var dialplan = 'dialplan show';
        var coreApp  = 'core show applications';
        var commandHelp = 'core show help';
        var sipHistory  = 'sip show history';

        var command = commandHelp;
        this.getAsteriskCliCommand(command).then(info => {
             // this.commandInfo = info;
        });

        this.getPbxCdrReports(itemId = 0).then(resp => {
            this.cdrData = resp;
            this.cdrReports = Object.assign({}, this.cdrData);
        });

    },

    computed: {

    },

    methods: {

        plumControllerReady(params = null) {
            this.getJsPlumb().ready(this.jsPlumStart);
        },

        getInputValue(resp){
            this.testUserData[resp.name] = resp.value;
        },

        cdrFiltersInit() {
            var cdrItems = Object.assign({}, this.cdrData);
            for(var fieldName in this.cdrFilters) {
                var fieldValue = this.cdrFilters[fieldName];
                cdrItems = this.cdrFiltersRun(fieldName, fieldValue, cdrItems);
            }
            this.cdrReports = Object.assign({}, cdrItems);
        },

        cdrFiltersRun(fieldName, fieldValue, items) {
            for(var i in items) {
                var item = items[i];
                if(fieldName in item) {
                    var value = item[fieldName];
                    value = value.replace(/<.*?>/g, "");
                    var pos = value.indexOf(fieldValue);
                    if(pos === -1) {
                        delete items[i];
                    }
                    else {
                        var reValue = '<span style="color:red">' +fieldValue+ '</span>';
                        var newValue = value.replace(fieldValue, reValue);
                        items[i][fieldName] = newValue;
                    }
                }
            }
            return items;
        },



    },

    mounted(){

        // setTimeout(() => {
        //     this.plumControllerReady();
        //     this.dragContainerToggle('users-drag-box');
        //     $(document).ready(function() {});
        //     // this.renderAsHtml();
        // }, 200);
        //
        // this.getEventGlobalBusOn('new_drop_elements_run', data => {
        //     setTimeout(() => {
        //         this.newDropElementsInitInPlum();   // --- ИНИЦИАЛИЗИРУЕМ ЕЛЕМЕНТ в jsPlum
        //     }, 50);
        // });

    }

});

