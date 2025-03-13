<script setup>
    import { getTasks } from '@/api/Task';
    import TaskCard from '@/components/UI/Profile/TaskCard.vue';
    import TaskCard__Loading from '@/components/UI/Profile/TaskCard__Loading.vue';
    import { useAuthStore } from '@/stores/auth';
    import { ref, watch } from 'vue';
    import { useRoute } from 'vue-router';

    const response = ref([])
    const loading = ref(false)

    const authStore = useAuthStore();
    const route = useRoute();

    const fetchTasks = async () => {
        loading.value = true;

        const params = route.query

        try {
            const res = await getTasks(authStore.token, params);

            response.value = res.data.data
            loading.value = false
        } catch (err) {
            console.log(err);
        } finally {
            loading.value = false
        }
    };

    watch(() => route.query.page, fetchTasks, { immediate: true });
</script>

<template>
    <div class="mt-6 flex items-center justify-between">
        <div class="text-2xl font-bold">Ваши маршрутные листы</div>

        <router-link :to="{'name': 'RouteListsCreate'}" class="text-sm bg-dark-999 text-white py-[8px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
            Создать задачу
        </router-link>
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
            <TaskCard__Loading v-if="loading" />
            <TaskCard 
                v-else 
                v-for="task in response.data" 
                :key="task.id" 
                :uuid="task.id" 
                :datetime="task.created_at"
                cargo="Кирпичи" 
                :deadline="task.plan_delivery"
            />
        </div>
    </div>
</template>