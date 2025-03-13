<script setup>
    import { notify } from '@kyvg/vue3-notification';
    import { onMounted, ref } from 'vue'; 
    import { useAuthStore } from '@/stores/auth';
    import router from '@/router';
    import { getEmployees } from '@/api/Employee';
    import { getVehicles } from '@/api/Vehicle';
    import { storeTasks } from '@/api/Task';

    import Delete from '@/components/Icons/delete.vue';
    import Edit from '@/components/Icons/edit.vue';
    import InputGroup from '@/components/UI/InputGroup.vue'

    const authStore = useAuthStore()

    const actionLoading = ref(false);
    const loading = ref(false);
    const employees = ref([]);
    const vehicles = ref([]);
    const fields = [
        'plan_delivery', 'vehicle_id', 'user_id'
    ];

    const data = ref(Object.fromEntries(fields.map(field => [field, null])));
    const data__errors = ref(Object.fromEntries(fields.map(field => [field, []])));

    const resetErrors = () => {
        Object.keys(data__errors.value).forEach(key => {
            data__errors.value[key] = [];
        });
    };

    const action = async () => {
        actionLoading.value = true;

        try {
            resetErrors()   
            
            const response = await storeTasks(data.value, authStore.token);

            notify({
                title: "Добавление",
                text: response.data.message,
                type: 'success'
            });
            actionLoading.value = false;

            router.push('/me/tasks');
        } catch (err) {
            if(err.status >= 500) {
                notify({
                    title: "API",
                    text: "Ошибка сервера. Попробуйте позже.",
                    type: 'error'
                });

                return;
            }
            
            const errors = err.response?.data?.errors || {};
            Object.keys(errors).forEach(key => {
                if (data__errors.value[key] !== undefined) {
                    data__errors.value[key] = errors[key];
                }
            });
        } finally {
            actionLoading.value = false;
        }
    }

    onMounted(async () => {
        loading.value = true;

        try {
            const [employeeRes, vehiclesRes] = await Promise.all([
                getEmployees(authStore.token, {'category': 4}),
                getVehicles(authStore.token, {'status': 1})
            ])

            employees.value = employeeRes.data.data;
            vehicles.value = vehiclesRes.data.data;
        } catch (err) {
            notify({
                title: "Ошибка",
                text: "Не удалось загрузить данные. Попробуйте позже.",
                type: 'error'
            });
        } finally {
            loading.value = false;
        }

    })   

</script>

<template>
    <div class="mt-6 flex items-center justify-between">
        <div>
            <div class="text-2xl font-bold">Задача</div>
            <div class="text-xs">Создание новой задачи</div>
        </div>
        <div class="flex items-center gap-[10px]">
            <router-link :to="{'name': 'TasksIndex'}" class="text-sm border border-dark-50 py-[5px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
                <div class="flex items-center gap-[10px]">
                    <Delete color="black"/>
                    <div>Отмена</div>
                </div>
            </router-link>
            <button type="button" v-on:click="action()" class="text-sm bg-sky-400 text-white py-[6px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
                <div class="flex items-center gap-[10px]">
                    <Edit color="#FFF"/>
                    <div>{{ actionLoading ? 'Сохранение...' : 'Сохранить' }}</div>
                </div>
            </button>
        </div>
     </div>

    <hr class="border-gray-300 my-[24px]">

    <div class="mt-6">
        <div class="grid grid-cols-12 gap-5 pb-10">
            <div class="col-span-4">
                <div class="text-base">Основная информация</div>
                <hr class="border-gray-300 my-3">
                <div class="flex flex-col gap-6">
                    <InputGroup v-model="data.plan_delivery" :error="data__errors.plan_delivery[0]" label="Плановая доставка" type="date" placeholder=""/>

                    <div class="flex flex-col gap-[5px] w-full">
                        <label class="text-sm opacity-[60%]">Описание</label>
                        <textarea class="text-sm w-full border border-gray-300 focus:border-gray-700 bg-dark-100 py-[6px] px-[9px] rounded-[6px]"></textarea>
                    </div>

                    <div class="flex flex-col gap-[5px] w-full">
                        <label class="text-sm opacity-[60%]">Водитель</label>
                        <select v-model="data.user_id" class="text-sm w-full border border-gray-300 focus:border-gray-700 bg-dark-100 py-[6px] px-[9px] rounded-[6px]">
                            <option
                                v-for="employee in employees.data"
                                :key="employee.id"
                                :value="employee.id"
                            >
                            {{ employee.category.name + " - " + employee.first_name }}
                            </option>
                        </select>
                        <p v-if="data__errors.user_id !== null" class="text-red-300 text-xs">{{ data__errors.user_id[0] }}</p>
                    </div>

                    <div class="flex flex-col gap-[5px] w-full">
                        <label class="text-sm opacity-[60%]">Автомобиль</label>
                        <select v-model="data.vehicle_id" class="text-sm w-full border border-gray-300 focus:border-gray-700 bg-dark-100 py-[6px] px-[9px] rounded-[6px]">
                            <option
                                v-for="vehicle in vehicles.data"
                                :key="vehicle.id"
                                :value="vehicle.id"
                            >
                            {{ vehicle.brand + " " + vehicle.model + " - " + vehicle.status.name }}
                            </option>
                        </select>
                        <p v-if="data__errors.user_id !== null" class="text-red-300 text-xs">{{ data__errors.user_id[0] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>