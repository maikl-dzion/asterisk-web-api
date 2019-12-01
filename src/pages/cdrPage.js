Vue.component('cdrPage', {
    template: '#cdrPage',
    name: 'cdrPage',
    data: function () {

        // cdrItemModel :  {
        //     "calldate": "2019-03-03 14:00:03",
        //     "clid": "\"79376966158\" <79376966158>",
        //     "did": "",
        //     "src": "79376966158",
        //     "dst": "30",
        //     "dcontext": "from-queue",
        //     "channel": "Local/30@from-queue-00000024;2",
        //     "dstchannel": "Local/FMGL-8902486209@from-internal-00000027;1",
        //     "lastapp": "NoOp",
        //     "lastdata": "SKIPPING DEST, CALL CAME FROM Q/RG: 314",
        //     "duration": "1",
        //     "billsec": "0",
        //     "disposition": "BUSY",
        //     "amaflags": "3",
        //     "accountcode": "",
        //     "uniqueid": "1551610803.695",
        //     "userfield": "",
        //     "call_timestamp": "1551610803",
        //     "recordingfile": "",
        //     "cnum": "79376966158",
        //     "cnam": "79376966158",
        //     "outbound_cnum": "",
        //     "outbound_cnam": "",
        //     "dst_cnam": ""
        // };

        return {

            cdrData : [],
            cdrItems   : [],

            cdrItemModel :  {

                "calldate": "Дата",
                "did": "",
                "call_vector": "",

                "clid": "",
                "src": "",
                "cnum": "",
                "cnam": "",

                "dst": "",
                "dst_cnam": "",
                "outbound_cnum": "",
                "outbound_cnam": "",

                "dcontext": "",
                "channel": "",
                "dstchannel": "",
                "lastapp": "",
                "lastdata": "",

                "accountcode": "",
                "disposition": "Статус звонка",
                "uniqueid": "",
                "userfield": "",
                "call_timestamp": "",
                "recordingfile": "",

                "duration": "",
                "billsec": "",
                "amaflags": "",
            },

            cdrFilters :  {
                "calldate": "",
                "clid": "",
                "did": "",
                "src": "",
                "dst": "",
                "dcontext": "",
                "channel": "",
                "dstchannel": "",
                "lastapp": "",
                "lastdata": "",
                "duration": "",
                "billsec": "",
                "disposition": "",
                "amaflags": "",
                "accountcode": "",
                "uniqueid": "",
                "userfield": "",
                "call_timestamp": "",
                "recordingfile": "",
                "cnum": "",
                "cnam": "",
                "outbound_cnum": "",
                "outbound_cnam": "",
                "dst_cnam": ""
            },

        }
    },

    created: function () {

        this.getCdrData();

        // начать повторы с интервалом 2 сек
        // this.cdrTimerId = setInterval(() => {
        //      this.getCdrData();
        //      console.log('cdr - run ');
        // }, 9000);
    },

    computed: { },

    methods: {

        getCdrData() {
            this.cdrDataController('getCdrData').then(resp =>{
                this.cdrData = resp;
                this.cdrItems = Object.assign({}, this.cdrData);
            });
        },

        cdrFiltersInit() {
            var cdrItems = Object.assign({}, this.cdrData);
            for(var fieldName in this.cdrFilters) {
                var fieldValue = this.cdrFilters[fieldName];
                cdrItems = this.cdrFiltersRun(fieldName, fieldValue, cdrItems);
            }
            this.cdrItems = Object.assign({}, cdrItems);
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

});

