const MainPage = Vue.component('mainPage', {
    template: '#mainPage',
    name: 'MainPage',
    data: function () {
        return {
            currentItem   : '',
            formOpenState : '',
            item  : {},
            items : [],
        }
    },

    created: function () {
        this.getCoreInfo();
    },

    computed: {
        itemsFiltered() {
            var items = Object.assign({}, this.coreInfo);
            return items;
        },
    },

    methods: {

        openForm() {
            this.formOpenState = true;
            // this.item = Object.assign({}, this.extensionFields);
        },

        closeForm() {
            this.formOpenState = false;
            this.item = [];
        },

        addItem() {
            var postData = this.item;
            this.httpRun(this.postApiUrl, this.responseHandler, 'POST', postData);
        },

        responseHandler(response) {
            if (response) {
                alert('ok' + response);
                this.getCoreInfo();
                closeForm();
            }
            else {
                lg('Не удалось сохранить, попробуйте еще раз');
            }
        },
    },

});

