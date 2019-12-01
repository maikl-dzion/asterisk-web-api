
// const FreePBXCoreMixin = {
//     install(Vue, options) {
//         Vue.mixin(FreePBXCore)
//     }
// };
//
// const BaseMixin = {
//     install(Vue, options) {
//         Vue.mixin(BaseService)
//     }
// };

const routeList = [
    { path: '/ConstructorLinks', component: ConstructorLinks },
    { path: '/MainPage', component: MainPage }
]

// 3. Создаём экземпляр маршрутизатора и передаём маршруты в опции `routes`
// Вы можете передавать и дополнительные опции, но пока не будем усложнять.
const routerObject = new VueRouter({
    routeList // сокращённая запись для `routes: routes`
})


const CoreMixins = {
    install(Vue, options) {
        Vue.mixin(BaseService)
        Vue.mixin(HttpService)
        Vue.mixin(FreePBXCore)
    }
};
Vue.use(CoreMixins);

const CoreJsPlum = {
    install(Vue, options) {
        Vue.mixin(JsPlumBaseMixin)
        Vue.mixin(JsPlumInitElements)
        //Vue.mixin(FreePBXCore)
    }
};
Vue.use(CoreJsPlum);


Vue.use(BaseDirectives);
Vue.use(Plugins);

// ---- CRUD -----
Vue.use(SaveMixin);
Vue.use(GroupUpdate);
Vue.use(IvrUpdate);
Vue.use(QueueUpdate);
Vue.use(UserUpdate);
Vue.use(TrunkUpdate);
Vue.use(OutBoundRoute);
Vue.use(FileLoader);

//Vue.use(JsPlumPlugin);

const EventGlobalBus = new Vue();

var vm = new Vue({
    el: '#vue-app',
    mixins: [HttpService],
    data: {
        pageName : 'mainPage',
        routeName,
        siteUrl  ,
        routes   ,
        EventGlobalBus,
        // routerObject,
    },

    created: function () {
        // this.setPageName('constructorLinks');
        this.getCheckAuth();
        this.locationHashSet();
        // this.testMainPage();
    },

    computed: {
        pageLoader() {
            // if(this.cdrTimerId) {
            //     clearInterval(this.cdrTimerId);
            // }
            return this.pageName;
        },
    },

    methods : {

        locationHashSet() {
            var mainPage = 'mainPage';
            var locHash = location.hash;
            if(!locHash) {
                this.pageName = mainPage;
                location.hash = '#mainPage';
            }
            else {
                var hash = locHash.replace('#/','');
                this.pageName = hash;
            }
        },

        testMainPage() {
            var data = {g : '34',};
            var postData = {
                name : 'maikl',
                type : { v1 : 'v1111', v2 : 'v3333' },
                data : data,
            };

            this.httpRequest(this.postApiUrl, postData)
                .then( response => {
                    lg(response);
                });
        },

    },

    mounted(){

        $(document).ready(function() {
            $('.app-top-menu a').click(function(){
                $('.app-top-menu a').css({'background': 'none', 'color' : 'white', 'borderBottom' : '0px'});
                $(this).css({'background': 'none', 'color' : 'cyan', 'borderBottom' : '2px white solid'});
            });
        });

    },

    components: {
        //--- pages
        // 'extensions': httpVueLoader('src/pages/extensions.vue'),
        //--- components
        // 'alert': httpVueLoader('src/components/alert.vue'),
    },

});