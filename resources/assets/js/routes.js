import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: require('./components/classroom/List.vue'),
        meta:{
            forAuth: true
        }
    },
    {
        path: '/login',
        component: require('./components/Login.vue'),
        meta: {
            forVisitors: true
        }
    },
    {
        path: '/logout',
        component: require('./components/Logout.vue'),
        meta: {
            forAuth: true
        }
    },
    {
        path: '/classroom/create',
        component: require('./components/classroom/Create.vue'),
        meta: {
            forAuth: true,
            role: 'is_teacher'
        }
    },
    {
        path: '/classroom/:id',
        component: require('./components/classroom/View.vue'),
        meta: {
            forAuth: true
        }
    },
    {
        path: '/classroom/:id/edit',
        component: require('./components/classroom/Edit.vue'),
        meta: {
            forAuth: true,
            meta: {
                role: 'is_teacher'
            }
        }
    },
    {
        path: '/classroom/:id/post',
        component: require('./components/post/Post.vue'),
        meta: {
            forAuth: true
        }
    },
    {
        path: '/classroom/:id/post/assignment',
        component: require('./components/assignment/Post.vue'),
        meta: {
            forAuth: true,
            role: 'is_teacher'
        }
    },
    {
        path: '/classroom/:id/members/add',
        component: require('./components/member/Add.vue'),
        meta: {
            forAuth: true,
            role: 'is_teacher'
        }
    },
    {
        path: '/classroom/:id/members',
        component: require('./components/member/View.vue'),
        meta: {
            forAuth: true,
        }
    },
    {
        path: '/classroom/:id/assignment/:assignment_id',
        component: require('./components/assignment/View.vue'),
        meta: {
            forAuth: true
        }
    },
    {
        path: '/classroom/:id/assignment/:post_id/edit',
        component: require('./components/assignment/Edit.vue'),
        meta: {
            forAuth: true,
            role: 'is_teacher'
        }
    },
    {
        path: '/classroom/:id/post/:post_id/edit',
        component: require('./components/post/Edit.vue'),
        meta: {
            forAuth: true
        }
    }
]
const router = new VueRouter({
    routes
});

export default router