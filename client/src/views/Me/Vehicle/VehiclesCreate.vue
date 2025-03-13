<script setup>
    import { notify } from '@kyvg/vue3-notification';
    import { onMounted, ref } from 'vue'; 
    import { useAuthStore } from '@/stores/auth';
    import router from '@/router';
    import { getBodyTypes, getVehicleCategories, storeVehicle } from '@/api/Vehicle';
    import Inputmask from 'inputmask';

    import Delete from '@/components/Icons/delete.vue';
    import Edit from '@/components/Icons/edit.vue';
    import InputGroup from '@/components/UI/InputGroup.vue'

    const authStore = useAuthStore()

    const actionLoading = ref(false);
    const loading = ref(false);
    const vehicleCategories = ref([])
    const bodyTypes = ref([])
    const yearInput = ref(null);
    const vinInput = ref(null);
    const fields = [
        'brand', 'model', 'year', 'vin_number', 'register_number',
        'max_volume', 'max_weight', 'vehicle_category_id', 'body_type_id'
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
            
            const response = await storeVehicle(data.value, authStore.token);

            notify({
                title: "Добавление",
                text: response.data.message,
                type: 'success'
            });
            actionLoading.value = false;

            router.push('/me/vehicles');
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

    const initYearMask = () => {
        let a = yearInput.value.$el.querySelector('input');
        
        Inputmask({
            mask: '9999',
            clearIncomplete: true,
        }).mask(a);
    }

    const initVINMask = () => {
        let a = vinInput.value.$el.querySelector('input');

        Inputmask({
            mask: "A{17}",
            greedy: false,
            clearIncomplete: true,
            definitions: {
                "A": {
                    validator: "[A-HJ-NPR-Z0-9]",
                    casing: "upper"
                }
            }
        }).mask(a);
    }

    onMounted(async () => {
        loading.value = true;

        try {
            const [categoriesRes, bodyTypesRes] = await Promise.all([
                getVehicleCategories(authStore.token),
                getBodyTypes(authStore.token),
            ])

            vehicleCategories.value = categoriesRes.data.data;
            bodyTypes.value = bodyTypesRes.data.data;
        } catch (err) {
            notify({
                title: "Ошибка",
                text: "Не удалось загрузить данные. Попробуйте позже.",
                type: 'error'
            });
        } finally {
            loading.value = false;
        }

        initYearMask()
        initVINMask()
    })   

</script>

<template>
    <div class="mt-6 flex flex-col sm:flex-row sm:items-center justify-between">
        <div>
            <div class="text-2xl font-bold">Автомобиль</div>
            <div class="text-xs">Добавление нового автомобиля</div>
        </div>
        <div class="flex items-center gap-[10px] mt-2">
            <router-link :to="{'name': 'VehiclesIndex'}" class="text-sm border border-dark-50 py-[5px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
                <div class="flex items-center gap-[10px]">
                    <Delete color="black"/>
                    <div class="">Отмена</div>
                </div>
            </router-link>
            <button type="button" v-on:click="action()" class="text-sm bg-[#C1E0FF] text-white py-[6px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
                <div class="flex items-center gap-[10px]">
                    <Edit color="#357CC5"/>
                    <div class="text-[#357CC5]">Сохранить</div>
                </div>
            </button>
        </div>
    </div>

    <hr class="border-gray-300 my-[24px]">

    <div class="mt-6 pb-6">
        <div class="grid grid-cols-12 gap-5">
            <div class="col-span-12 sm:col-span-4 xl:col-span-3">
                <div class="text-sm font-bold">Основная информация</div>
            </div>
            <div class="col-span-12 sm:col-span-8 xl:col-span-4">
                <div class="flex flex-col gap-6">
                    <InputGroup v-model="data.brand" :error="data__errors.brand[0]" label="Бренд" placeholder="MAN"/>
                    <InputGroup v-model="data.model" :error="data__errors.model[0]" label="Модель" placeholder="TGX"/>
                    <InputGroup ref="yearInput" v-model="data.year" :error="data__errors.year[0]" label="Год выпуска" placeholder="2024"/>
                    <div class="flex flex-col gap-[5px] w-full">
                        <label class="text-sm opacity-[60%]">Тип автомобиля</label>
                        <select v-model="data.vehicle_category_id" class="text-sm w-full border border-gray-300 focus:border-gray-700 bg-dark-100 py-[6px] px-[9px] rounded-[6px]">
                            <option
                                v-for="category in vehicleCategories"
                                :key="category.id"
                                :value="category.id"
                            >
                            {{ category.name }}
                            </option>
                        </select>
                        <p v-if="data__errors.vehicle_category_id !== null" class="text-red-300 text-xs">{{ data__errors.vehicle_category_id[0] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="border-gray-300 my-[24px]">

        <div class="grid grid-cols-12 gap-5">
            <div class="col-span-12 sm:col-span-4 xl:col-span-3">
                <div class="text-sm font-bold">Документация</div>
            </div>
            <div class="col-span-12 sm:col-span-8 xl:col-span-4">
                <div class="flex flex-col gap-6">
                    <InputGroup 
                        v-model="data.register_number" 
                        :error="data__errors.register_number[0]" 
                        label="Регистрационный номер" 
                        placeholder="О132ВХ180" 
                    />
                    <InputGroup 
                        v-model="data.vin_number" 
                        :error="data__errors.vin_number[0]" 
                        label="VIN" 
                        ref="vinInput"
                        placeholder="JHMCM56557C404453"/>
                </div>
            </div>
        </div>

        <hr class="border-gray-300 my-[24px]">

        <div class="grid grid-cols-12 gap-5">
            <div class="col-span-12 sm:col-span-4 xl:col-span-3">
                <div class="text-sm font-bold">Кузов</div>
            </div>
            <div class="col-span-12 sm:col-span-8 xl:col-span-4">
                <div class="flex flex-col gap-6">
                    <div class="flex flex-col gap-[5px] w-full">
                        <label class="text-sm opacity-[60%]">Тип кузова</label>
                        <select v-model="data.body_type_id" class="text-sm w-full border border-gray-300 focus:border-gray-700 bg-dark-100 py-[6px] px-[9px] rounded-[6px]">
                            <option
                                v-for="category in bodyTypes"
                                :key="category.id"
                                :value="category.id"
                            >
                            {{ category.name }}
                            </option>
                        </select>
                        <p v-if="data__errors.body_type_id !== null" class="text-red-300 text-xs">{{ data__errors.body_type_id[0] }}</p>
                    </div>
                    <InputGroup 
                        v-model="data.max_volume" 
                        :error="data__errors.max_volume[0]" 
                        label="	Свободный объем, м³" 
                        placeholder="23"
                        type="number"
                        min="0"
                        />
                    <InputGroup 
                        v-model="data.max_weight" 
                        :error="data__errors.max_weight[0]" 
                        label="Свободный тоннаж, тонны" 
                        placeholder="52"
                        type="number"
                        min="0"
                        />
                </div>
            </div>
        </div>
    </div>
</template>