<script setup>
import { computed } from 'vue';

const props = defineProps({
  size: {
    type: [String, Number],
    default: 24,
  },
  color: {
    type: String,
    default: 'white',
  },
});

const iconSize = computed(() => (typeof props.size === 'number' ? `${props.size}px` : props.size));
</script>

<template>
    <svg
        :width="iconSize"
        :height="iconSize"
        viewBox="0 0 24 24"
        :stroke="color"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
    >
        <path d="M5 12H19M19 12L15 16M19 12L15 8" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" />
    </svg>
</template>