import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue'; 
import { createRouter, createWebHistory } from 'vue-router';
import AutobotList from './components/AutobotList.vue';
import AutobotCount from './components/AutobotCount.vue';

const routes = [
    { path: '/', component: AutobotCount },
    { path: '/autobots', component: AutobotList },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

const app = createApp(App);
app.use(router);
app.mount('#app');
