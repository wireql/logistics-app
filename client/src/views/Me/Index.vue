<script setup>
    import DashboardSidebar from '@/components/UI/Profile/DashboardSidebar.vue';
    import { onMounted } from 'vue';
    import { getUser } from '../../api/User/index'
    import { useAuthStore } from '@/stores/auth';
    import router from '@/router';

    const authStore = useAuthStore();

    onMounted(() => {
        getUser(authStore.token).then(res => {
            
        }).catch(err => {
            authStore.logout();
            router.push('/login');
        });
    })
</script>

<template>
    <div class="flex w-full h-screen">
        <DashboardSidebar />

        <div class="w-full flex justify-center overflow-y-auto">
            <div class="px-5 lg:px-0 lg:max-w-5xl w-full">
                <router-view />
            </div>
        </div>
    </div>
</template>