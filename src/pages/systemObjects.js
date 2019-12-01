Vue.component('systemObjects', {
    template: '#systemObjects',
    name: 'SystemObjects',
    //  mixins: [HttpService, BaseMixin],
    data: function () {

        var contextFields = {
            "context"    : { label : "Название", disabled: 'disabled=""', },
            "description": { label : 'Описание',  },
            "dialrules": "",
            "faildestination": "",
            "featurefaildestination": "",
            "failpin": "",
            "failpincdr": "",
            "featurefailpin": "",
            "featurefailpincdr": ""

        };

        var didRouteFields = {
            "cidnum": "",
            "extension"  : { label : "Название" },
            "destination": { label : "Назначение" },
            "description": { label : "Описание" },

            "faxexten": '',
            "faxemail": '',
            "answer": '',
            "wait": '',
            "privacyman": "",
            "alertinfo": "",
            "ringing": "",
            "mohclass": "",
            "grppre": "",
            "delay_answer": "0",
            "pricid": "",
            "pmmaxretries": "3",
            "pmminlength": "10"
        };

        var outRouteFields = {
            "route_id": { label : "Id" },
            "name"    : { label : "Название" },
            "password": { label : "Пароль" },

            "outcid": "",
            "outcid_mode": "",
            "emergency_route": "",
            "intracompany_route": "",
            "mohclass": "",
            "time_group_id": '',
            "dest": '',
            "seq": "0"
        };

        var trunkFields = {

            "trunkid": { label : "TrunkId", disabled: 'disabled=""', },
            "name"   : { label : "Название", disabled: 'disabled=""', },
            "tech"   : { label : "Тип", disabled: 'disabled=""', },
            "outcid" : { label : "OutCid", disabled: 'disabled=""', },
            "channelid": { label : "channelid", disabled: 'disabled=""', },
            "usercontext": { label : "Usercontext", disabled: 'disabled=""', },

            "keepcid": "",
            "maxchans": "",
            "failscript": "",
            "dialoutprefix": "",
            "provider": "",
            "disabled": "",
            "continue": ""
        };

        return {
            contextFields ,
            didRouteFields,
            outRouteFields,
            trunkFields,
        }
    },

    created: function () {
        // this.getCoreInfo();
        this.getCoreSettings();
    },

    updated() {
        this.getCoreSettings();
    },

    methods: {

    },

});

