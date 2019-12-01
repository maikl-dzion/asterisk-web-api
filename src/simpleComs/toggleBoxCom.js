Vue.component('toggle-box-com', {
    props : ['title','note', 'col_num'],
    name  : 'ToggleBoxCom',
    data  : function () {
        if(!this.col_num) this.col_num = 12;
        if(!this.note)    this.note = '';
        return {}
    },

    // methods: {},

    template: `<div :class="'col-md-' + col_num" >

        <div class="box box-widget">
            <div class="box-header with-border">
                <div class="user-block">
                    <span class="username" style="margin-left:0px;font-style: oblique" >
                         <a href="#">{{title}}</a>
                    </span>
                    <span class="description" style="margin-left:0px;" >{{note}}</span>
                </div>
                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Mark as read">
                        <i class="fa fa-circle-o"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                </div>
            </div>

            <div class="box-body" style=""><slot name="box-body" ></slot></div>
            <div class="box-footer box-comments" style=""><slot name="box-comments" ></slot></div>
            <div class="box-footer" style=""><slot name="box-footer" ></slot>   </div>

        </div>

    </div>`,
});

