import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import RegisterView from '../views/Auth/RegisterView.vue'
import LoginView from '../views/Auth/LoginView.vue'
import Dashboard from '@/views/Me/Dashboard.vue'
import Index from '@/views/Me/Index.vue'
import Tasks from '@/views/Me/Tasks.vue'
import Employees from '@/views/Me/Employees.vue'
import { useAuthStore } from '@/stores/auth'

const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes: [
		{
			path: '/',
			name: 'home',
			component: HomeView,
			meta: { requiresAuth: false },
		},
		{
			path: '/register',
			name: 'register',
			component: RegisterView,
			meta: { requiresAuth: false },
		},
		{
			path: '/login',
			name: 'login',
			component: LoginView,
			meta: { requiresAuth: false },
		},
		{
			path: '/me',
			name: 'index',
			component: Index,
			meta: { requiresAuth: true },
			children: [
				{
					path: '',
					name: 'dashboard',
					component: Dashboard,
					meta: { requiresAuth: true },
				},
				{
					path: 'tasks',
					name: 'tasks',
					component: Tasks,
					meta: { requiresAuth: true },
				},
				{
					path: 'employees',
					name: 'employees',
					component: Employees,
					meta: { requiresAuth: true },
				},
			]
		},
	],
})

router.beforeEach((to, from) => {
	const authStore = useAuthStore()

	if (to.meta.requiresAuth && !authStore.token) {
		return {
			path: '/login',
			query: { redirect: to.fullPath },
		}
	}

	if (authStore.token && (to.path === '/login' || to.path === '/register')) {
        return { path: '/me' };
    }
})

export default router
