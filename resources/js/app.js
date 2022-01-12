import 'vuetify/dist/vuetify.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import { createApp } from 'vue'
import { createRouter, createWebHistory } from "vue-router";
import HeaderComponent from './components/HeaderComponent';
import ExampleComponent from './components/ExampleComponent'

const TaskListComponent = () => import('./components/TaskListComponent')
const TaskShowComponent = () => import('./components/TaskShowComponent')
const TaskCreateComponent = () => import('./components/TaskCreateComponent')
const TaskEditComponent = () => import('./components/TaskEditComponent')
const QuillEditorComponent = () => import('./components/QuillEditor')

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;


const routes = [
    // 一覧画面
    {
        path: '/tasks',
        name: 'task.list',
        component: TaskListComponent
    },

    // 詳細画面
    {
        path: '/tasks/:taskId',
        name: 'task.show',
        component: TaskShowComponent,
        props: true
    },

    // 登録画面
    {
        path: '/tasks/create',
        name: 'task.create',
        component: TaskCreateComponent
    },

    // 編集画面
    {
        path: '/tasks/:taskId/edit',
        name: 'task.edit',
        component: TaskEditComponent,
        props: true
    },

    // QuillEditor
    {
        path: '/quilleditor',
        name: 'quilleditor',
        component: QuillEditorComponent,
        props: true
    },
]

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
})

const app = createApp({
    components: {
        ExampleComponent,
        HeaderComponent,
    }
});
app.use(router);
app.mount('#app')
