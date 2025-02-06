<script setup>
import DashboardSidebar from '@/components/UI/Profile/DashboardSidebar.vue';
</script>

<template>
    <div class="flex w-full h-screen">
        <DashboardSidebar />

        <div class="w-full flex justify-center overflow-y-auto">
            <div class="max-w-5xl w-full">
                <router-view />
            </div>
        </div>
    </div>
</template>