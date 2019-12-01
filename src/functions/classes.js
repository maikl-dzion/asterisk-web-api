
class Alert {
    constructor(options) {
        this.class = options.class || 'success';
        this.msg   = options.msg;
        this.showTime = options.showTime || 2500;
    }

    display() {
        let alert = $(
            `<div class=""  style="position:fixed; z-index: 9999999999999" >
                <h4 class="alert-heading">${this.msg}</h4>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
             </div>`
        );

        alert.appendTo('body');
        setTimeout( () => alert.remove(), this.showTime);
    }
}
