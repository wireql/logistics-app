<script setup>
    import { ref, watch } from 'vue';
    import { useRoute } from 'vue-router';
    import { notify } from '@kyvg/vue3-notification';
    import { deleteAddress, getAddresses } from '@/api/Address';
    import { useAuthStore } from '@/stores/auth';

    import Delete from '@/components/Icons/delete.vue';
    import Edit from '@/components/Icons/edit.vue';
    import Arrow from '@/components/Icons/arrow.vue';
    import Modal from '@/components/UI/Modal.vue';

    const response = ref([]);
    const loading = ref(false);
    const loadingDelete = ref(false);
    const showModal = ref(false);
    const userId = ref(null);

    const authStore = useAuthStore()
    const route = useRoute();

    const deleteModal = (id) => {
        showModal.value = true;
        userId.value = id;
    }

    const confirmDelete = async () => {
        loadingDelete.value = true;
        
        try {
            const res = await deleteAddress(authStore.token, userId.value);

            notify({
                title: "Удаление",
                text: res.data.message,
                type: 'success'
            });
            
            fetchAddress()
        } catch (err) {
            loadingDelete.value = false
        } finally {
            loadingDelete.value = false
            showModal.value = false
        }
    }

    const linkPrev = () => {
        if(response.value.current_page <= 1){
            return "/me/address";
        }

        return "/me/address?page=" + (response.value.current_page - 1);
    }

    const linkTo = () => {
        if(response.value.current_page >= response.value.last_page){
            return "/me/address?page=" + response.value.current_page;
        }

        return "/me/address?page=" + (response.value.current_page + 1);
    }

    const fetchAddress = async () => {
        loading.value = true;

        const params = route.query

        try {
            const res = await getAddresses(authStore.token, params);

            response.value = res.data.data
            loading.value = false
        } catch (err) {
            console.log(err);
        } finally {
            loading.value = false
        }
    };

    watch(() => route.query.page, fetchAddress, { immediate: true });
</script>

<template>
    <Modal size="small" position="middle" :show="showModal">
        <h2 class="text-lg font-bold">Подтвердите действие</h2>
        <p class="mt-2 text-sm">Вы уверены, что хотите удалить данный адрес?</p>
        
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

    <div class="mt-6 flex items-center justify-between">
        <div class="text-2xl font-bold">Ваши адреса</div>

        <router-link :to="{'name': 'AddressCreate'}" class="text-sm bg-dark-999 text-white py-[8px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
            Добавить адрес
        </router-link>
    </div>

    <hr class="border-gray-300 my-[24px]">

    <div class="mt-6">
        <div class="flex flex-col gap-3 overflow-x-auto">
            <div class="flex justify-between">
                <div class="text-xs opacity-[60%]">1-{{response.per_page}} из {{response.total}} записи</div>
                <div class="flex items-center gap-3">
                    <router-link :to="linkPrev()" class="hover:cursor-pointer hover:bg-dark-50/70 rounded-[3px] px-1.5 py-1.5">
                        <Arrow color="black" class="rotate-180"/>
                    </router-link>
                    <div>{{response.current_page}}</div>
                    <router-link :to="linkTo()" class="hover:cursor-pointer hover:bg-dark-50/70 rounded-[3px] px-1.5 py-1.5">
                        <Arrow color="black"/>
                    </router-link>
                </div>
            </div>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="text-xs font-normal py-3 text-left px-1">Адрес</th>
                        <th class="text-xs font-normal py-3 text-left px-1">Категория</th>
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
                    </tr>
                    <tr v-else v-for="address in response.data" :key="address.id">
                        <td class="text-xs font-normal py-2 border-t-1 border-gray-300 px-1">{{ address.name }}</td>
                        <td class="text-xs font-normal py-2 border-t-1 border-gray-300 px-1">{{ address.category.name }}</td>
                        <td class="text-xs font-normal py-2 border-t-1 border-gray-300 px-1">
                            <div class="flex gap-2">
                                <router-link :to="{'name': 'AddressUpdate', 'params': {'id': address.id}}" class="hover:cursor-pointer hover:bg-dark-50/70 rounded-[3px] px-1.5 py-1.5">
                                    <Edit color="black" />
                                </router-link>
                                <div v-on:click="deleteModal(address.id)" class="hover:cursor-pointer hover:bg-red-100 rounded-[3px] px-1.5 py-1.5">
                                    <Delete color="black" />
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>