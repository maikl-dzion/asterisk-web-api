Vue.component('loading-popup', {
    props : ['display', 'modal_id', 'title', 'message',],
    name  : 'LoadingPopUp',
    data  : function () {
        return {}
    },

    methods: { },

    template: `  
       
     <div class="modal modal-info fade in" 
             :id="modal_id" 
             :style="'display: ' + display +'; padding-right:0px;'" >
             
        <div class="modal-dialog" >
            <div class="modal-content" >

                <div class="modal-header">
                    <h4 class="modal-title">{{title}}</h4>
                    <slot name="loading-header-content" ></slot>     
                </div>

                <div class="modal-body" style="padding:0px; margin:0px" >
                    <div class="box box-primary" style="padding:0px; margin:0px" >

                        <div class="modal-form-com" role="form">
                          <div class="box-body" style="padding:0px; margin:0px" >

                               <div class="box box-primary">
                                    <div class="box-header">
                                        <h3 class="box-title" style="font-style: italic" >Loading ...</h3>
                                    </div>
                                    <div class="box-body"  >
                                        <slot name="loading-main-content"></slot>
                                    </div> 
                                    <div class="overlay">
                                        <i class="fa fa-refresh fa-spin"></i>
                                    </div>   
                               </div>
                               
                               <slot name="loading-bottom-content"></slot>
                               
                           </div>
                        </div>

                    </div>    
                </div>
                
                <div class="modal-footer">
                    <slot name="loading-footer-content" ></slot>
                </div>
                
            </div>
        </div>
     </div>
     `,

});