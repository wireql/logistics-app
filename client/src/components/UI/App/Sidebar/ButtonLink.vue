<script setup>
defineProps({
    title: {
        type: String,
        default: null
    },
    path: {
        type: Object,
        default: { name: 'Dashboard' }
    }
});
</script>
<template>
    <router-link
        :to="path"
        class="flex flex-row items-center gap-[15px] p-2 rounded-[12px] hover:bg-dark-50/70 hover:cursor-pointer"
    >
        <slot />
        <div class="text-sm font-bold hidden lg:block">{{ title }}</div>
    </router-link>
</template>
