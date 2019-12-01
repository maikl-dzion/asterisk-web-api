
var BaseService = {

    data: function() {
        return {

            pageTitle  : '',
            smallTitle : '',

            cdrTimerId : '',

            saveStatus     : false,
            alertOpenStatus: false,
            alertMessage   : '',

            loadingBoxDisplay : 'none',
            loadingBoxMessage : '',

            loadingPopUpDisplay : 'none',
            loadingPopUpMessage : '',
            loadingPopUpTitle   : '',
            loadingPopUpModalId : 'loading-pop-up-box',

            reloadStatus : false,
            reloadMessage: '',

            widthModalForm : '50%',

            // pageName  : 'mainPage',

            // Временные массивы
            newDropElements    : [],
            newConnectedParams : [],
            newDropConnectedStatus : false,

            // Основные массивы
            dropElementItems   : [],
            dropConnectedObjects : [],
            dropItemsPoints : [],
            dropItemsConnects : [],

        }
    },

    computed: {

    },

    methods: {

        spinPreLoader(state = false, message = '', title = '', timerState = false, time = 0) {
            if(state) {
                this.loadingPopUpTitle   = title;
                this.loadingPopUpDisplay = 'block';
                this.loadingPopUpMessage = message;
            }
            else {
                this.loadingPopUpTitle   = '';
                this.loadingPopUpDisplay = 'none';
                this.loadingPopUpMessage = '';
            }

            if(timerState) {
                if(!time) time = 200;
                setTimeout(() => {
                    this.loadingPopUpDisplay = 'none';
                }, time);
            }
        },

        getPageName() {
            return this.pageName;
        },

        _toggleDisplay(selector, ident = '#') {
            selector = ident + selector;
            htmlElements = document.querySelectorAll(selector);
            for(var i in htmlElements) {
                elem = htmlElements[i];
                try {
                    if (elem.style.display && elem.style.display == 'block') {
                        elem.style.display = 'none';
                    }
                    else {
                        elem.style.display = 'block';
                    }
                }catch(e) {}
            }
        },

        _for(arr, callback, args = null) {
            if(!callback) return false;
            var result = [];
            for(var i in arr) {
                var item = arr[i];
                var res = callback(i, item);
                if(res)
                    result.push(res);
            }
            return result;
        },

        //this._for(arr, (i, item) => {
           //if(i == '601') lg(item);
        //});

        setPageName(name) {
            this.pageName = name;
        },

        _set(obj, index, value) {
            this.$set(obj, index, value);
            return obj;
        },

        objCopy(obj) {
            return Object.assign({}, obj);
        },

        setObjVal(obj, index, value) {
            this.$set(obj, index, value);
            return obj;
        },

        objAssign(obj, newObject = {}) {
            Object.assign(newObject, obj);
            return newObject;
        },

        isObjectEmpty(obj) {
            if (Object.keys(obj).length != 0) {
               return false;
            }
            return true;
        },

        isArrayEmpty(arr) {
            if (arr.length) {
                return false;
            }
            return true;
        },

        createIdDropElem(type, itemId) {
           var prefix = '-connect-drop-';
           return type + prefix + itemId;
        },

        getElem(id) {
            return document.getElementById(id);
        },

        getItemModalId(id) {
            return 'modal-edit-item-' + id;
        },

        getAttr(id, attrName) {
            var elem = getElem(id);
            return elem.getAttribute(attrName);
        },

        elemSelector(name, type = 0, selector = null) {
            var result = {};
            if(selector) name = name + selector;
            if(type) result = document.querySelectorAll(name);
            else     result = document.querySelector(name);
            return result;
        },

        searchArr(arr, fieldName, searchValue) {
            var result = '';
            for(var i in arr) {
               var item = arr[i];
               if(item[fieldName] == searchValue)
                 return item;
            }
            return result;
        },

        typeOfDigit(val) {
            return parseInt(val.replace(/[^\d]/g, ''));
        },

        //------------------
        //-- Функции для работы с
        //   глобальной шиной событий
        getGlobalBus() {
            return this.$root.EventGlobalBus;
        },

        // устанавливаем данные на глобальную шину
        setEventGlobalBus(eventName, ...params) {
            var eventGlobalBus = this.getGlobalBus();
            eventGlobalBus.$emit(eventName, ...params);
        },

        // получаем данные с глобальной шины (вызываем в mounted() )
        getEventGlobalBusOn(eventName, callBack) {
            var eventGlobalBus = this.getGlobalBus();
            eventGlobalBus.$on(eventName, (...response) => {
                callBack(...response);
            });
        },
        //-- end ---------
        //----------------


        alertMessageShow(response) {

            var saveResultNames = [
               'saveResult',
               'saveStatus',
            ];

            var errMessageNames = [
                'errMessage',
                'errorMessage',
            ];

            this.saveStatus = false;

            for(var i in saveResultNames) {
                var name = saveResultNames[i];
                if(response[name])
                    this.saveStatus = response[name];
            };

            for(var i in errMessageNames) {
                var name = errMessageNames[i];
                if(response[name])
                    this.alertMessage = response[name];
            };

            this.alertOpenStatus = true;

            setTimeout(() => {
                this.saveStatus      = false;
                this.alertOpenStatus = false;
                this.alertMessage    = '';
            }, 2000);

            return this.saveStatus;
        },
    },

};
