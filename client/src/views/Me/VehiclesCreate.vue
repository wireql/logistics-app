<script setup>
    import { notify } from '@kyvg/vue3-notification';
    import { onMounted, ref } from 'vue'; 
    import { useAuthStore } from '@/stores/auth';
    import router from '@/router';
    import { getBodyTypes, getVehicleCategories, storeVehicle } from '@/api/Vehicle';

    import Delete from '@/components/Icons/delete.vue';
    import Edit from '@/components/Icons/edit.vue';
    import Copy from '@/components/Icons/copy.vue';
    import InputGroup from '@/components/UI/InputGroup.vue'
    import Gear from '@/components/Icons/gear.vue';
    import CopyActive from '@/components/Icons/copy-active.vue';

    const authStore = useAuthStore()

    const actionLoading = ref(false);
    const copy = ref(false);
    const vehicleCategories = ref([])
    const bodyTypes = ref([])
    const data = ref({
        brand: null,
        model: null,
        year: null,
        vin_number: null,
        register_number: null,
        max_volume: null,
        max_weight: null,
        vehicle_category_id: null,
        body_type_id: null,
    });
    const data__errors = ref({
        brand: [],
        model: [],
        year: [],
        vin_number: [],
        register_number: [],
        max_volume: [],
        max_weight: [],
        vehicle_category_id: [],
        body_type_id: [],
    });

    const action = () => {
        actionLoading.value = true;

        data__errors.value = {
            brand: [],
            model: [],
            year: [],
            vin_number: [],
            register_number: [],
            max_volume: [],
            max_weight: [],
            vehicle_category_id: [],
            body_type_id: [],
        }

        storeVehicle(data.value, authStore.token).then(res => {
            notify({
                title: "Добавление",
                text: res.data.message,
                type: 'success'
            });
            actionLoading.value = false;

            router.push('/me/vehicles');
        }).catch(err => {
            if(err.status >= 500) {
                notify({
                    title: "API",
                    text: "Ошибка сервера. Попробуйте позже.",
                    type: 'error'
                });

                actionLoading.value = false;
                return;
            }
            
            const errors = err.response?.data?.errors || {};

            data__errors.value = {
                brand: errors.brand || [],
                model: errors.model || [],
                year: errors.year || [],
                vin_number: errors.vin_number || [],
                register_number: errors.register_number || [],
                max_volume: errors.max_volume || [],
                max_weight: errors.max_weight || [],
                vehicle_category_id: errors.vehicle_category_id || [],
                body_type_id: errors.body_type_id || [],
            };

            actionLoading.value = false;
        })
    }

    onMounted(() => {
        getVehicleCategories(authStore.token).then(res => {
            vehicleCategories.value = res.data.data
        }).catch(err => {
            console.log(err);
        })

        getBodyTypes(authStore.token).then(res => {
            bodyTypes.value = res.data.data
        }).catch(err => {
            console.log(err);
        })
    })

</script>

<template>
    <div class="mt-6 flex items-center justify-between">
        <div>
            <div class="text-2xl font-bold">Автомобиль</div>
            <div class="text-xs">Добавление нового автомобиля</div>
        </div>
        <div class="flex items-center gap-[10px]">
            <router-link :to="{'name': 'VehiclesIndex'}" class="text-sm border border-dark-50 py-[5px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
                <div class="flex items-center gap-[10px]">
                    <Delete color="black"/>
                    <div>Отмена</div>
                </div>
            </router-link>
            <button type="button" v-on:click="action()" class="text-sm bg-sky-400 text-white py-[6px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
                <div class="flex items-center gap-[10px]">
                    <Edit color="#FFF"/>
                    <div>Сохранить</div>
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
                    <InputGroup v-model="data.brand" :error="data__errors.brand[0]" label="Бренд" placeholder="MAN"/>
                    <InputGroup v-model="data.model" :error="data__errors.model[0]" label="Модель" placeholder="TGX"/>
                    <InputGroup v-model="data.year" v-mask="'####'" :error="data__errors.year[0]" label="Год выпуска" placeholder="2024"/>
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

                <div class="text-base mt-6">Документация</div>
                <hr class="border-gray-300 my-3">
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
                        v-mask="'XXXXXXXXXXXXXXXXX'"
                        placeholder="JHMCM56557C404453"/>
                </div>

                <div class="text-base mt-6">Кузов</div>
                <hr class="border-gray-300 my-3">
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