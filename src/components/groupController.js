
Vue.component('group-controller', {
    props   : ['action', 'data', 'id', 'params'],
    template: '#groupController',
    name    : 'GroupController',
    data: function () {
        return {
            modalId : 'modal-edit-item-group',
            formState  : false,
            item : {},
        }
    },

    // created: function () { },

    computed: {

        getFormTitleFormatted() {
            switch (this.action) {
                case 'add'  : this.formTitle = 'Создать новую группу'; break;
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

    created: function () {
        this.getCoreSettings();
    },

    methods: { },

});

