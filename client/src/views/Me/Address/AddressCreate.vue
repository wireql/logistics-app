<script setup>
    import { notify } from '@kyvg/vue3-notification';
    import { onMounted, ref } from 'vue'; 
    import { useAuthStore } from '@/stores/auth';
    import router from '@/router';

    import Delete from '@/components/Icons/delete.vue';
    import Edit from '@/components/Icons/edit.vue';
    import InputGroup from '@/components/UI/InputGroup.vue'
    import { getAddressCategories, storeAddress } from '@/api/Address';

    const authStore = useAuthStore()

    const actionLoading = ref(false);
    const loading = ref(false);
    const addressCategories = ref(null);
    const fields = [
        'name', 'address_category_id'
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
            
            const response = await storeAddress(data.value, authStore.token);

            notify({
                title: "Добавление",
                text: response.data.message,
                type: 'success'
            });
            actionLoading.value = false;

            router.push('/me/address');
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
            const categoriesRes = await getAddressCategories(authStore.token);

            addressCategories.value = categoriesRes.data.data;
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
            <div class="text-2xl font-bold">Адрес</div>
            <div class="text-xs">Добавление нового адреса</div>
        </div>
        <div class="flex items-center gap-[10px]">
            <router-link :to="{'name': 'AddressIndex'}" class="text-sm border border-dark-50 py-[5px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
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
                    <InputGroup v-model="data.name" :error="data__errors.name[0]" label="Адрес" placeholder="Ростов-на-Дону, ул. Крутая, д. 35"/>
                    <div class="flex flex-col gap-[5px] w-full">
                        <label class="text-sm opacity-[60%]">Категория</label>
                        <select v-model="data.address_category_id" class="text-sm w-full border border-gray-300 focus:border-gray-700 bg-dark-100 py-[6px] px-[9px] rounded-[6px]">
                            <option
                                v-for="category in addressCategories"
                                :key="category.id"
                                :value="category.id"
                            >
                            {{ category.name }}
                            </option>
                        </select>
                        <p v-if="data__errors.address_category_id !== null" class="text-red-300 text-xs">{{ data__errors.address_category_id[0] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>