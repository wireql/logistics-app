<script setup>
import { useAuthStore } from '@/stores/auth';
import TotalCardsGroup from '@/components/UI/App/Dashboard/TotalCardsGroup.vue';
import TaskCard from '@/components/UI/App/Dashboard/TaskCard.vue';
import TaskCardLoading from '@/components/UI/App/Dashboard/TaskCardLoading.vue';

const authStore = useAuthStore();
</script>

<template>
    <div class="flex flex-col gap-[5px] mt-6">
        <div class="text-2xl font-bold">
            Добро пожаловать, {{ authStore.user.first_name }}!
        </div>
        <div class="text-sm">
            Здесь можно посмотреть общую статистику и информацию
        </div>
    </div>

    <hr class="border-gray-300 my-[24px]" />

    <TotalCardsGroup />

    <div class="mt-6 text-2xl">Активные задачи</div>

    <hr class="border-gray-300 my-[24px]" />

    <div class="flex flex-col gap-3">
        <TaskCard
            uuid="eadbfeac-5258-45c2-bab7-ccb9b5ef74f9"
            datetime="04.02.2025 15:12"
            address_from="Ростов-на-Дону"
            address_to="Москва"
            cargo="Кирпичи"
            deadline="10.02.2025"
        />

        <TaskCardLoading />
    </div>
</template>
