/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
import BootstrapVue from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import App from './AppComponent'
import Home from './components/HomeComponent'
import Example from './components/ExampleComponent'
import IndexLayout from './components/Layouts/IndexLayoutComponent'
import Detail from './components/DetailComponent'
import Page1 from './components/Page1'
import Page2 from './components/Page2'
import Page3 from './components/Page3'
import Page4 from './components/Page4'
import Page5 from './components/Page5'
import Page6 from './components/Page6'
import Page7 from './components/Page7'
import Page8 from './components/Page8'
import Page9 from './components/Page9'
import Page10 from './components/Page10'
import Page11 from './components/Page11'
import Page12 from './components/Page12'
import Page13 from './components/Page13'



Vue.use(VueRouter)
Vue.use(BootstrapVue)

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            redirect: '/',
            component: App,
            children: [
                {
                    path: '/',
                    redirect: '/',
                    component: IndexLayout,
                    children: [
                        {
                            path: '/',
                            name: 'Home',
                            component: Home,
                        },
                        {
                            path: '/detail',
                            name: 'detail',
                            component: Detail,                            
                        },
                        {
                            path: '/page1',
                            name: 'page1',
                            component: Page1,                            
                        },
                        {
                            path: '/page2',
                            name: 'page2',
                            component: Page2,                            
                        },
                        {
                            path: '/page3',
                            name: 'page3',
                            component: Page3,                            
                        },
                        {
                            path: '/page4',
                            name: 'page4',
                            component: Page4,                            
                        },
                        {
                            path: '/page5',
                            name: 'page5',
                            component: Page5,                            
                        },
                        {
                            path: '/page6',
                            name: 'page6',
                            component: Page6,                            
                        },
                        {
                            path: '/page7',
                            name: 'page7',
                            component: Page7,                            
                        },
                        {
                            path: '/page8',
                            name: 'page8',
                            component: Page8,                            
                        },
                        {
                            path: '/page9',
                            name: 'page9',
                            component: Page9,                            
                        },
                        {
                            path: '/page10',
                            name: 'page10',
                            component: Page10,                            
                        },
                        {
                            path: '/page11',
                            name: 'page11',
                            component: Page11,                            
                        },
                        {
                            path: '/page12',
                            name: 'page12',
                            component: Page12,                            
                        },
                        {
                            path: '/page13',
                            name: 'page13',
                            component: Page13,                            
                        }
                    ]
                }
            ]
        }
    ],
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('App', require('./AppComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    render: h => h(App),
    router
});
