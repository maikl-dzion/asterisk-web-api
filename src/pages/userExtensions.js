Vue.component('userExtensions', {
    template: '#userExtensions',
    name: 'UserExtensions',
    // mixins: [HttpService, BaseMixin],
    data: function () {
        return {
            currentExten  : '',
            formOpenState : '',
            item  : {},
            items : [],
            extensionFields : extensionFields,
        }
    },

    created: function () {
        this.getCoreInfo();
    },

    computed: {
        extensionsFiltered() {
            var items = Object.assign({}, this.coreInfo['users']);
            return items;
        },
    },

    methods: {

        openForm() {
            this.formOpenState = true;
            this.item = Object.assign({}, this.extensionFields);
        },

        closeForm() {
            this.formOpenState = false;
            this.item = [];
        },

        addItem() {
            var secret = generateSecret(16);
            this.item['devinfo_secret'] = secret;
            var postData = this.item;
            this.currentExten = this.item['extension'];
            this.httpRun(this.postApiUrl, this.responseHandler, 'POST', postData);
        },

        editItem(item) {
            var exten = item['extension'];
            item['display']    = 'extensions';
            item['extdisplay'] = exten;
            item['action']     = 'edit';
            item['type']       = '';

            var postData = item;
            this.currentExten = exten;
            this.httpRun(this.postApiUrl, this.responseHandler, 'POST', postData);
        },

        deleteItem(item) {
            var postData = {};
            var exten = item['extension'];

            postData['display']    = 'extensions';
            postData['extdisplay'] = exten;
            postData['action']     = 'del';
            postData['type']       = '';
            postData['tech']       = 'sip';
            postData['customcontext']  = 'from-internal';

            this.currentExten = '';
            this.httpRun(this.postApiUrl, this.responseHandler, 'POST', postData);
        },

        responseHandler(response) {

            var saveStatus = response;
            if (saveStatus) {
                this.getCoreInfo();
                this.closeForm();
            }

            this.alertMessageShow(saveStatus, response);
        },

    },

});

