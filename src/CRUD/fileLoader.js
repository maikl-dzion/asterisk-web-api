
const FileLoader = {

    install(Vue, options) {

        Vue.mixin({
            data: function() {
                return {

                    newFileName : '',
                    fileItem : {},
                    fileParams : {
                        display: 'recordings',
                        action: 'recordings_start',
                        usersnum: '',
                    },
                    fileAction : 'add',
                    fileLoaderState : false,
                    fileItemId : '',
                }
            },

            methods: {

                setFileData(inputId = "#ivrfile") {
                    var $file = $(inputId);
                    var tmp = $file.prop('files')[0]['name'].split('.');
                    this.fileItem = $file;
                    this.newFileName = tmp[0];
                },

                getFileModel(fileName = '', fileType = '') {

                    var fileData = {
                        action : 'recorded',
                        display: 'recordings',
                        usersnum: '',
                        rname   : fileName,
                        suffix  : fileType,
                        Submit  : 'Сохранить',
                    };

                    return fileData;
                },

                sendFile() {

                    var $file = this.fileItem;
                    var fd = new FormData;

                    // var fileName = $file.prop('files')[0]['name'];
                    var fileType = $file.prop('files')[0]['type'];
                    var fileTemp = fileType.split('/');
                    fileType = fileTemp[1];
                    var filePostData = this.getFileModel(this.newFileName, fileType);

                    fd.append('ivrfile', $file.prop('files')[0]);
                    fd.append(this.REMOTE_REST_API_NAME, true);

                    for(var i in this.fileParams) {
                        fd.append(i, this.fileParams[i]);
                    }

                    this.saveDefault(fd).then(resp => {
                        var r1 = resp;
                        return this.saveDefault(filePostData);
                    }).then(resp => {
                        var r2 = resp;
                        infoPanelRun(['Файл успешно загружен'], 'ok');
                    });

                },

            } // --- METHODS
        })
    } //  Install
};


