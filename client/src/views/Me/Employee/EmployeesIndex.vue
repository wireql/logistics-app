<script setup>
    import { onDeactivated, ref, watch } from 'vue';
    import { useRoute } from 'vue-router';
    import { notify } from '@kyvg/vue3-notification';
    import { deleteEmployee, getEmployees } from '@/api/Employee';
    import router from '@/router';
    import { useAuthStore } from '@/stores/auth';

    import Delete from '@/components/Icons/delete.vue';
    import Edit from '@/components/Icons/edit.vue';
    import Arrow from '@/components/Icons/arrow.vue';
    import Modal from '@/components/UI/Modal.vue';
    import Search from '@/components/Icons/search.vue';

    const response = ref([]);
    const loading = ref(false);
    const loadingDelete = ref(false);
    const userId = ref(null);
    const showModal = ref(false);
    const findInput = ref('');
    const findTimeout = ref(null);

    const authStore = useAuthStore()
    const route = useRoute();

    const deleteModal = (id) => {
        userId.value = id;
        showModal.value = true;
    }

    const confirmDelete = () => {
        loadingDelete.value = true;
        deleteEmployee(authStore.token, userId.value).then(res => {
            loadingDelete.value = false
            showModal.value = false

            notify({
                title: "Удаление",
                text: res.data.message,
                type: 'success'
            });
            fetchEmployees()
        }).catch(err => {
            loadingDelete.value = false
            showModal.value = false
        });
    }

    const linkPrev = () => {
        if(response.value.current_page <= 1){
            return "/me/employees";
        }

        return "/me/employees?page=" + (response.value.current_page - 1);
    }

    const linkTo = () => {
        if(response.value.current_page >= response.value.last_page){
            return "/me/employees?page=" + response.value.current_page;
        }

        return "/me/employees?page=" + (response.value.current_page + 1);
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

    const fetchEmployees = async () => {
        loading.value = true;

        const params = route.query

        try {
            const res = await getEmployees(authStore.token, params);
    
            response.value = res.data.data;
            loading.value = false;
        } catch (err) {
            console.log(err);
        } finally {
            loading.value = false;
        }

    };

    watch(() => route.query, fetchEmployees, { immediate: true });

</script>

<template>
    <Modal size="small" position="middle" :show="showModal">
        <h2 class="text-lg font-bold">Подтвердите действие</h2>
        <p class="mt-2 text-sm">Вы уверены, что хотите удалить данного сотрудника?</p>
        
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
        <div class="text-2xl font-bold">Ваши сотрудники</div>
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
                    
                    <router-link :to="{'name': 'EmployeesCreate'}" class="text-sm bg-dark-999 text-white py-[8px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
                        Добавить сотрудника
                    </router-link>
                </div>
            </div>

            <!-- Таблица -->
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="text-xs font-normal py-3 text-left px-1">ФИО</th>
                        <th class="text-xs font-normal py-3 text-left px-1">Электронная почта</th>
                        <th class="text-xs font-normal py-3 text-left px-1">Должность</th>
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
                    <tr v-else v-for="user in response.data" :key="user.id">
                        <td class="text-xs font-normal py-2 border-t-1 border-gray-300 px-1">{{ user.last_name + " " + user.first_name + " " + user.middle_name }}</td>
                        <td class="text-xs font-normal py-2 border-t-1 border-gray-300 px-1">{{ user.email }}</td>
                        <td class="text-xs font-normal py-2 border-t-1 border-gray-300 px-1">{{ user.category.name }}</td>
                        <td class="text-xs font-normal py-2 border-t-1 border-gray-300 px-1">
                            <div class="flex gap-2">
                                <router-link :to="`/me/employees/`+user.id" class="hover:cursor-pointer hover:bg-dark-50/70 rounded-[3px] px-1.5 py-1.5">
                                    <Edit color="black" />
                                </router-link>
                                <div v-on:click="deleteModal(user.id)" class="hover:cursor-pointer hover:bg-red-100 rounded-[3px] px-1.5 py-1.5">
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