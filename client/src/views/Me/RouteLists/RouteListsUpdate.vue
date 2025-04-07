<script setup>
import { notify } from '@kyvg/vue3-notification';
import { onMounted, ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
import router from '@/router';
import { useRoute } from 'vue-router';

import Delete from '@/components/Icons/delete.vue';
import Edit from '@/components/Icons/edit.vue';
import InputGroup from '@/components/UI/InputGroup.vue';
import { getEmployees } from '@/api/Employee';
import { getVehicles } from '@/api/Vehicle';
import { getRouteList, updateRouteList } from '@/api/RouteList';

const authStore = useAuthStore();
const route = useRoute();
const routeListId = route.params.id;
const loading = ref(false);
const actionLoading = ref(false);
const employees = ref([]);
const vehicles = ref([]);
const fields = ['delivery_date', 'vehicle_id', 'user_id', 'description'];

const data = ref(Object.fromEntries(fields.map((field) => [field, null])));
const data__errors = ref(
    Object.fromEntries(fields.map((field) => [field, []]))
);

const resetErrors = () => {
    Object.keys(data__errors.value).forEach((key) => {
        data__errors.value[key] = [];
    });
};

const action = async () => {
    actionLoading.value = true;

    try {
        resetErrors();

        const response = await updateRouteList(
            data.value,
            routeListId,
            authStore.token
        );

        notify({
            title: 'Обновление',
            text: response.data.message,
            type: 'success'
        });

        router.push('/me/route-lists');
    } catch (err) {
        if (err.status >= 500) {
            notify({
                title: 'API',
                text: 'Ошибка сервера. Попробуйте позже.',
                type: 'error'
            });

            return;
        }

        const errors = err.response?.data?.errors || {};
        Object.keys(errors).forEach((key) => {
            if (data__errors.value[key] !== undefined) {
                data__errors.value[key] = errors[key];
            }
        });
    } finally {
        actionLoading.value = false;
    }
};

onMounted(async () => {
    loading.value = true;

    try {
        const [employeeRes, vehiclesRes, routeListRes] = await Promise.all([
            getEmployees(authStore.token, { category: 4 }),
            getVehicles(authStore.token, { status: 1 }),
            getRouteList(authStore.token, routeListId)
        ]);

        employees.value = employeeRes.data.data;
        vehicles.value = vehiclesRes.data.data;
        data.value = routeListRes.data.data;
    } catch (err) {
        notify({
            title: 'Ошибка',
            text: 'Не удалось загрузить данные. Попробуйте позже.',
            type: 'error'
        });
    } finally {
        loading.value = false;
    }
});
</script>

<template>
    <div class="mt-6 flex flex-col sm:flex-row sm:items-center justify-between">
        <div>
            <div class="text-2xl font-bold">Маршрутный лист</div>
            <div class="text-xs">Обновление информации об маршрутном листе</div>
        </div>
        <div class="flex items-center gap-[10px] mt-2">
            <router-link
                :to="{ name: 'RouteListsIndex' }"
                class="text-sm border border-dark-50 py-[5px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer"
            >
                <div class="flex items-center gap-[10px]">
                    <Delete color="black" />
                    <div class="">Отмена</div>
                </div>
            </router-link>
            <button
                type="button"
                v-on:click="action()"
                class="text-sm bg-[#C1E0FF] text-white py-[6px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer"
            >
                <div class="flex items-center gap-[10px]">
                    <Edit color="#357CC5" />
                    <div class="text-[#357CC5]">Сохранить</div>
                </div>
            </button>
        </div>
    </div>

    <hr class="border-gray-300 my-[24px]" />

    <div class="mt-6 pb-6">
        <div class="grid grid-cols-12 gap-5">
            <div class="col-span-12 sm:col-span-4 xl:col-span-3">
                <div class="text-sm font-bold">Основная информация</div>
            </div>
            <div class="col-span-12 sm:col-span-8 xl:col-span-4">
                <div class="flex flex-col gap-6">
                    <InputGroup
                        v-model="data.delivery_date"
                        :error="data__errors.delivery_date[0]"
                        label="Плановая дата завершения"
                        type="date"
                    />
                    <div class="flex flex-col gap-[5px] w-full">
                        <label class="text-sm opacity-[60%]">Описание</label>
                        <textarea
                            v-model="data.description"
                            class="text-sm w-full border border-gray-300 focus:border-gray-700 bg-dark-100 py-[6px] px-[9px] rounded-[6px]"
                        ></textarea>
                    </div>
                    <div class="flex flex-col gap-[5px] w-full">
                        <label class="text-sm opacity-[60%]">Водитель</label>
                        <select
                            v-model="data.user_id"
                            class="text-sm w-full border border-gray-300 focus:border-gray-700 bg-dark-100 py-[6px] px-[9px] rounded-[6px]"
                        >
                            <option
                                v-for="employee in employees.data"
                                :key="employee.id"
                                :value="employee.id"
                            >
                                {{
                                    employee.category.name +
                                    ' - ' +
                                    employee.first_name
                                }}
                            </option>
                        </select>
                        <p
                            v-if="data__errors.user_id !== null"
                            class="text-red-300 text-xs"
                        >
                            {{ data__errors.user_id[0] }}
                        </p>
                    </div>

                    <div class="flex flex-col gap-[5px] w-full">
                        <label class="text-sm opacity-[60%]">Автомобиль</label>
                        <select
                            v-model="data.vehicle_id"
                            class="text-sm w-full border border-gray-300 focus:border-gray-700 bg-dark-100 py-[6px] px-[9px] rounded-[6px]"
                        >
                            <option
                                v-for="vehicle in vehicles.data"
                                :key="vehicle.id"
                                :value="vehicle.id"
                            >
                                {{
                                    vehicle.brand +
                                    ' ' +
                                    vehicle.model +
                                    ' - ' +
                                    vehicle.status.name
                                }}
                            </option>
                        </select>
                        <p
                            v-if="data__errors.user_id !== null"
                            class="text-red-300 text-xs"
                        >
                            {{ data__errors.user_id[0] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
