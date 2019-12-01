Vue.component('auth-form-com', {
    props : ['auth_form_state'],
    name: 'AuthFormCom',
    // mixins: [HttpService, BaseMixin],
    data: function () {
        return {
            item : {
                username : 'admin',
                password : '123456Aa',
            },
        }
    },

    //created : function () {},
    //computed: {},
    methods : {

        auth() {
            var postData = this.item;
            // this.send('post', '', postData).then( response => {
            //     this.auth_form_state = false;
            // });

            this.httpPromise(this.postApiUrl, 'POST', postData).then(response=> {
                this.auth_form_state = false;
            });
        },

    },

    template: `  
    <div v-if="auth_form_state" style="position: fixed; z-index:9999; top:2%; left:20%; right:20%;  border:0px red solid" >
            
         <div class="modal modal-info fade in" id="modal-auth-box" style="display: block; padding-right: 17px;">
              <div class="modal-dialog"><div class="modal-content">
                
                  <div class="modal-header">
                      <h4 class="modal-title">Авторизация</h4>
                  </div>
                  
                  <div class="modal-body"><p>
                    
                      <div class="box-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Логин</label>
                          <input v-model="item.username" type="text" class="form-control" id="exampleInputEmail1" placeholder="Login">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1">Пароль</label>
                          <input v-model="item.password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                      </div>
                    
                  </p></div>
                  
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline" @click="auth()" >Отправить</button>
                  </div>
                  
              </div></div><!-- /.modal-dialog -->
        </div>
            
            
    </div>`,

});

