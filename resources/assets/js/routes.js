import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: require('./components/ClassroomList.vue'),
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
        component: require('./components/ClassroomCreate.vue'),
        meta: {
            forAuth: true,
            role: 'is_teacher'
        }
    },
    {
        path: '/classroom/:id',
        component: require('./components/Classroom.vue'),
        meta: {
            forAuth: true
        }
    },
    {
        path: '/classroom/:id/post',
        component: require('./components/ClassroomPost.vue'),
        meta: {
            forAuth: true
        }
    },
    {
        path: '/classroom/:id/post/assignment',
        component: require('./components/ClassroomPostAssignment.vue'),
        meta: {
            forAuth: true,
            role: 'is_teacher'
        }
    },
    {
        path: '/classroom/:id/members/add',
        component: require('./components/ClassroomMemberAdd.vue'),
        meta: {
            forAuth: true,
            role: 'is_teacher'
        }
    },
    {
        path: '/classroom/:id/members',
        component: require('./components/ClassroomMembers.vue'),
        meta: {
            forAuth: true,
            role: 'is_teacher'
        }
    },
    {
        path: '/classroom/:id/assignment/:assignment_id',
        component: require('./components/ClassroomAssignment.vue'),
        meta: {
            forAuth: true
        }
    }
]
const router = new VueRouter({
    routes
});

export default router