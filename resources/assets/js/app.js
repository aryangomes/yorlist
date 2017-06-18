
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import store from './store';
import YorList from './components/YorList.vue';
import YorItem from './components/YorItem.vue';
Vue.use(require('vue-resource'));
Vue.http.options.emulateJSON = true;
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */




const app = new Vue({
    el: '#app',
    store,

    components:{
        YorList, YorItem
    }



});
