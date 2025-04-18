<script setup>
import { ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import { notify } from '@kyvg/vue3-notification';
import { deleteVehicle, getVehicles } from '@/api/Vehicle';
import { useAuthStore } from '@/stores/auth';

import Delete from '@/components/Icons/delete.vue';
import Edit from '@/components/Icons/edit.vue';
import Arrow from '@/components/Icons/arrow.vue';
import Modal from '@/components/UI/Modal.vue';
import Search from '@/components/Icons/search.vue';
import router from '@/router';

const response = ref([]);
const loading = ref(false);
const loadingDelete = ref(false);
const showModal = ref(false);
const userId = ref(null);
const findInput = ref('');
const findTimeout = ref(null);

const authStore = useAuthStore();
const route = useRoute();

const deleteModal = (id) => {
    showModal.value = true;
    userId.value = id;
};

const confirmDelete = async () => {
    loadingDelete.value = true;

    try {
        const res = await deleteVehicle(authStore.token, userId.value);

        notify({
            title: 'Удаление',
            text: res.data.message,
            type: 'success'
        });

        fetchVehicles();
    } catch (err) {
        loadingDelete.value = false;
    } finally {
        loadingDelete.value = false;
        showModal.value = false;
    }
};

const linkPrev = () => {
    if (response.value.current_page <= 1) {
        return '/me/vehicles';
    }

    return '/me/vehicles?page=' + (response.value.current_page - 1);
};

const linkTo = () => {
    if (response.value.current_page >= response.value.last_page) {
        return '/me/vehicles?page=' + response.value.current_page;
    }

    return '/me/vehicles?page=' + (response.value.current_page + 1);
};

const getStatusClass = (statusId) => {
    switch (statusId) {
        case 1:
            return 'text-green-600 bg-green-100';
        case 2:
            return 'text-blue-600 bg-blue-100';
        case 3:
            return 'text-yellow-600 bg-yellow-100';
        case 4:
            return 'text-orange-600 bg-orange-100';
        case 5:
            return 'text-purple-600 bg-purple-100';
        case 6:
            return 'text-red-600 bg-red-100';
        default:
            return 'text-gray-600 bg-gray-100';
    }
};

const onInput = () => {
    if (findTimeout.value) {
        clearTimeout(findTimeout.value);
    }

    findTimeout.value = setTimeout(() => {
        router.push({
            query: {
                ...route.query,
                search: findInput.value
            }
        });
    }, 1000);
};

const fetchVehicles = async () => {
    loading.value = true;

    const params = route.query;

    try {
        const res = await getVehicles(authStore.token, params);

        response.value = res.data.data;
        loading.value = false;
    } catch (err) {
        console.log(err);
    } finally {
        loading.value = false;
    }
};

watch(() => route.query, fetchVehicles, { immediate: true });
</script>

<template>
    <Modal size="small" position="middle" :show="showModal">
        <h2 class="text-lg font-bold">Подтвердите действие</h2>
        <p class="mt-2 text-sm">
            Вы уверены, что хотите удалить данный автомобиль?
        </p>

        <div class="mt-4 flex justify-end space-x-2">
            <button
                @click="showModal = false"
                class="text-sm border border-dark-50 py-[5px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer"
            >
                <div class="flex items-center gap-[10px]">
                    <div>Отмена</div>
                </div>
            </button>
            <button
                @click="confirmDelete()"
                class="text-sm bg-red-400 text-white py-[6px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer"
            >
                <div class="flex items-center gap-[10px]">
                    <span>{{ loadingDelete ? 'Удаление...' : 'Удалить' }}</span>
                </div>
            </button>
        </div>
    </Modal>

    <div class="mt-6">
        <div class="text-2xl font-bold">Ваши автомобили</div>
    </div>

    <hr class="border-gray-300 my-[24px]" />

    <div class="mt-6">
        <div class="flex flex-col gap-3 overflow-x-auto">
            <!-- Действия -->
            <div class="flex justify-between items-center">
                <div
                    v-if="loading"
                    class="h-[12px] rounded bg-gray-200 w-32 animate-pulse"
                ></div>
                <div v-else class="text-xs opacity-[60%]">
                    1-{{ response.per_page }} из {{ response.total }} записи
                </div>
                <div class="flex gap-3">
                    <div
                        class="flex items-center px-[9px] gap-2 border border-gray-300 focus:border-gray-700 bg-dark-100 rounded-[6px]"
                    >
                        <Search color="#B0B0B0" />
                        <input
                            v-model="findInput"
                            placeholder="Поиск"
                            class="text-sm focus:outline-0"
                            @input="onInput"
                        />
                    </div>

                    <router-link
                        :to="{ name: 'VehiclesCreate' }"
                        class="text-sm bg-dark-999 text-white py-[8px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer"
                    >
                        Добавить автомобиль
                    </router-link>
                </div>
            </div>

            <!-- Таблица -->
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="text-xs font-normal py-3 text-left px-1">
                            Наименование
                        </th>
                        <th class="text-xs font-normal py-3 text-left px-1">
                            Регистрационный номер
                        </th>
                        <th class="text-xs font-normal py-3 text-left px-1">
                            Свободный объем, м³
                        </th>
                        <th class="text-xs font-normal py-3 text-left px-1">
                            Свободный тоннаж, тонны
                        </th>
                        <th class="text-xs font-normal py-3 text-left px-1">
                            Тип
                        </th>
                        <th class="text-xs font-normal py-3 text-left px-1">
                            Тип кузова
                        </th>
                        <th class="text-xs font-normal py-3 text-left px-1">
                            Статус
                        </th>
                        <th class="text-xs font-normal py-3 text-left px-1">
                            Действия
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="loading">
                        <td class="text-center py-4 text-gray-500">
                            <div
                                class="h-[12px] rounded bg-gray-200 w-12 animate-pulse"
                            ></div>
                        </td>
                        <td class="text-center py-4 text-gray-500">
                            <div
                                class="h-[12px] rounded bg-gray-200 w-12 animate-pulse"
                            ></div>
                        </td>
                        <td class="text-center py-4 text-gray-500">
                            <div
                                class="h-[12px] rounded bg-gray-200 w-12 animate-pulse"
                            ></div>
                        </td>
                        <td class="text-center py-4 text-gray-500">
                            <div
                                class="h-[12px] rounded bg-gray-200 w-12 animate-pulse"
                            ></div>
                        </td>
                        <td class="text-center py-4 text-gray-500">
                            <div
                                class="h-[12px] rounded bg-gray-200 w-12 animate-pulse"
                            ></div>
                        </td>
                        <td class="text-center py-4 text-gray-500">
                            <div
                                class="h-[12px] rounded bg-gray-200 w-12 animate-pulse"
                            ></div>
                        </td>
                        <td class="text-center py-4 text-gray-500">
                            <div
                                class="h-[12px] rounded bg-gray-200 w-12 animate-pulse"
                            ></div>
                        </td>
                        <td class="text-center py-4 text-gray-500">
                            <div
                                class="h-[12px] rounded bg-gray-200 w-12 animate-pulse"
                            ></div>
                        </td>
                    </tr>
                    <tr
                        v-else
                        v-for="vehicle in response.data"
                        :key="vehicle.id"
                    >
                        <td
                            class="text-xs font-normal py-2 border-t-1 border-gray-300 px-1"
                        >
                            {{
                                vehicle.brand +
                                ' ' +
                                vehicle.model +
                                ' ' +
                                vehicle.year +
                                ' года'
                            }}
                        </td>
                        <td
                            class="text-xs font-normal py-2 border-t-1 border-gray-300 px-1"
                        >
                            {{ vehicle.register_number }}
                        </td>
                        <td
                            class="text-xs font-normal py-2 border-t-1 border-gray-300 px-1"
                        >
                            {{ vehicle.max_volume }}
                        </td>
                        <td
                            class="text-xs font-normal py-2 border-t-1 border-gray-300 px-1"
                        >
                            {{ vehicle.max_weight }}
                        </td>
                        <td
                            class="text-xs font-normal py-2 border-t-1 border-gray-300 px-1"
                        >
                            {{ vehicle.category.name }}
                        </td>
                        <td
                            class="text-xs font-normal py-2 border-t-1 border-gray-300 px-1"
                        >
                            {{ vehicle.body_type.name }}
                        </td>
                        <td
                            class="text-xs font-normal py-2 border-t-1 border-gray-300 px-1"
                        >
                            <div
                                class="flex justify-center font-bold p-1 rounded-full text-center"
                                :class="getStatusClass(vehicle.status.id)"
                            >
                                {{ vehicle.status.name }}
                            </div>
                        </td>
                        <td
                            class="text-xs font-normal py-2 border-t-1 border-gray-300 px-1"
                        >
                            <div class="flex gap-2">
                                <router-link
                                    :to="{
                                        name: 'VehiclesUpdate',
                                        params: { id: vehicle.id }
                                    }"
                                    class="hover:cursor-pointer hover:bg-dark-50/70 rounded-[3px] px-1.5 py-1.5"
                                >
                                    <Edit color="black" />
                                </router-link>
                                <div
                                    v-on:click="deleteModal(vehicle.id)"
                                    class="hover:cursor-pointer hover:bg-red-100 rounded-[3px] px-1.5 py-1.5"
                                >
                                    <Delete color="black" />
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Пагинация -->
            <div class="flex justify-end">
                <div
                    v-if="loading"
                    class="h-[24px] rounded bg-gray-200 w-20 animate-pulse"
                ></div>
                <div v-else class="flex items-center gap-3">
                    <router-link
                        :to="linkPrev()"
                        class="hover:cursor-pointer hover:bg-dark-50/70 rounded-[3px] px-1.5 py-1.5"
                    >
                        <Arrow color="black" class="rotate-180" />
                    </router-link>
                    <div>{{ response.current_page }}</div>
                    <router-link
                        :to="linkTo()"
                        class="hover:cursor-pointer hover:bg-dark-50/70 rounded-[3px] px-1.5 py-1.5"
                    >
                        <Arrow color="black" />
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>
