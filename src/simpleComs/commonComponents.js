Vue.component('CommonTestComponents', {
    // props : ['params'],
    name: 'CommonTestComponents',
    data: function () {
        return {}
    },

    created: function () {
    },
    computed: {},
    methods: {},

    template: ` 
    <div>
     <!-- Start -->
            <div>
                 test-test-test
            </div>    
     <!-- End   -->
    </div>`,

});


Vue.component('header-page-panel', {
    props: ['page_title', 'small_title'],
    name: 'HeaderPagePanel',
    data: function () {
        return {}
    },

    created: function () {
    },
    computed: {},
    methods: {},

    template: ` 

     <div class="content-header" style="" >
     <!-- Start -->
        <h1 style="width:38%; border:0px red solid;font-style:italic; padding:0px; " >
            {{page_title}} <small v-if="small_title">({{small_title}})</small>
        </h1>
        <!--<v-breadcrumbs -->
            <!--style="width:12.5%; float:right; border:0px red solid; padding:3px; align-items:right !important; " -->
            <!--:items="[{ text : 'Главная'}, { text : page_title}]" -->
            <!--divider=">" -->
        <!--&gt;</v-breadcrumbs>-->
        
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Главная </a></li>
            <li class="active"> {{page_title}}</li>
        </ol>
     <!-- End   -->
     
       <div style="clear:both" ></div>
       
       <!--<nav class="v-toolbar" data-booted="true" style="margin-top: 0px; padding-right: 0px; padding-left: 0px; transform: translateY(0px);">-->
         <!--<div class="v-toolbar__content" style="height: 64px;">-->
             <!--<button type="button" class="v-toolbar__side-icon v-btn v-btn&#45;&#45;fab v-btn&#45;&#45;flat v-btn&#45;&#45;round v-btn&#45;&#45;text theme&#45;&#45;dark v-size&#45;&#45;default">-->
                 <!--<span class="v-btn__content"><i aria-hidden="true" class="v-icon material-icons theme&#45;&#45;dark">menu</i></span>-->
             <!--</button>-->
             <!---->
             <!--<div class="v-toolbar__title">Discover</div>-->
             <!--<div class="spacer"></div>-->
             <!--<button type="button" class="v-btn v-btn&#45;&#45;fab v-btn&#45;&#45;flat v-btn&#45;&#45;icon v-btn&#45;&#45;round theme&#45;&#45;dark v-size&#45;&#45;default">-->
             <!--<span class="v-btn__content"><i aria-hidden="true" class="v-icon material-icons theme&#45;&#45;dark">search</i></span>-->
             <!--</button>-->
         <!--</div>-->
       <!--</nav>-->
       
    </div>

     

    `,

});