import { createRouter, createWebHistory } from "vue-router";
import AppLayout from '../components/AppLayout.vue'
import Login from "../views/Login.vue";
import Dashboard from "../views/Dashboard.vue";
import Posts from "../views/Posts/Posts.vue";
import Users from "../views/Users/Users.vue"
import RequestPassword from "../views/RequestPassword.vue";
import ResetPassword from "../views/ResetPassword.vue";
import NotFound from "../views/NotFound.vue";
import store from "../store";

import PostForm from "../views/Posts/PostForm.vue";


const routes = [
  {
    path: '/',
    redirect: '/app'
  },
  {
    path: '/app',
    name: 'app',
    redirect: '/app/dashboard',
    component: AppLayout,
    meta: {
      requiresAuth: true
    },
    children: [
      {
        path: 'dashboard',
        name: 'app.dashboard',
        component: Dashboard
      },
      {
        path: 'posts',
        name: 'app.posts',
        component: Posts
      },
      {
        path: 'posts',
        name: 'app.posts',
        component: Posts
      },
      {
        path: 'posts/create',
        name: 'app.posts.create',
        component: PostForm
      },
      {
        path: 'posts/:id',
        name: 'app.posts.edit',
        component: PostForm,
        props: {
          id: (value) => /^\d+$/.test(value)
        }
      },
      {
        path: 'users',
        name: 'app.users',
        component: Users
      },
    ]
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {
      requiresGuest: true
    }
  },
  {
    path: '/request-password',
    name: 'requestPassword',
    component: RequestPassword,
    meta: {
      requiresGuest: true
    }
  },
  {
    path: '/reset-password/:token',
    name: 'resetPassword',
    component: ResetPassword,
    meta: {
      requiresGuest: true
    }
  },
  {
    path: '/:pathMatch(.*)',
    name: 'notfound',
    component: NotFound,
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !store.state.user.token) {
    next({ name: 'login' })
  } else if (to.meta.requiresGuest && store.state.user.token) {
    next({ name: 'app.dashboard' })
  } else {
    next();
  }

})

export default router;
