import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import RegisterView from '../views/Auth/RegisterView.vue'
import LoginView from '../views/Auth/LoginView.vue'
import Dashboard from '@/views/Me/Dashboard.vue'
import Index from '@/views/Me/Index.vue'
import Tasks from '@/views/Me/Tasks.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView,
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView,
    },
    {
      path: '/me',
      name: 'index',
      component: Index,
      children: [
        {
          path: '',
          name: 'dashboard',
          component: Dashboard,
        },
        {
          path: 'tasks',
          name: 'tasks',
          component: Tasks,
        },
      ]
    },
  ],
})

export default router
