
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.moment = require('moment');

import {ServerTable} from 'vue-tables-2';
Vue.use(ServerTable, {}, false, 'bootstrap4', 'default');

import VueResource from 'vue-resource';
Vue.use(VueResource)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
//Componente para la lista de cursos
import Courses from './components/Courses';
Vue.component('courses-list', Courses);

//Componentes para el chat
Vue.component('message', require('./components/Message.vue'));
Vue.component('sent-message', require('./components/Sent.vue'));

const app = new Vue({
    el: '#app',
    data: {
        messages: [],
    },
    mounted(){
        this.fetchMessages();
        Echo.private('chat')
            .listen('MessageSentEvent', (e) => {
            this.messages.push({
                user: e.user,
                message: e.message.message,
                conversation_id: e.message.conversation_id
            })
        })
    },
    methods: {
        addMessage(message) {
            this.messages.push(message)
            axios.post('/messages', message).then(response => {
                console.log(response);
            })
            .catch(error => {
                console.log(error.response)
            });
        },
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.messages = response.data
            })
        }
    }

});


