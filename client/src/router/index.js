import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import RegisterView from '../views/Auth/RegisterView.vue'
import LoginView from '../views/Auth/LoginView.vue'
import Dashboard from '@/views/Me/Dashboard.vue'
import Index from '@/views/Me/Index.vue'
import Tasks from '@/views/Me/Tasks.vue'
import EmployeesIndex from '@/views/Me/EmployeesIndex.vue'
import EmployeesCreate from '@/views/Me/EmployeesCreate.vue'
import EmployeesUpdate from '@/views/Me/EmployeesUpdate.vue'

import { useAuthStore } from '@/stores/auth'
import VehiclesIndex from '@/views/Me/VehiclesIndex.vue'
import VehiclesUpdate from '@/views/Me/VehiclesUpdate.vue'
import VehiclesCreate from '@/views/Me/VehiclesCreate.vue'
import AddressIndex from '@/views/Me/AddressIndex.vue'
import AddressCreate from '@/views/Me/AddressCreate.vue'
import AddressUpdate from '@/views/Me/AddressUpdate.vue'

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
					name: 'EmployeesIndex',
					component: EmployeesIndex,
					meta: { requiresAuth: true },
				},
				{
					path: 'employees/:id',
					name: 'EmployeesUpdate',
					component: EmployeesUpdate,
					meta: { requiresAuth: true },
				},
				{
					path: 'employees/new',
					name: 'EmployeesCreate',
					component: EmployeesCreate,
					meta: { requiresAuth: true },
				},
				{
					path: 'vehicles',
					name: 'VehiclesIndex',
					component: VehiclesIndex,
					meta: { requiresAuth: true },
				},
				{
					path: 'vehicles/new',
					name: 'VehiclesCreate',
					component: VehiclesCreate,
					meta: { requiresAuth: true },
				},
				{
					path: 'vehicles/:id',
					name: 'VehiclesUpdate',
					component: VehiclesUpdate,
					meta: { requiresAuth: true },
				},
				{
					path: 'address',
					name: 'AddressIndex',
					component: AddressIndex,
					meta: { requiresAuth: true },
				},
				{
					path: 'address/new',
					name: 'AddressCreate',
					component: AddressCreate,
					meta: { requiresAuth: true },
				},
				{
					path: 'address/:id',
					name: 'AddressUpdate',
					component: AddressUpdate,
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
