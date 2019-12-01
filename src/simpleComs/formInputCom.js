Vue.component('form-input-com', {
    props : ['type','value', 'name', 'params'],
    name  : 'FormInputCom',
    data  : function () {
        var label = '';
        var col   = '12';
        var placeholder = '';
        var params = this.params;

        if(params.label) label = params.label;
        if(params.col)   col   = params.col;
        if(params.placeholder)
            placeholder = params.placeholder;

        var colDivClass  = 'col-xs-' +col+ ' form-group';
        var inpTextClass = 'form-control';

        return {
            label,
            colDivClass,
            inpTextClass,
            placeholder,
        }
    },

    methods: {
        triggerEvent(event) {
            this.$emit('trigger_input', { value : event.target.value, name : this.name });
        },
    },


    template: `
         <div v-if="type == 'text'">
         
            <div :class="colDivClass">
                 <label v-if="label" >{{label}}</label>
                 <input :type="type" 
                        v-model="value" 
                        :class="inpTextClass" 
                        :placeholder="placeholder" 
                        @input="triggerEvent" >
            </div>
            
         </div>
    `,
});

