Vue.component('ivr-controller', {
    props   : ['action', 'data', 'id', 'params'],
    template: '#ivrController',
    name    : 'IvrController',
    data: function () {
        return {
           modalId : 'modal-edit-item-ivr',
           formState  : false,
           lastItem   : 0,
           ext        : 0,
           item : {},
        }
    },

    created: function () {
        this.getCoreSettings();
    },

    computed: {

        getFormTitleFormatted() {
            switch (this.action) {
                case 'add'  : this.formTitle = 'Создать интерактивное меню'; break;
                case 'edit' : this.formTitle = 'Редактировать'; break;
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

    methods: {},

});

