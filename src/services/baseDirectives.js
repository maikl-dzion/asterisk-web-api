

const BaseDirectives = {
    install(Vue, options) {
       
        Vue.directive('testDirectives', {
            bind: function (el, binding, vnode) {
                el.clickOutsideEvent = function (event) {
                    // here I check that click was outside the el and his childrens
                    if (!(el == event.target || el.contains(event.target))) {
                        // and if it did, call method provided in attribute value
                        vnode.context[binding.expression](event);
                    }
                };

                document.body.addEventListener('click', el.clickOutsideEvent)
            },
        })

        // Vue.directive('htmlrender', function(newValue) {
        //     this.el.innerHTML = newValue;
        //     this.vm.$compile(this.el);
        // })

        // Регистрируем глобальную пользовательскую директиву `v-focus`
        Vue.directive('add-inner-html', {
            // Когда привязанный элемент вставлен в DOM...
            inserted: function (el, val) {
                // Переключаем фокус на элемент
                el.innerHTML = '<div>test-test</div>';
                // this.vm.$compile(el);
            }
        })

    }
};