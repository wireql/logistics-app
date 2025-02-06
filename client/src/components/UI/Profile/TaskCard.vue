<script setup>
import ArrowWay from '@/components/Icons/arrow-way.vue';
import Copy from '@/components/Icons/copy.vue';
import Button from '@/components/UI/Button.vue';

defineProps({
    uuid: String,
    datetime: Date,
    address_from: String,
    address_to: String,
    cargo: String,
    deadline: Date,
});
</script>

<template>
    <div class="flex flex-col gap-4 p-[15px] rounded-[12px] border border-gray-300">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-[5px] hover:cursor-pointer">
                <div class="text-xs opacity-[60%]">{{uuid}}</div>
                <Copy />
            </div>
            <div class="text-xs opacity-[60%]">{{datetime}}</div>
        </div>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-16">
                <div class="flex items-start gap-6">
                    <div class="flex flex-col gap-[5px]">
                        <div class="text-sm">{{address_from}}</div>
                        <div class="text-xs opacity-[60%]">Откуда</div>
                    </div>
                    <ArrowWay />
                    <div class="flex flex-col gap-[5px]">
                        <div class="text-sm">{{address_to}}</div>
                        <div class="text-xs opacity-[60%]">Куда</div>
                    </div>
                </div>

                <div class="flex flex-col gap-[5px]">
                    <div class="text-sm">{{cargo}}</div>
                    <div class="text-xs opacity-[60%]">Груз</div>
                </div>
                
                <div class="flex flex-col gap-[5px]">
                    <div class="text-sm">{{deadline}}</div>
                    <div class="text-xs opacity-[60%]">Сроки</div>
                </div>
            </div>
            <Button class="w-max">Отправить</Button>
        </div>
    </div>
</template>