/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// import VueSocketio from 'vue-socket.io';
import io from 'socket.io-client';

const socket = io('http://localhost:8890');

socket.on('connect', function(){
    console.log('connected on local');
});

socket.on('event', function(data){
    console.log(data);
});

socket.on('disconnect', function(){});
require('./bootstrap');

window.Vue = require('vue');
// Vue.use(VueSocketio, 'http://localhost:8890');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component(
    'example-component',
    require('./components/ExampleComponent.vue')
);

const app = new Vue({
    el: '#app'
});


socket.on('message', (data) => {
    data = jQuery.parseJSON(data);
    if(data.user && data.message){
        $( "#messages" ).append( "<strong>"+data.user+":</strong><p>"+data.message+"</p>" );
    }

});
