

Vue.component('create-new-element', {
    props : ['elem', 'params'],
    name  : 'CreateNewElement',
    data  : function () {
        return {

        }
    },

    methods: {

    },

    template: `<div>
    <!----  Start ---->
        
        <div id="user-connect-30" 
             data-id="30" 
             data-type="user"  
             data-drag-state="drop" 
             class="atc-icon-users col-md-3 col-sm-6 col-xs-12 dragItemsStyle dragItem jtk-draggable jtk-endpoint-anchor" 
             style="left: 833px; top: 171px; position: absolute;">
             
                 <i class="material-icons" 
                           style="position: absolute; color: brown; font-size: 20px; 
                                  cursor: pointer; border: 0px solid gainsboro; 
                                  padding: 3px; border-radius: 4px; margin: -18px 0px 0px 65px;">border_color</i> 
                                  
                 <div class="info-block">
                    <div>Внутрений номер</div> 
                    <div>Admin</div> 
                    <div>30</div>
                 </div>
                 
                 <div class="userCallForwarding">
                     <div style="padding-top:6px;float:left;">8902486209</div>
                     <i class="material-icons" style="color:brown; float:right;">subdirectory_arrow_left</i>
                     <div style="clear:both"></div>
                 </div>
        </div>    
             
    <!----  End  ---->
    </div>`,
});