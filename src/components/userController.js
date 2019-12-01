Vue.component('user-controller', {
    props   : ['action', 'data', 'id', 'params'],
    template: '#userController',
    name    : 'UserController',
    data: function () {
        var modalId = this.getItemModalId('user');
        return {
            modalId,
            formState : false,
            item : {},
        }
    },

    // created: function () { },

    computed: {

        getFormTitleFormatted() {
            switch (this.action) {
                case 'add'  : this.formTitle = 'Создать нового пользователя';break;
                case 'edit' : this.formTitle = 'Редактировать';break;
            }
            return this.formTitle;
        },

        getItemModel() {
            switch (this.action) {
                case 'add'  :
                case 'edit' :
                    this.item = this.data;
                    this.item.devinfo_secret_origional = this.item.devinfo_secret;
                    this.item.extdisplay    = this.item.extension;
                    this.item.customcontext = this.item.devinfo_context;
                    break;
            }
            return this.item;
        },

        getFollowMeEdit() {

            this.followMeEdit.tel = '';
            this.followMeEdit.time = '20';

            switch (this.action) {
                case 'add' :  break;
                case 'edit' :
                    try {
                        if(this.data['followMeList']['tel']) {
                            this.followMeEdit.tel  = this.data['followMeList']['tel'];
                            this.followMeEdit.time = this.data['followMeTime']['time'];
                        }
                    }catch (e) {

                    }
                    break;
            }
            return this.followMeEdit;
        },

    },

    created: function () {
         // this.getCoreSettings(this.getFollowMeNum);
        this.getCoreSettings();
    },

    methods: { },

});