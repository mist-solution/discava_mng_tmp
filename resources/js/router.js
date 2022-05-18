import { createRouter, createWebHistory } from "vue-router";

const Home = () => import ('./components/Home')
const TaskListComponent = () => import ('./components/TaskListComponent')
const TaskShowComponent = () => import ('./components/TaskShowComponent')
const TaskCreateComponent = () => import ('./components/TaskCreateComponent')
const TaskEditComponent = () => import ('./components/TaskEditComponent')
const QuillEditorComponent = () => import ('./components/QuillEditor')
const NewsListComponent = () => import ('./components/pages/news_list/NewsListPageComponent')
const EndUserRegistComponent = () => import ('./components/pages/end_user/EndUserRegistComponent')
const EndUserListComponent = () => import ('./components/pages/end_user/EndUserListComponent')

const routes = [
    // 一覧画面
    {
        path: '/',
        name: 'home',
        component: Home
    },
    // 一覧画面
    {
        path: '/news',
        name: 'news.list',
        component: NewsListComponent
    },
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
    // 一覧画面
    {
        path: '/enduser/register',
        name: 'enduser.register',
        component: EndUserRegistComponent
    },
    // ユーザ一覧画面
    {
        path: '/enduser',
        name: 'enduser.list',
        component: EndUserListComponent
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
})
export default router;