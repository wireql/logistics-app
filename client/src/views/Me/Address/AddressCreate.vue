<script setup>
import { notify } from '@kyvg/vue3-notification';
import { onMounted, ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
import router from '@/router';

import Delete from '@/components/Icons/delete.vue';
import Edit from '@/components/Icons/edit.vue';
import InputGroup from '@/components/UI/InputGroup.vue';
import { getAddressCategories, storeAddress } from '@/api/Address';
import MapComponent from '@/components/UI/OpenLayers/MapComponent.vue';

const authStore = useAuthStore();

const actionLoading = ref(false);
const loading = ref(false);
const addressCategories = ref(null);
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

        const response = await storeAddress(data.value, authStore.token);

        notify({
            title: 'Добавление',
            text: response.data.message,
            type: 'success'
        });
        actionLoading.value = false;

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

const handleAddressData = (dataRes) => {
    data.value.country = dataRes.address.country;
    data.value.region = dataRes.address.state;
    data.value.city = dataRes.address.city;
    data.value.street = dataRes.address.road;
    data.value.building = dataRes.address.house_number;

    data.value.latitude = dataRes.lat;
    data.value.longitude = dataRes.lon;
};

onMounted(async () => {
    loading.value = true;

    try {
        const categoriesRes = await getAddressCategories(authStore.token);

        addressCategories.value = categoriesRes.data.data;
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
            <div class="text-xs">Добавление нового адреса</div>
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

    <MapComponent @address-data="handleAddressData" />

    <hr class="border-gray-300 my-[24px]" />

    <div class="mt-6 pb-6">
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
                        require
                    />
                    <InputGroup
                        v-model="data.region"
                        :error="data__errors.region[0]"
                        label="Регион"
                        placeholder="Ростовская область"
                        require
                    />
                    <InputGroup
                        v-model="data.city"
                        :error="data__errors.city[0]"
                        label="Город, населенный пункт"
                        placeholder="Ростов-на-Дону"
                        require
                    />
                    <InputGroup
                        v-model="data.street"
                        :error="data__errors.street[0]"
                        label="Улица"
                        placeholder="Малиновского"
                        require
                    />
                    <InputGroup
                        v-model="data.building"
                        :error="data__errors.building[0]"
                        label="Дом, строение"
                        placeholder="125"
                        require
                    />
                    <InputGroup
                        v-model="data.flat"
                        :error="data__errors.flat[0]"
                        label="Квартира"
                        placeholder="125"
                    />
                    <div class="flex flex-col gap-[5px] w-full">
                        <label class="text-sm opacity-[60%]"
                            >Категория
                            <span class="text-red-400 text-base">*</span></label
                        >
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
                        require
                    />
                    <InputGroup
                        v-model="data.longitude"
                        :error="data__errors.longitude[0]"
                        label="Долгота"
                        placeholder="39.614897"
                        require
                    />
                </div>
            </div>
        </div>
    </div>
</template>
