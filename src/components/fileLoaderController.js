// const FileLoaderController =
Vue.component('file-loader-controller', {
    props   : ['action', 'data', 'id', 'params'],
    template: '#fileLoaderController',
    name    : 'FileLoaderController',
    data: function () {
        var modalId = this.getItemModalId('file-loader');
        var item = this.data;

        // [action] => recorded
        // [display] => recordings
        // [usersnum] =>
        // [rname] => Sound_ssssss
        // [suffix] => mp3
        // [Submit] => Сохранить

        return {
            modalId,
            formState : false,
            item,
        }
    },

    // created: function () { },

    computed: {

        getFormTitleFormatted() {
            switch (this.action) {
                case 'add'  : this.formTitle = 'Создать новый файл';break;
                case 'edit' : this.formTitle = 'Редактировать';break;
            }
            return this.formTitle;
        },

    },

    created: function () {
        // this.getCoreSettings();
    },

    methods: {

    },

});