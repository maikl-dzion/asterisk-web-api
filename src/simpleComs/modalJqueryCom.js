Vue.component('modal-jquery-com', {

    props : ['modal_id', 'title', 'width', 'top'],
    name  : 'ModalJqueryCom',
    data  : function () {
        var width_ = '', top_ = '';
        if(this.width) width_ = 'width:' + this.width;
        if(this.top)   top_   = 'margin-top:' + this.top;
        return {
            width_,
            top_  ,
        }
    },

    methods: {},

    template: `   
     <div  :id="modal_id" 
           class="modal modal-info fade in" 
           style="display: none; padding-right:0px;" >
           
        <div class="modal-dialog" :style="width_ + top_" >
            <div class="modal-content">

                <!--- HEADER --->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">{{title}}</h4>
                    <slot name="form-header" ></slot>  
                </div>

                <!--- BODY  --->
                <div class="modal-body" style="padding:0px; margin:0px" >
                    <div class="box box-primary" style="padding:0px; margin:0px" >
                        <div class="modal-form-com" role="form">
                          <div class="box-body" style="padding:0px 5px 10px 5px; margin:0px" >
                          
                               <slot name="form-body"></slot> 
                               
                </div></div></div></div>
                
                <!--- FOOTER --->
                <div class="modal-footer">
                
                    <slot name="form-footer" ></slot>
                    
                </div>
                
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
     </div><!-- modal --> 
    `,

});


