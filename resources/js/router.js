import { createRouter, createWebHistory } from "vue-router";

const Home = () => import('./components/Home')
const TaskListComponent = () => import('./components/TaskListComponent')
const TaskShowComponent = () => import('./components/TaskShowComponent')
const TaskCreateComponent = () => import('./components/TaskCreateComponent')
const TaskEditComponent = () => import('./components/TaskEditComponent')
const QuillEditorComponent = () => import('./components/QuillEditor')
const NewsListComponent = () => import('./components/pages/news_list/NewsListPageComponent')
const AnnounceRegisterComponent = () => import ('./components/pages/announce/AnnounceRegisterComponent')
const EndUserRegistComponent = () => import('./components/pages/end_user/EndUserRegistComponent')
const EndUserUpdateComponent = () => import('./components/pages/end_user/EndUserUpdateComponent')
const EndUserListComponent = () => import('./components/pages/end_user/EndUserListComponent')
const NewsDetailComponent = () => import('./components/pages/news_list/NewsDetailComponent')
const NewsApprovalConfirmComponent = () => import('./components/pages/news_list/NewsApprovalComponent')

const routes = [
    // ダッシュボード画面
//    {
//        path: '/',
//        name: 'home',
//        component: Home
//    },
    // ※初回リリース時点ではお知らせ一覧に直接遷移します。
    {
        path: '/',
        redirect: '/news'
    },
    // お知らせ一覧画面
    {
        path: '/news',
        name: 'news.list',
        component: NewsListComponent
    },

    // お知らせ詳細・削除画面
    {
        path: '/news/:announceId',
        name: 'news.detail',
        component: NewsDetailComponent,
        props: true
    },

    // お知らせ承認画面
    {
        path: '/news/:announceId/approvalProcess',
        name: 'news.approval',
        component: NewsApprovalConfirmComponent,
        props: true
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
    // お知らせ登録
    {
        path: '/announce/register',
        name: 'announce.register',
        component: AnnounceRegisterComponent,
    },
    // ユーザ登録画面
    {
        path: '/enduser/register',
        name: 'enduser.register',
        component: EndUserRegistComponent
    },
    // ユーザ更新画面
    {
        path: '/enduser/:user_id',
        name: 'enduser.update',
        component: EndUserUpdateComponent,
        props: true
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