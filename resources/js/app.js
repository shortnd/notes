import Vue from 'vue';
import VueRouter from 'vue-router';
import NoteApp from './components/NoteApp.vue';
import routes from './routes';
import notesStore from "./store/notesStore";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes
});

window.events = new Vue();

window.flash = function(message, type = 'success') {
    window.events.$emit('flash', message, type);
}

new Vue({
    el: '#app',
    render: h => h(NoteApp),
    router,
    store: notesStore
});
