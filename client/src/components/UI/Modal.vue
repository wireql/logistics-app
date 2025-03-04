<script setup>
import { ref, watch } from 'vue';

    const props = defineProps({
        position: {
            type: String,
            default: 'top'
        },
        size: {
            type: String,
            default: 'default'
        },
        show: {
            type: Boolean,
            default: false,
        },
    })

    const showModal = ref(false);

    watch(() => props.show, show => {
        showModal.value = show
    });
</script>

<template>
    <teleport to="body" v-if="showModal">
        <div ref="modal-backdrop" class="fixed z-10 inset-0 overflow-y-auto"
            style="background-color: rgba(0, 0, 0, 0.5);">
            <div 
                class="flex justify-center min-h-screen px-6 text-center"
                :class="{
                    'items-start pt-24': position === 'top',
                    'items-end pb-24': position === 'bottom',
                    'items-center': position === 'middle',
                }"
            >
                <div 
                    class="bg-white rounded-lg text-left overflow-hidden shadow-xl p-8 w-full"
                    :class="{
                        'sm:w-xl md:w-3xl lg:w-5xl xl:w-7xl': size === 'large',
                        'sm:w-md md:w-xl lg:w-3xl xl:w-5xl': size === 'default',
                        'sm:w-sm md:w-lg lg:w-xl xl:w-2xl': size === 'small',
                    }"
                    role="dialog" aria-modal="true" aria-labelledby="modal-headline"
                >
                    <slot>Empty modal...</slot>
                </div>
            </div>
        </div>
    </teleport>
</template>