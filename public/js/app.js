/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

// /**
//  * First we will load all of this project's JavaScript dependencies which
//  * includes Vue and other libraries. It is a great starting point when
//  * building robust, powerful web applications using Vue and Laravel.
//  */
// require('./bootstrap');
// window.Vue = require('vue');
// import VueRouter from 'vue-router'
// import BootstrapVue from 'bootstrap-vue'
// import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap-vue/dist/bootstrap-vue.css'
// import App from './AppComponent'
// import Home from './components/HomeComponent'
// import Example from './components/ExampleComponent'
// import IndexLayout from './components/Layout/IndexLayoutComponent'
// import Detail from './components/DetailComponent'
// import Page1 from './components/Page1'
// import Page2 from './components/Page2'
// import Page3 from './components/Page3'
// import Page4 from './components/Page4'
// import Page5 from './components/Page5'
// import Page6 from './components/Page6'
// import Page7 from './components/Page7'
// import Page8 from './components/Page8'
// import Page9 from './components/Page9'
// import Page10 from './components/Page10'
// import Page11 from './components/Page11'
// import Page12 from './components/Page12'
// import Page13 from './components/Page13'
// Vue.use(VueRouter)
// Vue.use(BootstrapVue)
// const router = new VueRouter({
//     mode: 'history',
//     routes: [
//         {
//             path: '/vueui/home',
//             redirect: '/vueui/home',
//             component: App,
//             children: [
//                 {
//                     path: '/vueui/home',
//                     redirect: '/vueui/home',
//                     component: IndexLayout,
//                     children: [
//                         {
//                             path: '/vueui/home',
//                             name: 'Home',
//                             component: Home,
//                         },
//                         {
//                             path: '/vueui/detail',
//                             name: 'detail',
//                             component: Detail,                            
//                         },
//                         {
//                             path: '/vueui/page1',
//                             name: 'page1',
//                             component: Page1,                            
//                         },
//                         {
//                             path: '/vueui/page2',
//                             name: 'page2',
//                             component: Page2,                            
//                         },
//                         {
//                             path: '/vueui/page3',
//                             name: 'page3',
//                             component: Page3,                            
//                         },
//                         {
//                             path: '/vueui/page4',
//                             name: 'page4',
//                             component: Page4,                            
//                         },
//                         {
//                             path: '/vueui/page5',
//                             name: 'page5',
//                             component: Page5,                            
//                         },
//                         {
//                             path: '/vueui/page6',
//                             name: 'page6',
//                             component: Page6,                            
//                         },
//                         {
//                             path: '/vueui/page7',
//                             name: 'page7',
//                             component: Page7,                            
//                         },
//                         {
//                             path: '/vueui/page8',
//                             name: 'page8',
//                             component: Page8,                            
//                         },
//                         {
//                             path: '/vueui/page9',
//                             name: 'page9',
//                             component: Page9,                            
//                         },
//                         {
//                             path: '/vueui/page10',
//                             name: 'page10',
//                             component: Page10,                            
//                         },
//                         {
//                             path: '/vueui/page11',
//                             name: 'page11',
//                             component: Page11,                            
//                         },
//                         {
//                             path: '/vueui/page12',
//                             name: 'page12',
//                             component: Page12,                            
//                         },
//                         {
//                             path: '/vueui/page13',
//                             name: 'page13',
//                             component: Page13,                            
//                         }
//                     ]
//                 }
//             ]
//         }
//     ],
// });
// /**
//  * The following block of code may be used to automatically register your
//  * Vue components. It will recursively scan this directory for the Vue
//  * components and automatically register them with their "basename".
//  *
//  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
//  */
// // const files = require.context('./', true, /\.vue$/i);
// // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
// // Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('App', require('./AppComponent.vue').default);
// /**
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */
// const app = new Vue({
//     el: '#app',
//     render: h => h(App),
//     router
// });

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /home/aladdin/Desktop/Aladdin Online Shop/Allardin/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /home/aladdin/Desktop/Aladdin Online Shop/Allardin/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });