<script setup>
import { onMounted, ref } from 'vue';
import { getUser } from '../../api/User/index';
import { useAuthStore } from '@/stores/auth';
import router from '@/router';

import AppLoadingSpinner from '@/components/UI/App/AppLoadingSpinner.vue';
import Sidebar from '@/components/UI/App/Sidebar.vue';

const loading = ref(true);

const authStore = useAuthStore();

onMounted(async () => {
    try {
        const response = await getUser(authStore.token);
    } catch (error) {
        authStore.logout();
        router.push('/login');
    } finally {
        loading.value = false;
    }
});
</script>

<template>
    <AppLoadingSpinner v-if="loading" />
    <div v-else class="flex w-full h-screen">
        <Sidebar />

        <div class="w-full flex justify-center overflow-y-auto">
            <div class="px-5 lg:max-w-5xl w-full">
                <router-view />
            </div>
        </div>
    </div>
</template>
