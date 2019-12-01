var dragObject = {};
var dragClassName = '.draggable';
var dropClassName = '.droppable';


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// ---- ИНИЦИАЛИЗАЦИЯ ПЕРЕМЕЩЕНИЯ
function onMouseDownEvent(e) {
    if (e.which != 1) return;

    var elem = e.target.closest(dragClassName);
    if (!elem) return;

    dragObject.elem  = elem;
    dragObject.downX = e.pageX;
    dragObject.downY = e.pageY;
}

// </> ИНИЦИАЛИЗАЦИЯ ПЕРЕМЕЩЕНИЯ
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@



//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//  НАЧАЛО И ПРОЦЕСС ПЕРЕМЕЩЕНИЯ
function onMouseMoveEvent(e) {

    // moveArrowDrawHandler(e);

    // if(elemDragInit) {
    //     log(elemDragInit, 'document.onmousemove');
    //     moveElementDraw(e, oneElement);
    //     return false;
    // }

    if (!dragObject.elem) return; // элемент не зажат

    if ( !dragObject.avatar ) { // если перенос не начат ...

        // посчитать дистанцию, на которую переместился курсор мыши
        var moveX = e.pageX - dragObject.downX;
        var moveY = e.pageY - dragObject.downY;
        if ( Math.abs(moveX) < 3 && Math.abs(moveY) < 3 ) {
            return; // ничего не делать, мышь не передвинулась достаточно далеко
        }

        dragObject.avatar = createAvatar(e); // захватить элемент
        if (!dragObject.avatar) {
            dragObject = {}; // аватар создать не удалось, отмена переноса
            return; // возможно, нельзя захватить за эту часть элемента
        }

        // аватар создан успешно
        // создать вспомогательные свойства shiftX/shiftY
        var coords = getCoords(dragObject.avatar);
        dragObject.shiftX = dragObject.downX - coords.left;
        dragObject.shiftY = dragObject.downY - coords.top;

        startDrag(e);  // отобразить начало переноса
    }

    var uid  = dragObject.elem.getAttribute('data-uid');
    var lineId = 'svg-line-' + uid;
    var line   = getElem(lineId);
    //line.x1.baseVal.value = e.pageX - dragObject.shiftX;
    //line.y1.baseVal.value = e.pageY - dragObject.shiftY;

    // отобразить перенос объекта при каждом движении мыши
    dragObject.avatar.style.left = e.pageX - dragObject.shiftX + 'px';
    dragObject.avatar.style.top = e.pageY - dragObject.shiftY + 'px';

    return false;

}

function createAvatar(e) {

    // запомнить старые свойства, чтобы вернуться к ним при отмене переноса
    var avatar = dragObject.elem;
    var old = {
        parent: avatar.parentNode,
        nextSibling: avatar.nextSibling,
        position: avatar.position || '',
        left: avatar.left || '',
        top: avatar.top || '',
        zIndex: avatar.zIndex || ''
    };

    // функция для отмены переноса
    avatar.rollback = function() {
        old.parent.insertBefore(avatar, old.nextSibling);
        avatar.style.position = old.position;
        avatar.style.left = old.left;
        avatar.style.top = old.top;
        avatar.style.zIndex = old.zIndex
    };

    return avatar;
}


function startDrag(e) {
    var avatar = dragObject.avatar;
    document.body.appendChild(avatar);
    avatar.style.zIndex = 9999;
    avatar.style.position = 'absolute';
}

// </> НАЧАЛО И ПРОЦЕСС ПЕРЕМЕЩЕНИЯ
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@



//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// ---- ОКОНЧАНИЕ ПЕРЕМЕЩЕНИЯ
function onMouseUpEvent(e) {

    if (dragObject.avatar)
        finishDrag(e);

    dragObject = {};
}

function findDroppable(event) {
    // спрячем переносимый элемент
    dragObject.avatar.hidden = true;
    // получить самый вложенный элемент под курсором мыши
    var elem = document.elementFromPoint(event.clientX, event.clientY);
    // показать переносимый элемент обратно
    dragObject.avatar.hidden = false;
    if(elem == null)   return null;
    return elem.closest(dropClassName);
}

function finishDrag(e) {
    var dropElem = findDroppable(e);

    if (dropElem) { // успешный перенос ...
        var id = dragObject.elem.id;
        // console.log('Успешно');
        var elem = document.getElementById(id);
        elem.classList.remove("draggable");
        var canvas = document.getElementById('canvas');
        canvas.appendChild(elem);
        // instance.getContainer().appendChild(elem);
        // var inst = instance.initElemIn(elem);

        // dragObject.avatar.className = 'one';
        // dragObject.avatar.innerHTML = '<div class="one" ></div>';
    } else { //  отмена переноса ...
        //  alert('Неудача');
        dragObject.avatar.rollback();
        // dragObject.downX
        // dragObject.elem.style.position = 'absolute';
        //dragObject.elem.style.left = dragObject.downX;
        //dragObject.elem.style.top  = dragObject.downY;
    }
}

// - </> ОКОНЧАНИЕ ПЕРЕМЕЩЕНИЯ
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@


function getCoords(elem) { // кроме IE8-
    var box = elem.getBoundingClientRect();
    return {
        top: box.top + pageYOffset,
        left: box.left + pageXOffset
    };
}