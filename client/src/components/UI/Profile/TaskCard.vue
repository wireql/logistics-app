<script setup>
    import { ref } from 'vue';
    import { notify } from "@kyvg/vue3-notification";

    import ArrowWay from '@/components/Icons/arrow-way.vue';
    import Copy from '@/components/Icons/copy.vue';
    import CopyActive from '@/components/Icons/copy-active.vue';
    import Delete from '@/components/Icons/delete.vue';
    import Edit from '@/components/Icons/edit.vue';
    import Dots from '@/components/Icons/dots.vue';

    const show_modal = ref(false);
    const show_modal2 = ref(false);
    const copy = ref(false);
    const props = defineProps({
        uuid: String,
        datetime: Date,
        address_from: String,
        address_to: String,
        cargo: String,
        deadline: Date,
    });

    const hideModal = () => {
        show_modal.value = false;
        show_modal2.value = false;
    };

    const hideModal2 = () => {
        setTimeout(() => {
            show_modal.value = false;
        }, 100);
    };

    const copyUuid = async () => {
        try {
            await navigator.clipboard.writeText(props.uuid);
            notify({
                title: "Копирование",
                text: "UUID скопирован в буфер обмена!",
                type: 'success'
            });
            copy.value = true;
            
            setTimeout(() => {
                copy.value = false
            }, 1000);
        } catch (err) {
            console.error('Ошибка копирования: ', err);
        }
    }
</script>

<template>
    <div class="flex flex-col gap-4 p-[15px] rounded-[12px] border border-gray-300">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-[5px] hover:cursor-pointer" v-on:click="copyUuid()">
                <div class="max-w-[50px] text-xs opacity-[60%] truncate">{{ uuid }}</div>
                <Copy v-if="!copy" color="#797979" size="14" />
                <CopyActive v-else color="#797979" size="14" />
            </div>
            <div class="text-xs opacity-[60%]">{{ datetime }}</div>
        </div>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4 sm:gap-16 flex-wrap">
                <div class="flex items-start gap-6">
                    <div class="flex flex-col gap-[5px]">
                        <div class="text-sm">{{ address_from }}</div>
                        <div class="text-xs opacity-[60%]">Откуда</div>
                    </div>
                    <ArrowWay />
                    <div class="flex flex-col gap-[5px]">
                        <div class="text-sm">{{ address_to }}</div>
                        <div class="text-xs opacity-[60%]">Куда</div>
                    </div>
                </div>

                <div class="flex flex-col gap-[5px]">
                    <div class="text-sm">{{ cargo }}</div>
                    <div class="text-xs opacity-[60%]">Груз</div>
                </div>

                <div class="flex flex-col gap-[5px]">
                    <div class="text-sm">{{ deadline }}</div>
                    <div class="text-xs opacity-[60%]">Сроки</div>
                </div>
            </div>
            <div class="relative flex items-center gap-[5px]">
                <div 
                    class="hover:cursor-pointer hover:bg-dark-50/70 p-1 rounded-[6px]" 
                    @mouseover="show_modal = true"
                    @mouseleave="hideModal2">
                    <Dots />
                </div>
                <div 
                    v-if="show_modal || show_modal2" 
                    @mouseover="show_modal2 = true" 
                    @mouseleave="hideModal" 
                    class="absolute flex flex-col bg-white top-[35px] right-0 p-[3px] rounded-[5px] gap-[10px] border border-gray-300">
                    <div class="flex items-center gap-[5px] py-[3px] px-[6px] hover:cursor-pointer hover:bg-dark-50/70 rounded-[3px]">
                        <Edit />
                        <div class="text-sm">Редактировать</div>
                    </div>
                    <hr class="border-gray-300">
                    <div class="flex items-center gap-[5px] py-[3px] px-[6px] hover:cursor-pointer hover:bg-red-100 rounded-[3px]">
                        <Delete />
                        <div class="text-sm">Удалить</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>