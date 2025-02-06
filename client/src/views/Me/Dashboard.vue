<script setup>
import ArrowUp from '@/components/Icons/arrow-up.vue';
import TotalTasks from '@/components/Icons/total-tasks.vue';
import Total_mill from '@/components/Icons/total_mill.vue';
import DashboardTotalCard__Loading from '@/components/UI/Profile/DashboardTotalCard__Loading.vue';
import TaskCard from '@/components/UI/Profile/TaskCard.vue';
import TaskCard__Loading from '@/components/UI/Profile/TaskCard__Loading.vue';
</script>

<template>
    <div class="flex flex-col gap-[5px] mt-6">
        <div class="text-2xl font-bold">Добро пожаловать, Дмитрий!</div>
        <div class="text-sm">Здесь можно посмотреть общую статистику и информацию</div>
    </div>

    <hr class="border-gray-300 my-[24px]">

    <div class="bg-dark-50 flex items-center max-w-[238px] justify-between p-[3px] rounded-[6px]">
        <div class="text-xs py-[3px] px-[6px] rounded-[6px] hover:bg-white hover:cursor-pointer">Год</div>
        <div class="text-xs py-[3px] px-[6px] rounded-[6px] hover:bg-white hover:cursor-pointer">Месяц</div>
        <div class="text-xs py-[3px] px-[6px] rounded-[6px] hover:bg-white hover:cursor-pointer">Квартал</div>
        <div class="text-xs py-[3px] px-[6px] rounded-[6px] hover:bg-white hover:cursor-pointer">Неделя</div>
    </div>

    <div class="flex gap-6 mt-6">
        <div class="flex flex-col h-[120px] justify-between p-[15px] border border-gray-300 rounded-[12px] max-w-[238px] w-full">
            <div class="flex flex-col gap-[5px]">
                <Total_mill />
                <div class="text-xs opacity-[60%]">Проехали</div>
            </div>
            <div class="flex justify-between items-center">
                <div class="text-base font-bold">5 142 км</div>
                <div class="flex items-center py-[3px] px-[6px] border-1 rounded-full w-max">
                    <ArrowUp />
                    <div class="text-xs">12%</div>
                </div>
            </div>
        </div>

        <div class="flex flex-col h-[120px] justify-between p-[15px] border border-gray-300 rounded-[12px] max-w-[238px] w-full">
            <div class="flex flex-col gap-[5px]">
                <TotalTasks />
                <div class="text-xs opacity-[60%]">Задач выполнено</div>
            </div>
            <div class="flex justify-between items-center">
                <div class="text-base font-bold">5 142 км</div>
                <div class="flex items-center py-[3px] px-[6px] border-1 rounded-full w-max">
                    <ArrowUp />
                    <div class="text-xs">12%</div>
                </div>
            </div>
        </div>

        <DashboardTotalCard__Loading />
    </div>

    <div class="mt-6 text-2xl">Активные задачи</div>

    <hr class="border-gray-300 my-[24px]">

    <div class="flex flex-col gap-3">

        <TaskCard uuid="eadbfeac-5258-45c2-bab7-ccb9b5ef74f9" datetime="04.02.2025 15:12" address_from="Ростов-на-Дону" address_to="Москва" cargo="Кирпичи" deadline="10.02.2025" />

        <TaskCard__Loading />

    </div>
</template>