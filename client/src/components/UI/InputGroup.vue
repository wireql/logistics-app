<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: String,
    label: String,
    type: {
        type: String,
        default: 'text'
    },
    placeholder: String,
    error: {
        type: String,
        default: null
    },
    require: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['update:modelValue']);
const id = computed(() => `input-${Math.random().toString(36).substr(2, 9)}`);
</script>

<template>
    <div class="flex flex-col gap-[5px] w-full">
        <label :for="id" class="text-sm opacity-[60%]"
            >{{ label }}
            <span v-if="require" class="text-red-400 text-base">*</span></label
        >
        <input
            :id="id"
            :type="type"
            :placeholder="placeholder"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            class="text-sm w-full border border-gray-300 focus:border-gray-700 bg-dark-100 py-[6px] px-[9px] rounded-[6px]"
            v-bind="$attrs"
        />
        <div class="text-xs text-red-300" v-if="error !== null">
            {{ error }}
        </div>
    </div>
</template>
