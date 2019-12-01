////////////////////
//---- HTTP -------
var HttpService = {

    data: function() {
        return {
            postApiUrl  ,
            getApiUrl   ,
            remoteApiUrl,
            localApiUrl ,
            siteUrl     ,
            authFormState : false,

            ampUser      : {},
            sessionVars  : {},

            REMOTE_REST_API_NAME : 'remote_request_rest_api_service',
            requestApiName       : 'request_api_alliance',
        }
    },

    methods: {

        httpPromise(apiUrl, method, formData) {

            if(formData) {
                formData[this.requestApiName] = true; // --ПЕРЕМЕННАЯ ДЛЯ ОБРАЩЕНИЯ к FreePBX
                formData = this.postDataFormatted(formData);
                // lg(formData); return false;
            }

            if(!method || method == 'GET') {
                method = 'GET';
                if(formData)
                  apiUrl += '?' + formData;
            }

            return new Promise(function(resolve, reject) {

                var http = new XMLHttpRequest();

                http.open(method, apiUrl, true);
                // http.setRequestHeader('Content-type', 'application/json; charset=utf-8');
                http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                http.onload = function() {
                    if (this.status == 200) {
                        resolve(this.response);
                    } else {
                        var error = this.statusText;
                        reject('In promice - error:' + error);
                    }
                };

                http.onerror = function() {
                    var error = "Network Error";
                    reject(error);
                };

                if(formData) {
                    // formData = this.postDataFormatted(formData);
                    // formData = JSON.stringify(formData);
                }
                else {
                    formData = '';
                }

                http.send(formData);

            });
        },

        httpRun(apiUrl, responseHandler, method, postData, errorHandler) {

            this.httpPromise(apiUrl, method, postData).then(
                response => {
                    var result = {};
                    try {
                        result = JSON.parse(response);
                    }catch {
                        console.log(response);
                        lg(response);
                        return;
                    }

                    // result = this.checkResponse(result);
                    if(result)
                       responseHandler(result);

                },
                error => {
                    alert(error);
                }
            );
        },

        checkResponse(data) {
            var dataType = typeof(data);
            if (dataType == 'object') return data;
            var errorMessage = '####  ---ERROR(checkResponse) not  object---- #####';
            console.log(dataType);
            console.log(errorMessage);
            // alert(errorMessage);
            lg(data);
            return false;
        },

        postDataFormatted(data) {
            var post = [];
            for (var fieldName in data) {
                // var dataType = typeof(data[fieldName]);
                // if(dataType == 'object') { var sub = postDataFormatted(data);}
                var value = encodeURIComponent(data[fieldName]);
                post.push(fieldName + '=' + value);
            }
            var result = post.join('&');

            return result;
        },

        getCheckAuth() {
            var urlParams = '&action=remote_check_auth';
            this.send('get' , urlParams).then( response => {
                var formState = true;
                try {
                    // result = JSON.parse(response);
                    result = response;
                    if(result['auth_status']) formState = false;
                    this.ampUser = result['amp_user'];
                    this.sessionVars = result['session'];

                } catch {}

                this.authFormState = formState;  //-- ЗАПУСКАЕМ ФОРМУ АВТОРИЗАЦИИ
            });
        },


        responseParse (response) {
            var result = {};
            try {
                result = JSON.parse(response);
            }catch {
                console.log(response);
                lg(response);
                return false;
            }
            return result;
        },

        httpRequest(url , data=null, method = 'post') {

            if(data) data[this.REMOTE_REST_API_NAME] = true;

            return new Promise((resolve, reject) => {
                this.$http[method](url, data)
                    .then(response => {
                        if (response.body instanceof Object) {
                            var result = this.responseParse (response.body);
                            resolve(result);
                        } else {
                            lg(response.body);
                            reject(`Unexpected response type - expected object, got ${typeof response.body}`);
                        }
                    }).catch(err => {
                         reject(err);
                    });
            });
        },


        httpGet(url) {
            var data = null;
            var apiUrl = this.getApiUrl + '?' + this.REMOTE_REST_API_NAME + '=1' + url;
            return this.httpRequest(apiUrl , data, 'get');
        },
        //this.httpRequest(this.postApiUrl, postData)
        //.then( response => {
            //lg(response);
        //});

        // ВАРИАНТЫ ИСПОЛЬЗОВАНИЯ
        // this.send('post', '',          { name : 'maikl' }, 'remote').then( response => {} );
        // this.send('get' , '&name=456', null,               'local').then( response => {} );
        send(method = 'post', url = '', data = null, urlDirection = 'remote') {

            var urlObj = {
                'remote' : this.remoteApiUrl,
                'local'  : this.localApiUrl,
            };

            var apiUrl  = urlObj[urlDirection];

            switch (method) {
                case 'post' :
                    if(data) data[this.REMOTE_REST_API_NAME] = true;
                    // lg(data);  return false;
                    // apiUrl  = this.postApiUrl;
                    break;

                case 'get' :
                    //apiUrl  = this.getApiUrl;
                    if(url && url[0]) {
                        if(url[0] != '&') url = '&' + url;
                    }
                    url  = this.REMOTE_REST_API_NAME + '=1' + url;
                    break;
            }

            //if(urlType != 'remote') {
                //apiUrl = this.localApiUrl;
            //}

            if(url) {
                apiUrl += '?' + url;
            }

            return new Promise((resolve, reject) => {
                this.$http[method](apiUrl, data)
                    .then(response => {
                        if (response.body instanceof Object) {
                            // var result = this.responseParse (response.body);
                            var result = response.body;
                            if('error' in result && result['error']) {
                                lg(result);
                                infoPanelRun(['Произошла ошибка-"LOCAL ERROR"'], 'error', { not_close : true });
                            }
                            else {
                                resolve(result);
                            }
                        } else {
                            lg(response.body);
                            infoPanelRun(['Произошла ошибка-"RETURN DATA STRING"'], 'error', { not_close : true });
                            reject(`Unexpected response type - expected object, got ${typeof response.body}`);
                        }
                    }).catch(err => {
                        infoPanelRun(['Произошла ошибка-"HTTP ERROR CATCH"'], 'error', { not_close : true });
                        reject(err);
                    });
            });
        },

        // -- СОХРАНЕНИЕ ПО УМОЛЧАНИЮ ----
        saveDefault(postData, args = '', callback = null) {
            return this.send('post', args, postData);
        },

    },

};

//--- / HTTP ------
///////////////////