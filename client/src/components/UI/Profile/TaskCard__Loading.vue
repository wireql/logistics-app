<script setup>
import ArrowWay from '@/components/Icons/arrow-way.vue';
import Copy from '@/components/Icons/copy.vue';
import Button from '@/components/UI/Button.vue';
</script>

<template>
    <div class="flex flex-col gap-4 p-[15px] rounded-[12px] border border-gray-300">
        <div class="flex items-center justify-between">
            <div class="h-[12px] w-[150px] rounded bg-gray-200"></div>
            <div class="h-[12px] w-[100px] rounded bg-gray-200"></div>
        </div>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-16">
                <div class="flex items-start gap-6">
                    <div class="flex flex-col gap-[5px]">
                        <div class="h-[12px] rounded bg-gray-200"></div>
                        <div class="text-xs opacity-[60%]">Откуда</div>
                    </div>
                    <ArrowWay />
                    <div class="flex flex-col gap-[5px]">
                        <div class="h-[12px] rounded bg-gray-200"></div>
                        <div class="text-xs opacity-[60%]">Куда</div>
                    </div>
                </div>

                <div class="flex flex-col gap-[5px]">
                    <div class="h-[12px] rounded bg-gray-200"></div>
                    <div class="text-xs opacity-[60%]">Груз</div>
                </div>
                
                <div class="flex flex-col gap-[5px]">
                    <div class="h-[12px] rounded bg-gray-200"></div>
                    <div class="text-xs opacity-[60%]">Сроки</div>
                </div>
            </div>
            <Button class="w-max">Loading...</Button>
        </div>
    </div>
</template>