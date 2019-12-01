Vue.component('trunk-controller', {
    props   : ['action', 'data', 'id', 'params'],
    template: '#trunkController',
    name    : 'TrunkController',
    data: function () {
        var modalId = this.getItemModalId('trunk');
        return {
            modalId,
            formState  : false,
            item : {},
        }
    },

    // created: function () { },

    computed: {

        getFormTitleFormatted() {
            switch (this.action) {
                case 'add'  : this.formTitle = 'Создать внешний номер'; break;
                case 'edit' : this.formTitle = 'Редактировать';         break;
            }
            return this.formTitle;
        },

        getItemModel() {
            switch (this.action) {
                case 'add'  :
                case 'edit' :
                    this.item = this.data;
                    break;
            }
            return this.item;
        },

    },

    created: function () {
        this.getCoreSettings();
    },

    methods: {},

});