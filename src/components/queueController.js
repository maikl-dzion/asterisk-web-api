Vue.component('queue-controller', {
    props   : ['action', 'data', 'id', 'params'],
    template: '#queueController',
    name    : 'QueueController',
    data: function () {
        var item = this.data;
        return {
            modalId : 'modal-edit-item-queue',
            formState  : false,
            item,
        }
    },

    // created: function () { },

    computed: {

        getFormTitleFormatted() {
            switch (this.action) {
                case 'add'  : this.formTitle = 'Создать новую очередь';break;
                case 'edit' : this.formTitle = 'Редактировать';        break;
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
        // this.getCoreSettings();
    },

    methods: {

    },

});