<script setup>
import { getAddresses } from '@/api/Address';
import { storeRoutePoint } from '@/api/RoutePoint';
import Delete from '@/components/Icons/delete.vue';
import Edit from '@/components/Icons/edit.vue';
import InputGroup from '@/components/UI/InputGroup.vue';
import { useAuthStore } from '@/stores/auth';
import { notify } from '@kyvg/vue3-notification';
import { computed, onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import router from '@/router';
import VueSelect from 'vue3-select-component';
import Button from '@/components/UI/Button.vue';

const fields = ['address_from_id', 'address_to_id', 'delivery_date'];
const data = ref(Object.fromEntries(fields.map((field) => [field, null])));
const data__errors = ref(
    Object.fromEntries(fields.map((field) => [field, []]))
);
const addresses = ref([]);
const loading = ref(false);
const actionLoading = ref(false);
const authStore = useAuthStore();
const route = useRoute();

const resetErrors = () => {
    Object.keys(data__errors.value).forEach((key) => {
        data__errors.value[key] = [];
    });
};

const action = async () => {
    actionLoading.value = true;

    try {
        resetErrors();

        const response = await storeRoutePoint(
            data.value,
            authStore.token,
            route.params.id
        );

        notify({
            title: 'Добавление',
            text: response.data.message,
            type: 'success'
        });
        actionLoading.value = false;

        router.push('/me/route-lists/' + route.params.id);
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
        const addressesRes = await getAddresses(authStore.token);

        addresses.value = addressesRes.data.data;
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
            <div class="text-2xl font-bold">Подзадача</div>
            <div class="text-xs">Добавление новой подзадачи</div>
        </div>
        <div class="flex items-center gap-[10px] mt-2">
            <router-link
                :to="{
                    name: 'RouteListsUpdate',
                    params: { id: route.params.id }
                }"
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
                    <div class="flex flex-col gap-[5px] w-full">
                        <label class="text-sm opacity-[60%]"
                            >Адрес погрузки</label
                        >
                        <VueSelect
                            v-model="data.address_from_id"
                            :options="
                                addresses?.data?.map((address) => ({
                                    label: `${address.region} г.${address.city} ул.${address.street} д.${address.building} кв.${address.flat}`,
                                    value: address.id
                                })) || []
                            "
                            placeholder="Выбрать адрес"
                            class="text-sm rounded-[6px]"
                        >
                            <template #menu-header>
                                <div class="p-2">
                                    <router-link
                                        :to="{ name: 'AddressCreate' }"
                                    >
                                        <Button>Добавить адрес</Button>
                                    </router-link>
                                </div>
                            </template>
                        </VueSelect>
                        <p
                            v-if="data__errors.address_from_id !== null"
                            class="text-red-300 text-xs"
                        >
                            {{ data__errors.address_from_id[0] }}
                        </p>
                    </div>
                    <div class="flex flex-col gap-[5px] w-full">
                        <label class="text-sm opacity-[60%]"
                            >Адрес доставки</label
                        >
                        <VueSelect
                            v-model="data.address_to_id"
                            :options="
                                addresses?.data?.map((address) => ({
                                    label: `${address.region} г.${address.city} ул.${address.street} д.${address.building} кв.${address.flat}`,
                                    value: address.id
                                })) || []
                            "
                            placeholder="Выбрать адрес"
                            class="text-sm rounded-[6px]"
                        >
                            <template #menu-header>
                                <div class="p-2">
                                    <router-link
                                        :to="{ name: 'AddressCreate' }"
                                    >
                                        <Button>Добавить адрес</Button>
                                    </router-link>
                                </div>
                            </template>
                        </VueSelect>
                        <p
                            v-if="data__errors.address_to_id !== null"
                            class="text-red-300 text-xs"
                        >
                            {{ data__errors.address_to_id[0] }}
                        </p>
                    </div>
                    <InputGroup
                        v-model="data.delivery_date"
                        :error="data__errors.delivery_date[0]"
                        label="Плановая дата завершения"
                        type="datetime-local"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
