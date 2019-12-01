Vue.component('ivr-update-com', {
    props   : ['action', 'id', 'params', 'connections', 'links'],
    template: '#ivrUpdateCom',
    name    : 'ivrUpdateCom',
    data: function () {

        return {
           //formTitle  : ''  ,
           //actionType : '' ,
           formState  : false,
           lastItem   : 0,
           ext        : 0,

           item : {},
        }
    },

    created: function () {
        this.getCoreSettings();
        // this.item = this.getIvrModel();
        // console.log(this.item);
        // this.send('post', '', { name : 'maikl' }, 'remote');
        // this.send('get' , '&name=456', null, 'local');

    },

    computed: {

        getIvrItems() {
            return this.ivrItems;
        },

        getExtensions() {
            return this.users;
        },

        getQueues() {
            return this.queues;
        },

        getGroups() {
            return this.ringgroups;
        },

        getFormTitle() {
            if(this.action == 'add') {
                 this.formTitle = 'Создать интерактивное меню';
            }
            else {
                this.formTitle = 'Редактировать';
            }
            return this.formTitle;
        },

        getItem() {
            if(this.action == 'add') {
                this.item = this.getIvrModel();
            }
            else {
                for(var i in this.ivrItems) {
                    var el = this.ivrItems[i];
                    if(el.id == this.id) {
                        this.item = el;
                        break;
                    }
                }
            }

            return this.item;
        },

    },

    filters: {
        getGotoValueSplit(value) {
            var result = '';
            var arr    = value.split(',');
            var title  = 'Внутренний номер';
            var num    = arr[1];
            switch(arr[0]) {
                case 'ext-queues' : title  = 'Очередь'; break;
                case 'ext-group'  : title  = 'Группа' ; break;
                case 'from-did-direct' :  break;
            }

            result = num +' : '+ title;
            return result;
        },
    },

    methods: {

        openFormAdd() {
            if(this.uid)
                var id = this.uid;

            this.item = this.getIvrModel();

            //this.item.entries.goto = [];
            //this.item.entries.ext = [];
            //this.item.entries.ivr_ret = [];

            this.actionType = 'add';
            this.formState = true;
            this.formTitle = 'Создать интерактивное меню';
            this.lastItem = this.getLastItemId();
            this.item['name'] = 'my-ivr-' + this.lastItem;
            this.item['description'] = 'my-ivr-description-' + this.lastItem;

        },

        openFormEdit(row) {
            this.actionType = 'edit';
            this.formState = true;
            this.formTitle = 'Редактировать интерактивное меню';
        },

        closeForm() {
            this.formState = false;
            this.item = {};
        },


        getLastItemId() {
            var lastItem = 0;
            for(var i in this.ivrItems) {
                if(this.ivrItems[i]['id'] > lastItem) {
                    lastItem = this.ivrItems[i]['id'];
                }
            }
            return ++lastItem;
        },

        ivrGotoForm(item, arrName) {
            var gotoLine = number = '';
            switch(arrName) {
                case 'users' :
                    number = item.extension;
                    gotoLine = 'from-did-direct, ' +number+ ',1';
                    this[arrName] = this.deleteInArr(this[arrName], number, 'extension');
                    break;

                case 'queues' :
                    number = item.extension;
                    gotoLine = 'ext-queues, ' +number+ ',1';
                    this[arrName] = this.deleteInArr(this[arrName], number, 'extension');
                    break;

                case 'ringGroups' :
                    number = item.grpnum;
                    gotoLine = 'ext-group, ' +number+ ',1';
                    this[arrName] = this.deleteInArr(this[arrName], number, 'grpnum');
                    break;
            }

            if(gotoLine) {
                this.ext++;
                var ivrRet = 0;
                this.item.entries.goto.push(gotoLine);
                this.item.entries.ext.push(this.ext);
                this.item.entries.ivr_ret.push(ivrRet);
            }
        },

        deleteInArr(arr, value, fieldName) {
            for(var i in arr) {
                var item = arr[i];
                if (item[fieldName] == value) {
                    arr.splice(i, 1);
                }
            }
            return arr;
        } ,

        save() {

        } ,

        addItemEmit(item) {
            this.$emit('add_emit_event', item);
        },




        separationUsersInArr(type, row = null) {
            switch (type) {
                case 'remove' :
                    for(var i in this.usersInGroup) {
                        var user = this.usersInGroup[i];
                        if(row.extension === user['extension']) {
                            this.extensions.push(user);
                            this.usersInGroup.splice(i, 1);
                            return true;
                        }
                    }
                    break;

                case 'add' :
                    for(var i in this.extensions) {
                        var user = this.extensions[i];
                        if(this.selectUser === user['extension']) {
                            this.usersInGroup.push(user);
                            this.extensions.splice(i, 1);
                            return true;
                        }
                    }
                    break;
            }
        } ,

        addItem() {
            var extensions = [];
            // lg(this.usersInGroup);
            for(var i in this.usersInGroup) {
                var item = this.usersInGroup[i];
                extensions.push(item['extension']);
            }

            this.item['members'] = extensions.join(',');
            // lg(this.item);
            this.addQueue(this.item, extensions).then(
                response => {
                    var result = this.responseParse(response);
                    if(result) this.responseHandler(result);
                });
        },

        responseHandler(response) {
            var status = this.alertMessageShow(response);
            if(status) {
                this.getCoreSettings(() => {
                    for(var i in this.queues) {
                        var queue = this.queues[i];
                        if(this.newQueueNum != queue.extension) continue;
                        this.addItemEmit(queue);
                        break;
                    }
                });
            }
        },

        respCallBack() {
            var item = {};
            for(var i in this.queues) {
                var queue = this.queues[i];
                if(this.newQueueNum == queue.extension) {
                    item = queue;
                    break;
                }
            }
            this.addItemEmit(item);
        }

    },

});

