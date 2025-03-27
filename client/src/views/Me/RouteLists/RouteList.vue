<script setup>
    import { getRouteList, getRouteListDocument } from '@/api/RouteList';
    import { getRoutePoints } from '@/api/RoutePoint';
    import Calendar from '@/components/Icons/calendar.vue';
    import Cargo from '@/components/Icons/cargo.vue';
    import CopyActive from '@/components/Icons/copy-active.vue';
    import Copy from '@/components/Icons/copy.vue';
    import Delete from '@/components/Icons/delete.vue';
    import Download from '@/components/Icons/download.vue';
    import Driver from '@/components/Icons/driver.vue';
    import Edit from '@/components/Icons/edit.vue';
    import File from '@/components/Icons/file.vue';
    import Flag from '@/components/Icons/flag.vue';
    import InfoBlock from '@/components/Icons/info-block.vue';
    import Search from '@/components/Icons/search.vue';
    import Truck from '@/components/Icons/truck.vue';
    import UserBlock from '@/components/Icons/user-block.vue';
    import Button from '@/components/UI/Button.vue';
    import { useAuthStore } from '@/stores/auth';
    import { notify } from '@kyvg/vue3-notification';
    import { computed, onMounted, ref } from 'vue';
    import { useRoute } from 'vue-router';

    const copy = ref(false);
    const loading = ref(false);
    const route = useRoute();
    const routeListId = route.params.id
    const data = ref([]);
    const routePoints = ref([]);

    const authStore = useAuthStore();

    const copyUuid = async () => {
        try {
            await navigator.clipboard.writeText(data.value.id);
            notify({
                title: "Копирование",
                text: "UUID скопирован в буфер обмена!",
                type: 'success'
            });
            copy.value = true;
            
            setTimeout(() => {
                copy.value = false
            }, 1000);
        } catch (err) {
            console.error('Ошибка копирования: ', err);
        }
    }

    const formattedDescription = computed(() => {
        return data.value?.description ? data.value.description.replace(/\n/g, '<br>') : '';
    });

    const downloadRouteList = async (id) => {
        try {
            const res = await getRouteListDocument(authStore.token, id);
            

            const blob = new Blob([res.data], {
                type: res.headers['content-type']
            });

            const url = window.URL.createObjectURL(blob);
            const a = document.createElement("a");

            a.href = url;
            a.download = `route_${id}.docx`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        } catch (err) {
            notify({
                title: "Ошибка",
                text: "Не удалось загрузить файл. Попробуйте позже.",
                type: 'error'
            });
        }
    }
 
    onMounted(async () => {
        loading.value = true;

        try {
            const [routeListRes, routePointsRes] = await Promise.all([
                getRouteList(authStore.token, routeListId),
                getRoutePoints(authStore.token, routeListId, null),
            ]);

            data.value = routeListRes.data.data;
            routePoints.value = routePointsRes.data.data;
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
    <div class="mt-6 flex flex-col sm:flex-row sm:items-center justify-between">
        <div>
            <div class="text-2xl font-bold">Маршрутный лист</div>
            <div class="text-xs flex gap-1 items-center">
                UUID:
                <div v-if="loading" class="h-[12px] rounded bg-gray-200 w-52 animate-pulse"></div>
                <div>{{ data.id }}</div>
            </div>
        </div>
        <div class="flex items-center gap-[10px] mt-2">
            <router-link :to="{'name': 'RouteListsIndex'}" class="text-sm border border-dark-50 py-[5px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
                <div class="flex items-center gap-[10px]">
                    <Delete color="black"/>
                    <div class="">Отмена</div>
                </div>
            </router-link>
            <button type="button" class="text-sm bg-[#C1E0FF] text-white py-[6px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
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
            <div class="col-span-4">
                <router-link :to="{'name': 'RoutePointsCreate'}">
                    <Button>Добавить подзадачу</Button>
                </router-link>

                <div class="mt-6 flex flex-col gap-3">

                    <div v-if="loading" class="h-[50px] rounded bg-gray-200 w-full animate-pulse"></div>
                    <div v-else v-for="routePoint in routePoints" :key="routePoint.id" class="p-[15px] rounded-xl border border-gray-300">
                        <div class="flex items-center gap-1">
                            <div class="text-sm">ID:</div>
                            <div class="text-sm font-bold">{{routePoint.id}}</div>
                        </div>
                        <hr class="border-gray-300 my-[12px]">
                        <div class="flex flex-col gap-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <Flag />
                                    <div class="text-xs">Статус</div>
                                </div>
                                <div class="flex items-center gap-1">
                                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                    <div class="text-xs">{{routePoint.status.name}}</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <Calendar />
                                    <div class="text-xs">Плановая дата</div>
                                </div>
                                <div class="flex items-center gap-1">
                                    <div class="text-xs">{{routePoint.plan_delivery}}</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <Cargo />
                                    <div class="text-xs">Груз</div>
                                </div>
                                <div class="flex items-center gap-1">
                                    <div class="text-xs underline hover:cursor-pointer">Картошка</div>
                                </div>
                            </div>
                        </div>
                        <hr class="border-gray-300 my-[12px]">
                        <div class="flex items-center justify-between">
                            <div class="flex gap-2 items-center">
                                <div class="p-2 bg-[#C1E0FF] w-max rounded-sm">
                                    <UserBlock />
                                </div>
                                <div>
                                    <div class="text-xs">{{routePoint.address_to.city + " ул." + routePoint.address_to.street + " д." + routePoint.address_to.building}}</div>
                                    <div class="text-xs text-gray-400">{{routePoint.address_to.category.name}}</div>
                                </div>
                            </div>
                            <div class="p-2 bg-[#E9ECEF] rounded-full hover:cursor-pointer w-max">
                                <InfoBlock />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-span-8">
                <div class="flex items-center justify-between">
                    <div class="flex flex-col gap-1">
                        <div class="text-base">Маршрутный лист</div>
                        <div class="flex items-center gap-[5px] hover:cursor-pointer" v-on:click="copyUuid()">
                            <div class="text-xs opacity-[60%] truncate">
                                <div v-if="loading" class="h-[12px] rounded bg-gray-200 w-52 animate-pulse"></div>
                                <div v-else>{{ data.id }}</div>
                            </div>
                            <Copy v-if="!copy" color="#797979" size="14" />
                            <CopyActive v-else color="#797979" size="14" />
                        </div>
                    </div>
                    <div class="flex items-center gap-1 px-2 py-1 bg-[#E9ECEF] rounded-sm hover:cursor-pointer" v-on:click="downloadRouteList(data.id)">
                        <Download />
                        <div class="text-xs">Скачать для печати</div>
                    </div>
                </div>

                <div class="grid grid-cols-8 gap-5 mt-6">
                    <div class="col-span-5">
                        <div class="text-base font-bold">Автомобиль</div>
                        <div class="p-[15px] rounded-xl border border-gray-300 mt-3">
                            <div class="flex gap-2 items-center">
                                <div class="p-2 bg-[#C1E0FF] w-max rounded-sm">
                                    <Truck />
                                </div>
                                <div v-if="loading">
                                    <div class="h-[12px] rounded bg-gray-200 w-24 animate-pulse"></div>
                                    <div class="h-[12px] rounded bg-gray-200 w-24 animate-pulse mt-2"></div>
                                </div>
                                <div v-else>
                                    <div class="text-xs">{{data.vehicle ? data.vehicle.brand : ""}}</div>
                                    <div class="text-xs text-gray-400">Автомобиль</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-3">
                                <div class="flex flex-col gap-1">
                                    <div class="text-xs text-gray-400">Регистрационный номер</div>

                                    <div v-if="loading" class="h-[12px] rounded bg-gray-200 w-24 animate-pulse"></div>
                                    <div v-else class="text-xs">{{data.vehicle ? data.vehicle.register_number : ""}}</div>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <div class="text-xs text-gray-400">Тип автомобиля</div>
                                    <div v-if="loading" class="h-[12px] rounded bg-gray-200 w-24 animate-pulse"></div>
                                    <div v-else class="text-xs">{{data.vehicle ? data.vehicle.category.name : ""}}</div>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <div class="text-xs text-gray-400">Тип кузова</div>
                                    <div v-if="loading" class="h-[12px] rounded bg-gray-200 w-24 animate-pulse"></div>
                                    <div v-else class="text-xs">{{data.vehicle ? data.vehicle.body_type.name : ""}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-3">
                        <div class="text-base font-bold">Водитель</div>
                        <div class="p-[15px] rounded-xl border border-gray-300 mt-3">
                            <div class="flex gap-2 items-center">
                                <div class="p-2 bg-[#C1E0FF] w-max rounded-sm">
                                    <Driver />
                                </div>
                                <div v-if="loading">
                                    <div class="h-[12px] rounded bg-gray-200 w-24 animate-pulse"></div>
                                    <div class="h-[12px] rounded bg-gray-200 w-24 animate-pulse mt-2"></div>
                                </div>
                                <div v-else>
                                    <div class="text-xs">{{data.driver ? data.driver.first_name + " " + data.driver.middle_name + " " + data.driver.last_name : ""}}</div>
                                    <div class="text-xs text-gray-400">Водитель</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-3">
                                <div class="flex flex-col gap-1">
                                    <div class="text-xs text-gray-400">Телефон</div>
                                    <div class="text-xs">+79501231212</div>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <div class="text-xs text-gray-400">Электронная почта</div>
                                    <div v-if="loading" class="h-[12px] rounded bg-gray-200 w-24 animate-pulse"></div>
                                    <div v-else class="text-xs">{{data.driver ? data.driver.email : ""}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="text-base font-bold">Состояние автомобиля</div>
                    <div class="p-[15px] rounded-xl border border-gray-300 mt-3 flex justify-between">
                        <div class="flex flex-col gap-1">
                            <div class="text-xs text-gray-400">Загруженность, %</div>
                            <div class="text-xs">71% / 100%</div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <div class="text-xs text-gray-400">Загруженность, тонн</div>
                            <div class="text-xs">1.24 / 5</div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <div class="text-xs text-gray-400">Загруженность, м3</div>
                            <div class="text-xs">5 / 15</div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <div class="text-xs text-gray-400">Статус</div>
                            <div v-if="loading" class="h-[12px] rounded bg-gray-200 w-24 animate-pulse"></div>
                            <div v-else class="text-xs">{{data.vehicle ? data.vehicle.status.name : ""}}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="text-base font-bold">Описание</div>
                    <div class="p-[15px] rounded-xl border border-gray-300 mt-3">
                        <div v-if="loading" class="h-[12px] rounded bg-gray-200 w-24 animate-pulse"></div>
                        <div v-else class="text-xs" v-html="formattedDescription"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>