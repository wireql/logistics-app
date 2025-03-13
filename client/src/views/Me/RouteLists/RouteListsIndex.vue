<script setup>
    import { deleteRouteList, getRouteLists } from '@/api/RouteList';
    import Arrow from '@/components/Icons/arrow.vue';
    import Delete from '@/components/Icons/delete.vue';
    import Edit from '@/components/Icons/edit.vue';
    import Search from '@/components/Icons/search.vue';
    import Modal from '@/components/UI/Modal.vue'; 
    import TaskCard from '@/components/UI/Profile/TaskCard.vue';
    import TaskCard__Loading from '@/components/UI/Profile/TaskCard__Loading.vue';
    import router from '@/router';
    import { useAuthStore } from '@/stores/auth';
    import { notify } from '@kyvg/vue3-notification';
    import { ref, watch } from 'vue';
    import { useRoute } from 'vue-router';

    const response = ref([])
    const loading = ref(false)
    const findInput = ref('');
    const findTimeout = ref(null);
    const loadingDelete = ref(false);
    const userId = ref(null);
    const showModal = ref(false);

    const authStore = useAuthStore();
    const route = useRoute();

    const deleteModal = (id) => {
        showModal.value = true;
        userId.value = id;
    }

    const confirmDelete = async () => {
        loadingDelete.value = true;
        
        try {
            const res = await deleteRouteList(authStore.token, userId.value);

            notify({
                title: "Удаление",
                text: res.data.message,
                type: 'success'
            });
            
            fetchRouteLists()
        } catch (err) {
            loadingDelete.value = false
        } finally {
            loadingDelete.value = false
            showModal.value = false
        }
    }

    const linkPrev = () => {
        if(response.value.current_page <= 1){
            return "/me/route-lists";
        }

        return "/me/route-lists?page=" + (response.value.current_page - 1);
    }

    const linkTo = () => {
        if(response.value.current_page >= response.value.last_page){
            return "/me/route-lists?page=" + response.value.current_page;
        }

        return "/me/route-lists?page=" + (response.value.current_page + 1);

    }

    const onInput = () => {
        if(findTimeout.value) {
            clearTimeout(findTimeout.value);
        }

        findTimeout.value = setTimeout(() => {
            router.push({
                query: {
                    ...route.query,
                    search: findInput.value,
                },
            });
        }, 1000)
    }

    const fetchRouteLists = async () => {
        loading.value = true;

        const params = route.query

        try {
            const res = await getRouteLists(authStore.token, params);

            response.value = res.data.data
            loading.value = false
        } catch (err) {
            console.log(err);
        } finally {
            loading.value = false
        }
    };

    watch(() => route.query, fetchRouteLists, { immediate: true });
</script>

<template>
    <Modal size="small" position="middle" :show="showModal">
        <h2 class="text-lg font-bold">Подтвердите действие</h2>
        <p class="mt-2 text-sm">Вы уверены, что хотите удалить данный маршрутный лист?</p>
        
        <div class="mt-4 flex justify-end space-x-2">
            <button @click="showModal = false" class="text-sm border border-dark-50 py-[5px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
                <div class="flex items-center gap-[10px]">
                    <div>Отмена</div>
                </div>
            </button>
            <button @click="confirmDelete()" class="text-sm bg-red-400 text-white py-[6px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
                <div class="flex items-center gap-[10px]">
                    <span>{{ loadingDelete ? 'Удаление...' : 'Удалить' }}</span>
                </div>
            </button>
        </div>
    </Modal>

    <div class="mt-6">
        <div class="text-2xl font-bold">Ваши маршрутные листы</div>
    </div>

    <hr class="border-gray-300 my-[24px]">

    <div class="mt-6">
        <div class="flex flex-col gap-3 overflow-x-auto">
            <!-- Действия -->
            <div class="flex justify-between items-center">
                <div v-if="loading" class="h-[12px] rounded bg-gray-200 w-32 animate-pulse"></div>
                <div v-else class="text-xs opacity-[60%]">1-{{response.per_page}} из {{response.total}} записи</div>
                <div class="flex gap-3">
                    <div 
                        class="flex items-center px-[9px] gap-2 border border-gray-300 focus:border-gray-700 bg-dark-100 rounded-[6px]"
                    >
                        <Search color="#B0B0B0"/>
                        <input 
                            v-model="findInput"
                            placeholder="Поиск"
                            class="text-sm focus:outline-0"
                            @input="onInput"
                        />
                    </div>
                    
                    <router-link :to="{'name': 'RouteListsCreate'}" class="text-sm bg-dark-999 text-white py-[8px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
                        Добавить маршрутный лист
                    </router-link>
                </div>
            </div>

            <!-- Таблица -->
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="text-xs font-normal py-3 text-left px-1">UUID</th>
                        <th class="text-xs font-normal py-3 text-left px-1">Описание</th>
                        <th class="text-xs font-normal py-3 text-left px-1">Плановая дата завершения</th>
                        <th class="text-xs font-normal py-3 text-left px-1">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="loading">
                        <td class="text-center py-4 text-gray-500">
                            <div class="h-[12px] rounded bg-gray-200 w-12 animate-pulse"></div>
                        </td>
                        <td class="text-center py-4 text-gray-500">
                            <div class="h-[12px] rounded bg-gray-200 w-12 animate-pulse"></div>
                        </td>
                        <td class="text-center py-4 text-gray-500">
                            <div class="h-[12px] rounded bg-gray-200 w-12 animate-pulse"></div>
                        </td>
                        <td class="text-center py-4 text-gray-500">
                            <div class="h-[12px] rounded bg-gray-200 w-12 animate-pulse"></div>
                        </td>
                    </tr>
                    <tr v-else v-for="route_list in response.data" :key="route_list.id">
                        <td class="text-xs font-normal py-2 border-t-1 border-gray-300 px-1">
                            {{ route_list.id }}
                        </td>
                        <td class="text-xs font-normal py-2 border-t-1 border-gray-300 px-1 truncate max-w-56">{{ route_list.description }}</td>
                        <td class="text-xs font-normal py-2 border-t-1 border-gray-300 px-1">{{ route_list.plan_delivery }}</td>
                        <td class="text-xs font-normal py-2 border-t-1 border-gray-300 px-1">
                            <div class="flex gap-2">
                                <router-link :to="{'name': 'RouteListsUpdate', 'params': {'id': route_list.id}}" class="hover:cursor-pointer hover:bg-dark-50/70 rounded-[3px] px-1.5 py-1.5">
                                    <Edit color="black" />
                                </router-link>
                                <div v-on:click="deleteModal(route_list.id)" class="hover:cursor-pointer hover:bg-red-100 rounded-[3px] px-1.5 py-1.5">
                                    <Delete color="black" />
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Пагинация -->
            <div class="flex justify-end">
                <div v-if="loading" class="h-[24px] rounded bg-gray-200 w-20 animate-pulse"></div>
                <div v-else class="flex items-center gap-3">
                    <router-link :to="linkPrev()" class="hover:cursor-pointer hover:bg-dark-50/70 rounded-[3px] px-1.5 py-1.5">
                        <Arrow color="black" class="rotate-180"/>
                    </router-link>
                    <div>{{response.current_page}}</div>
                    <router-link :to="linkTo()" class="hover:cursor-pointer hover:bg-dark-50/70 rounded-[3px] px-1.5 py-1.5">
                        <Arrow color="black"/>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>