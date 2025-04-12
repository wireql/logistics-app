<script setup>
defineProps({
    type: {
        type: String,
        default: 'button'
    }
});
</script>

<template>
    <button
        :type="type"
        class="text-sm bg-dark-999 text-white py-[8px] px-[9px] rounded-[6px] w-full hover:cursor-pointer"
    >
        <slot></slot>
    </button>
</template>
