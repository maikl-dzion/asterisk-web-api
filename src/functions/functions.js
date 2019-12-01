function lg(arr) {

    var result = '---NOT ARRAY---';
    if (arr) result = _printf(arr); // --- формируем строку из массива
    _openWindow(result);            // --- показываем результат в новом окне

    // --- формируем строку из массива
    function _printf(arr) {
        var strResult = '', deLimiter = ' => ';
        var typeObj = typeof(arr);
        if (typeObj == 'object') {
            for (var i in arr) {
                var values = arr[i];
                var subValues = '';
                var li = deLimiter;
                if (typeof(values) == 'object') {
                    subValues = _printf(values);
                } else {
                    li += values;
                }
                strResult += '<li>[' + i + ']' + li + '</li>' + subValues;
            }
        }
        else strResult = '<li>' + arr + '</li>';
        return '<ul>' + strResult + '</ul>';
    }

    // --- показываем результат в новом окне
    function _openWindow(result, href) {
        var modal = window.open('', '', 'scrollbars=1');
        var style = 'button { padding:10px; margin:10px; border:0px grey solid; width:90%; cursor:ponter  }'
            + ' .lg-view-result { border:2px red solid; }';
        var html = '<!DOCTYPE html><head><style>' + style + '</style><head>'
            + '<p><button onclick="window.close();" >Close</button></p><hr>'
            + '<p class="lg-view-result" ><pre>' + result + '</pre></p>';
        modal.document.body.innerHTML = html;
    }
}


function generateNewSecret(len) {
    var ints =[0,1,2,3,4,5,6,7,8,9];
    var chars=['a','b','c','d','e','f','g','h','j','k','l','m','n','o','p','r','s','t','u','v','w','x','y','z'];
    var out='';
    for(var i=0;i<len;i++){
        var ch=Math.random(1,2);
        if(ch<0.5){
            var ch2=Math.ceil(Math.random(1,ints.length)*10);
            out+=ints[ch2];
        }else{
            var ch2=Math.ceil(Math.random(1,chars.length)*10);
            out+=chars[ch2];
        }
    }

    return out;
}


var infoPanelRun = function (messagesArr = [], messageType = 'ok', params = {}) {

    var notClose = false;
    var time = 2000;
    var _width = '30%';
    if(params.time)  time   = params.time;
    if(params.width) _width = params.width;
    if(params.not_close) notClose = true;

    var contentTop = contentBottom = '';
    var panelTitle = 'ИНФОРМАЦИОННОЕ СООБЩЕНИЕ';
    var contentMain = 'Успешное сохранение';
    var background  = '';

    if(messagesArr.length) {
       for(var i in messagesArr) {
           var message = messagesArr[i];
           switch (parseInt(i)) {
               case 0 : contentMain    = message; break;
               case 1 : contentBottom  = '<small>' + message + '</small>'; break;
               case 2 : contentTop     = '<p>' + message + '</p>';break;
               case 3 : panelTitle     = message; break;
           }
       }
    }

    switch (messageType) {
        case 'ok'    : background   = 'background: #00a65a; color: white;'; break;
        case 'info'  : background   = 'background: #00c0ef; color: white;'; break;
        case 'warn'  : background   = 'background: #f39c12; color: white;'; break;
        case 'error' : background   = 'background: #dd4b39; color: white;'; break;
    }

    var wrappClassName = "wrapp-alert-box-custom-elem";
    var wrappId        = wrappClassName + "-my-information-panel-125";
    var buttonCloseId  = wrappClassName + "-button-close-info";
    var wrappStyles     = ` width: 100%; top: 10px; 
                            z-index:99999999; 
                            position:fixed;`;

    var alertContent = `
    <div class="" id="${wrappId}" style="${wrappStyles}" >
    <!---------------------------------------->       
        <div class="box box-solid" style="width:${_width}; margin:0 auto 0 auto; ${background}" >
        
            <!-- box-header -->
            <div class="box-header with-border" style="color:black;">
               <i class="fa fa-envelope-o"></i>
               <div class="box-title" style="font-style:italic;" >${panelTitle}</div>
               <button type="button" class="close" id="${buttonCloseId}" >×</button>
            </div>
            
            <!-- box-body -->
            <div class="box-body" style="text-align:left" >

              <blockquote>
                ${contentTop}
                <p>${contentMain}</p>
                ${contentBottom}
              </blockquote>

              <!--<dl class="dl-horizontal">-->
                <!--<dt>Description lists</dt>-->
                <!--<dd>A description list is perfect for defining terms.</dd>-->
                <!--<dt>Euismod</dt>-->
                <!--<dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.</dd>-->
              <!--</dl>-->
              
            </div>
            
        </div>
     <!--------------------------------------->       
     </div>`;

    var alertBoxComponent  = document.createElement('div');
    alertBoxComponent.className = wrappClassName;
    alertBoxComponent.id        = wrappId;
    alertBoxComponent.innerHTML = alertContent;
    document.body.append(alertBoxComponent);

    function infoWrappRemove(id) {
        var elem = document.getElementById(id);
        elem.remove();
    }

    var buttonCloseElem = document.getElementById(buttonCloseId);
    buttonCloseElem.onclick = (event) => {
        infoWrappRemove(wrappId);
    };

    if(notClose) return true;

    setTimeout(() => infoWrappRemove(wrappId), time);

}



var alertMessageShow = function (message, options = null) {

    var wrappClassName = "wrapp-alert-box-custom-elem";
    var wrappId        = wrappClassName + "-uid";
    var modalBoxId     = wrappClassName + "-modal-uid";
    var buttonCloseId  = wrappClassName + "-botton-close-uid";

    var alertContent = `
          <style>#${modalBoxId} { display: block; padding-right: 17px; }</style>
          <div class="modal modal-info fade in" id="${modalBoxId}" style="">
            <div class="modal-dialog">
            
                <div class="modal-content">
                      <div class="modal-header">
                        <!--
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" >×</span></button>
                        -->
                        <h4 class="modal-title">Сообщение</h4>
                      </div>
                      
                      <div class="modal-body">
                        <p>${message}</p>
                      </div>
                      
                      <div class="modal-footer">
                        <button  id="${buttonCloseId}" type="button" class="btn btn-outline pull-left" data-dismiss="modal" >Close</button>
                        <!--<button type="button" class="btn btn-outline">Save changes</button>-->
                      </div>
                </div>
                
          </div></div>`;


    var alertBoxComponent  = document.createElement('div');
    alertBoxComponent.className = wrappClassName;
    alertBoxComponent.id        = wrappId;
    alertBoxComponent.innerHTML = alertContent;
    document.body.append(alertBoxComponent);

    var buttonClose   = document.getElementById(buttonCloseId);
    var modalBoxWrapp = document.getElementById(modalBoxId);

    buttonClose.onclick = function(event) {
        var target = event.target; // где был клик
        alertWrappRemove();
    };

    modalBoxWrapp.onclick = function(event) {
        var target = event.target; // где был клик
        alertWrappRemove();
    };

    function alertWrappRemove() {
        var elem = document.getElementById(wrappId);
        elem.remove();
    }

    setTimeout(() => alertWrappRemove(), 4000);

}

//  пример использования
// alertReload('Сообщение 1', 1);
// alertReload('Сообщение 2');
// alertReload('Сообщение 5', false, true);


var alertReload = function (message, init = false, closeFlag = false) {

    var wrappClassName = "alert-reload-wrapp-alert-box-custom-elem";
    var wrappId        = wrappClassName + "-uid";
    var modalBoxId     = wrappClassName + "-modal-uid";
    var buttonCloseId  = wrappClassName + "-botton-close-uid";
    var messageBoxId   = wrappClassName + "-message-uid";
    var footerBoxId    = wrappClassName + "-footer-uid";
    var headerBoxId    = wrappClassName + "-header-uid";

    if(!init && !closeFlag) {
        var modalContentBox = document.getElementById(messageBoxId);
        var oldContent = modalContentBox.innerHTML;
        var newContent = oldContent + '<br>' + message;
        modalContentBox.innerHTML = newContent;
        return true;
    }

    if(closeFlag) {
        var modalHeaderBox = document.getElementById(headerBoxId);
        modalHeaderBox.innerHTML = '<h4 class="modal-title" style="margin-right:20px;" >Данные успешно обработаны</h4>';
        setTimeout(() => alertWrappRemove(), 4000);
        return true;
    }


    var alertContent = `
          <style>#${modalBoxId} { display: block; padding-right: 17px; }</style>
          <div class="modal modal-info fade in" id="${modalBoxId}" style="">
            <div class="modal-dialog">
            
                <div class="modal-content">
                      <div id="${headerBoxId}" class="modal-header" style="display: flex;" >
                        <!--
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" >×</span></button>
                        -->
                        <h4 class="modal-title" style="margin-right:20px;" > Подождите , идет обработка данных ... </h4>
                        <div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>
                      </div>
                      
                      <div class="modal-body">
                        <div id="${messageBoxId}" >${message}</div>
                      </div>
                      
                      
                      <div class="modal-footer">
                        <div id="${footerBoxId}" ></div>
                        <!--
                        <button  id="${buttonCloseId}" type="button" class="btn btn-outline pull-left" data-dismiss="modal" >Close</button>
                        <button type="button" class="btn btn-outline">Save changes</button>
                        -->
                      </div>
                      
                </div>
                
          </div></div>`;


    var alertBoxComponent = document.createElement('div');
    alertBoxComponent.className = wrappClassName;
    alertBoxComponent.id = wrappId;
    alertBoxComponent.innerHTML = alertContent;
    document.body.append(alertBoxComponent);

    // var buttonClose = document.getElementById(buttonCloseId);
    // var modalBoxWrapp = document.getElementById(modalBoxId);
    //
    // buttonClose.onclick = function(event) {
    //     var target = event.target; // где был клик
    //     alertWrappRemove();
    // };
    //
    // modalBoxWrapp.onclick = function(event) {
    //     var target = event.target; // где был клик
    //     alertWrappRemove();
    // };

    function alertWrappRemove() {
        var elem = document.getElementById(wrappId);
        elem.remove();
    }

    if (closeFlag) {
       setTimeout(() => alertWrappRemove(), 4000);
    }
}


// ################################
// ################################


function getElem(id) {
    return document.getElementById(id);
}

function getAttr(id, attrName) {
    var elem = getElem(id);
    return elem.getAttribute(attrName);
}

function elemSelector(name, type = 0, selector = null) {
    var result = {};
    if(selector) name = name + selector;
    if(type) result = document.querySelectorAll(name);
    else     result = document.querySelector(name);
    return result;
}



function ondragstartCancel() {
    return false;
}

function connectBoxMove(parentId) {
    var parent = getElem(parentId);
    parent.style.backgroundColor = 'red';
    parent.style.opacity = '0.3';
}

function connectBoxOut(parentId) {
    var parent = getElem(parentId);
    parent.style.backgroundColor = 'white';
    parent.style.opacity = '1';
}