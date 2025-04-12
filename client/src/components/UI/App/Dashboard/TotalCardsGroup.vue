<script setup>
import { ref } from 'vue';

import TotalCard from './TotalCard.vue';
import Total_mill from '@/components/Icons/total_mill.vue';
import TotalTasks from '@/components/Icons/total-tasks.vue';
import TotalCardLoading from './TotalCardLoading.vue';

const statsPeriod = ref([
    { id: 1, name: 'Год' },
    { id: 2, name: 'Месяц' },
    { id: 3, name: 'Квартал' },
    { id: 4, name: 'Неделя' }
]);
</script>
<template>
    <div class="grid grid-cols-12 gap-5">
        <div
            class="bg-dark-50 flex items-center justify-between p-[3px] rounded-[6px] col-span-12 sm:col-span-6 md:col-span-4"
        >
            <div
                class="text-xs py-[3px] px-[6px] rounded-[6px] hover:bg-white hover:cursor-pointer"
                v-for="item in statsPeriod"
                :id="item.id"
            >
                {{ item.name }}
            </div>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-12 gap-5">
        <TotalCard data="5 142 км" title="Проехали">
            <Total_mill />
        </TotalCard>
        <TotalCard data="5 142 км" title="Задач выполнено">
            <TotalTasks />
        </TotalCard>

        <TotalCardLoading />
    </div>
</template>
