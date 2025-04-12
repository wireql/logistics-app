<script setup>
import ArrowUp from '@/components/Icons/arrow-up.vue';

defineProps({
    title: {
        type: String,
        default: null
    },
    data: {
        type: String,
        default: null
    }
});
</script>
<template>
    <div
        class="flex flex-col h-[120px] justify-between p-[15px] border border-gray-300 rounded-[12px] col-span-12 sm:col-span-6 md:col-span-4"
    >
        <div class="flex flex-col gap-[5px]">
            <slot></slot>
            <div class="text-xs opacity-[60%]">{{ title }}</div>
        </div>
        <div class="flex justify-between items-center">
            <div class="text-base font-bold">{{ data }}</div>
            <div
                class="flex items-center py-[3px] px-[6px] border-1 rounded-full w-max"
            >
                <ArrowUp />
                <div class="text-xs">12%</div>
            </div>
        </div>
    </div>
</template>
