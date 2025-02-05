<script setup>
import { computed } from 'vue';

const props = defineProps({
    label: String,
    type: {
        type: String,
        default: 'text'
    },
    placeholder: String
});

const id = computed(() => `input-${Math.random().toString(36).substr(2, 9)}`);
</script>

<template>
    <div class="flex flex-col gap-[5px] w-full">
        <label :for="id" class="text-sm opacity-[60%]">{{ label }}</label>
        <input :id="id" :type="type" :placeholder="placeholder"
            class="text-sm w-full border border-gray-300 focus:border-gray-700 bg-dark-50 py-[6px] px-[9px] rounded-[6px]"
            v-bind="$attrs" />
    </div>
</template>