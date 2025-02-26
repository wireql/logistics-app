<script setup>
    import Button from '@/components/UI/Button.vue';
    import TaskCard from '@/components/UI/Profile/TaskCard.vue';
    import TaskCard__Loading from '@/components/UI/Profile/TaskCard__Loading.vue';
</script>

<template>
    <div class="mt-6 flex items-center justify-between">
        <div class="text-2xl font-bold">Ваши задачи</div>

        <Button class="w-max">Создать задачу</Button>
    </div>

    <hr class="border-gray-300 my-[24px]">

    <div class="w-full">
        <div class="bg-dark-50 flex items-center gap-2 justify-between p-[3px] rounded-[6px] w-max">
            <div class="text-xs py-[3px] px-[6px] rounded-[6px] hover:bg-white hover:cursor-pointer">В Ожидании</div>
            <div class="text-xs py-[3px] px-[6px] rounded-[6px] hover:bg-white hover:cursor-pointer">Активные</div>
            <div class="text-xs py-[3px] px-[6px] rounded-[6px] hover:bg-white hover:cursor-pointer">Завершенные</div>
        </div>
    </div>

    <div class="flex flex-col gap-3 mt-6">
        <div class="text-xs opacity-[60%]">1-10 из 74 записей</div>
        <div class="flex flex-col gap-3">
            <TaskCard uuid="eadbfeac-5258-45c2-bab7-ccb9b5ef74f9" datetime="04.02.2025 15:12" address_from="Ростов-на-Дону" address_to="Москва" cargo="Кирпичи" deadline="10.02.2025" />

            <TaskCard__Loading />
        </div>
    </div>
</template>