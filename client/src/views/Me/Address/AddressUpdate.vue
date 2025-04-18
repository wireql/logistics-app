<script setup>
import { notify } from '@kyvg/vue3-notification';
import { onMounted, ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
import router from '@/router';
import { getAddress, getAddressCategories, updateAddress } from '@/api/Address';
import { useRoute } from 'vue-router';

import Delete from '@/components/Icons/delete.vue';
import Edit from '@/components/Icons/edit.vue';
import InputGroup from '@/components/UI/InputGroup.vue';
import BlockLoadingSpinner from '@/components/UI/App/BlockLoadingSpinner.vue';

const authStore = useAuthStore();
const route = useRoute();
const addressId = route.params.id;
const loading = ref(false);
const addressCategories = ref(null);
const actionLoading = ref(false);
const fields = [
    'country',
    'region',
    'city',
    'street',
    'building',
    'flat',
    'latitude',
    'longitude',
    'address_category_id'
];

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

        const response = await updateAddress(
            data.value,
            addressId,
            authStore.token
        );

        notify({
            title: 'Обновление',
            text: response.data.message,
            type: 'success'
        });

        router.push('/me/address');
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
        const [categoriesRes, address] = await Promise.all([
            getAddressCategories(authStore.token),
            getAddress(authStore.token, addressId)
        ]);

        addressCategories.value = categoriesRes.data.data;
        data.value = address.data.data;
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
            <div class="text-2xl font-bold">Адрес</div>
            <div class="text-xs">Обновление информации об адресе</div>
        </div>
        <div class="flex items-center gap-[10px] mt-2">
            <router-link
                :to="{ name: 'AddressIndex' }"
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

    <BlockLoadingSpinner v-if="loading" />
    <div v-else class="mt-6 pb-6">
        <div class="grid grid-cols-12 gap-5">
            <div class="col-span-12 sm:col-span-4 xl:col-span-3">
                <div class="text-sm font-bold">Основная информация</div>
            </div>
            <div class="col-span-12 sm:col-span-8 xl:col-span-4">
                <div class="flex flex-col gap-6">
                    <InputGroup
                        v-model="data.country"
                        :error="data__errors.country[0]"
                        label="Страна"
                        placeholder="Россия"
                    />
                    <InputGroup
                        v-model="data.region"
                        :error="data__errors.region[0]"
                        label="Регион"
                        placeholder="Ростовская область"
                    />
                    <InputGroup
                        v-model="data.city"
                        :error="data__errors.city[0]"
                        label="Город, населенный пункт"
                        placeholder="Ростов-на-Дону"
                    />
                    <InputGroup
                        v-model="data.street"
                        :error="data__errors.street[0]"
                        label="Улица"
                        placeholder="Малиновского"
                    />
                    <InputGroup
                        v-model="data.building"
                        :error="data__errors.building[0]"
                        label="Дом, строение"
                        placeholder="125"
                    />
                    <InputGroup
                        v-model="data.flat"
                        :error="data__errors.flat[0]"
                        label="Квартира"
                        placeholder="125"
                    />
                    <div class="flex flex-col gap-[5px] w-full">
                        <label class="text-sm opacity-[60%]">Категория</label>
                        <select
                            v-model="data.address_category_id"
                            class="text-sm w-full border border-gray-300 focus:border-gray-700 bg-dark-100 py-[6px] px-[9px] rounded-[6px]"
                        >
                            <option
                                v-for="category in addressCategories"
                                :key="category.id"
                                :value="category.id"
                            >
                                {{ category.name }}
                            </option>
                        </select>
                        <p
                            v-if="data__errors.address_category_id !== null"
                            class="text-red-300 text-xs"
                        >
                            {{ data__errors.address_category_id[0] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="border-gray-300 my-[24px]" />

        <div class="grid grid-cols-12 gap-5">
            <div class="col-span-12 sm:col-span-4 xl:col-span-3">
                <div class="text-sm font-bold">Координаты</div>
            </div>
            <div class="col-span-12 sm:col-span-8 xl:col-span-4">
                <div class="flex flex-col gap-6">
                    <InputGroup
                        v-model="data.latitude"
                        :error="data__errors.latitude[0]"
                        label="Широта"
                        placeholder="47.238704"
                    />
                    <InputGroup
                        v-model="data.longitude"
                        :error="data__errors.longitude[0]"
                        label="Долгота"
                        placeholder="39.614897"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
