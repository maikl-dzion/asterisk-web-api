
Vue.component('draw-items-render', {
    props : ['items', 'params', 'box_class'],
    name  : 'DrawItemRender',
    data  : function () {
        var num = '';
        if(this.params.num)
            num = this.params.num;
        return {
            num,
            containerClass : 'drag-container row',
            itemClass      : 'col-md-3 col-sm-6 col-xs-12 dragItemsStyle dragItem',
            infoClass      : 'info-block',
            listOpen : true,

            searchItem : '',
        }
    },

    methods: {
        listToggle() {
            (this.listOpen) ? this.listOpen = false : this.listOpen = true;
        },

        setActionType() {
            this.$emit('get_action_type', this.params.typeName);
        },

        edit(item) {
            let param = { params : this.params, item : item , type : this.params.typeName };
            this.$emit('edit_action', param);
        },
    },

    template: ` 
         <div :class="box_class + ' ' + containerClass"  >
         <!----  Init ---->
            
            <template>
                  <v-toolbar dark color="primary">

                        <v-toolbar-title class="white--text">
                          <v-text-field v-model="searchItem" label="Поиск ..."></v-text-field>
                        </v-toolbar-title>
                    
                        <v-spacer></v-spacer>
                    
                        <v-btn icon>
                          <v-icon>search</v-icon>
                        </v-btn>
                    
                        <v-btn icon @click="setActionType()" >
                          <v-icon>queue</v-icon>
                        </v-btn>

                  </v-toolbar>
            </template>
         
            <div v-for="(row, key) in items"
                 :class="params.iconClass + ' ' + itemClass"
                 :id="params.typeName + '-connect-' + row[params.uid]"
                 :data-id="row[params.uid]"
                 :data-type="params.typeName" @dblclick="edit(row)" >
    
                 <div class="ep" :action="params.typeName + '-' + row[params.uid]"></div>
    
                 <div :class="infoClass">
                    <div v-if="params.title" >{{params.title}}</div>
                    <div v-if="row[params.name]" >{{row[params.name]}}</div>
                    <div v-if="num" >{{row[num]}}</div>
                 </div>
                
            </div>    
         <!----  End  ---->
         </div>`,

});