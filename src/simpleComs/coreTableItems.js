Vue.component('core-table-items', {
    props : ['items','headers', 'uid_name', 'type_name'],
    name  : 'CoreTableItems',
    //mixins: [HttpService, BaseMixin],
    data  : function () {
        return {
        }
    },

    // methods: {},

    template: `  
    <div>
        <table slot="box-body" class="table table-bordered">
        
           <thead><tr>
               <th v-for="(header, fieldName) in headers" v-if="header.label" >
                   {{header.label}} ({{fieldName}})
               </th>
               <th >Редак.</th>
               <th >Удалить</th>
           </tr></thead>
           
           <tbody>
               <tr v-for="(row, key) in items" :key="row[uid_name]" :data-id="row[uid_name]" :id="row[uid_name]" >

                   <td v-for="(header, fieldName) in headers" v-if="header.label" >

                       <input v-model="row[fieldName]"
                              :placeholder="header.label" :disabled="header.disabled"
                              type="text"  class="form-control number" >
                   </td>
                   <td>
                       <button @click="editItem(row, type_name)" class="btn btn-success" style="width:50px" >
                           <i class="fa fa-fw fa-save"></i>
                       </button>
                   </td>
                   <td>
                       <button  @click="deleteItem(row, type_name)" style="width:50px" type="button" class="btn btn-danger" >
                           <i class="fa fa-fw fa-minus-circle" ></i>
                       </button>
                   </td>

               </tr>
           </tbody>
           
       </table>
 
    </div>`,

});

