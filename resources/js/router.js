import { createRouter, createWebHistory } from "vue-router";

const TaskListComponent = () => import('./components/TaskListComponent')
const TaskShowComponent = () => import('./components/TaskShowComponent')
const TaskCreateComponent = () => import('./components/TaskCreateComponent')
const TaskEditComponent = () => import('./components/TaskEditComponent')
const QuillEditorComponent = () => import('./components/QuillEditor')

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

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
})
export default router;
