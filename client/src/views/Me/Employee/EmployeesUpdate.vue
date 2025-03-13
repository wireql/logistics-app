<script setup>
    import { getEmployee, updateEmployee } from '@/api/Employee';
    import { notify } from '@kyvg/vue3-notification';
    import { onMounted, ref } from 'vue'; 
    import { useAuthStore } from '@/stores/auth';
    import router from '@/router';
    import { useRoute } from 'vue-router';
    import generatePassword from '@/helpers/PasswordGenerator';

    import Delete from '@/components/Icons/delete.vue';
    import Edit from '@/components/Icons/edit.vue';
    import Copy from '@/components/Icons/copy.vue';
    import InputGroup from '@/components/UI/InputGroup.vue'
    import CopyActive from '@/components/Icons/copy-active.vue';
    import Gear from '@/components/Icons/gear.vue';

    const authStore = useAuthStore()
    const route = useRoute();
    const userId = route.params.id
    const loading = ref(false);
    const copy = ref(false);
    const actionLoading = ref(false);

    const data = ref({
        first_name: null,
        middle_name: null,
        last_name: null,
        email: null,
        password: null,
        user_category_id: null,
    });
    const data__errors = ref({
        first_name: [],
        middle_name: [],
        last_name: [],
        email: [],
        password: [],
        user_category_id: [],
    });

    const genPass = () => {
        data.value.password = generatePassword();
    };

    const copyPass = async () => {
        try {
            await navigator.clipboard.writeText(data.value.password);
            notify({
                title: "Копирование",
                text: "Пароль скопирован в буфер обмена!",
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

    const action = () => {
        actionLoading.value = true;

        data__errors.value = {
            first_name: [],
            middle_name: [],
            last_name: [],
            email: [],
            password: [],
            user_category_id: [],
        }

        updateEmployee(data.value, userId, authStore.token).then(res => {
            notify({
                title: "Обновление",
                text: res.data.message,
                type: 'success'
            });
            actionLoading.value = false;

            router.push('/me/employees');
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
                first_name: errors.first_name || [],
                middle_name: errors.middle_name || [],
                last_name: errors.last_name || [],
                email: errors.email || [],
                password: errors.password || [],
                user_category_id: errors.user_category_id || [],
            };

            actionLoading.value = false;
        })
    }

    onMounted(() => {
        loading.value = true;

        getEmployee(authStore.token, userId).then(res => {
            data.value = res.data.data

            loading.value = false
        }).catch(err => {
            loading.value = false
        });
    })

</script>

<template>
    <div class="mt-6 flex flex-col sm:flex-row sm:items-center justify-between">
        <div>
            <div class="text-2xl font-bold">Сотрудник</div>
            <div class="text-xs">Обновление информации о сотруднике</div>
        </div>
        <div class="flex items-center gap-[10px] mt-2">
            <router-link :to="{'name': 'EmployeesIndex'}" class="text-sm border border-dark-50 py-[5px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
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

    <div class="mt-6">
        <div class="grid grid-cols-12 gap-5">
            <div class="col-span-12 sm:col-span-4 xl:col-span-3">
                <div class="text-sm font-bold">Основная информация</div>
            </div>
            <div class="col-span-12 sm:col-span-8 xl:col-span-4">
                <div class="flex flex-col gap-6">
                    <InputGroup v-model="data.last_name" :error="data__errors.last_name[0]" label="Фамилия" placeholder="Иванов"/>
                    <InputGroup v-model="data.first_name" :error="data__errors.first_name[0]" label="Имя" placeholder="Иван"/>
                    <InputGroup v-model="data.middle_name" :error="data__errors.middle_name[0]" label="Отчество" placeholder="Иванович"/>
                    <div class="flex flex-col gap-[5px] w-full">
                        <label class="text-sm opacity-[60%]">Должность</label>
                        <select v-model="data.user_category_id" class="text-sm w-full border border-gray-300 focus:border-gray-700 bg-dark-100 py-[6px] px-[9px] rounded-[6px]">
                            <option value="2">Логист</option>
                            <option value="3">Менеджер</option>
                            <option value="4">Водитель</option>
                        </select>
                        <p v-if="data__errors.user_category_id !== null" class="text-red-300 text-xs">{{ data__errors.user_category_id[0] }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <hr class="border-gray-300 my-[24px]">

        <div class="grid grid-cols-12 gap-5">
            <div class="col-span-12 sm:col-span-4 xl:col-span-3">
                <div class="text-sm font-bold">Личный кабинет</div>
            </div>
            <div class="col-span-12 sm:col-span-8 xl:col-span-4">
                <div class="flex flex-col gap-6">
                    <InputGroup v-model="data.email" :error="data__errors.email[0]" label="Электронная почта" placeholder="test@test.ru" type="email"/>
                    <InputGroup v-model="data.password" :error="data__errors.password[0]" label="Пароль" placeholder="******" type="password"/>
                    <div class="flex gap-1">
                        <button type="button" v-on:click="copyPass()" class="text-sm bg-dark-999 text-white py-[6px] px-[6px] rounded-[6px] w-auto hover:cursor-pointer">
                            <div class="flex items-center gap-[10px]">
                                <Copy v-if="!copy" size="24" />
                                <CopyActive v-else size="24" />
                            </div>
                        </button type="button">
                        <button type="button" v-on:click="genPass()" class="text-sm bg-dark-999 text-white py-[6px] px-[6px] rounded-[6px] w-full hover:cursor-pointer flex justify-center">
                            <div class="flex items-center gap-[10px]">
                                <Gear size="24"/>
                                <div>Сгенерировать</div>
                            </div>
                        </button type="button">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>