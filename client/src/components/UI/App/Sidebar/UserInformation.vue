<script setup>
defineProps({
    data: {
        type: Object,
        default: null
    }
});
</script>
<template>
    <div
        class="flex items-center justify-center lg:justify-start lg:gap-[15px]"
    >
        <div class="w-[24px] h-[24px] rounded-full bg-dark-50"></div>
        <div class="hidden lg:flex flex-col gap-[5px]">
            <div class="text-sm font-bold">
                {{ data.first_name }}
                {{ data.middle_name }}
                {{ data.last_name }}
            </div>
            <div class="text-xs">{{ data.email }}</div>
        </div>
    </div>
</template>
