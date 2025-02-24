<script setup>
    import InputGroup from '../../components/UI/InputGroup.vue'
    import Button from '../../components/UI/Button.vue'
    import { ref } from 'vue';
    import { registerUser } from '@/api/User';
    import { notify } from "@kyvg/vue3-notification";
    import router from '@/router';

    const data = ref({
        first_name: null,
        middle_name: null,
        last_name: null,
        company_name: null,
        email: null,
        password: null,
        password_confirmation: null,
    });
    const data__errors = ref({
        first_name: [],
        middle_name: [],
        last_name: [],
        company_name: [],
        email: [],
        password: [],
    });
    const actionLoading = ref(false);

    const action = () => {
        actionLoading.value = true;

        data__errors.value = {
            first_name: [],
            middle_name: [],
            last_name: [],
            company_name: [],
            email: [],
            password: [],
        }

        registerUser(data.value).then(res => {
            notify({
                title: "Регистрация",
                text: "Вы успешно зарегистрировались!",
                type: 'success'
            });
            actionLoading.value = false;

            router.push('/login');
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
                company_name: errors.company_name || [],
                email: errors.email || [],
                password: errors.password || [],
            };

            actionLoading.value = false;
        })

    }
</script>

<template>

    <div class="flex justify-center mt-[100px]">
        <div class="flex flex-col gap-6 max-w-[300px] w-full">
            <div class="flex flex-col gap-[5px]">
                <div class="font-bold text-2xl">Регистрация</div>
                <div class="text-sm">Добро пожаловать!</div>
            </div>

            <div class="flex flex-col gap-6">
                <div class="flex gap-6">
                    <InputGroup v-model="data.last_name" label="Фамилия" placeholder="Иванов" :error="data__errors.last_name[0]"/>
                    <InputGroup v-model="data.first_name" label="Имя" placeholder="Иван" :error="data__errors.first_name[0]"/>
                </div>
                <InputGroup v-model="data.middle_name" label="Отчество" placeholder="Иванович" :error="data__errors.middle_name[0]"/>
                <InputGroup v-model="data.company_name" label="Название компании" placeholder="ООО “СуперКомпани”" :error="data__errors.company_name[0]"/>
                <InputGroup v-model="data.email" label="Электронная почта" placeholder="example@gmail.com" type="email" name="email" :error="data__errors.email[0]"/>
                <InputGroup v-model="data.password" label="Пароль" placeholder="*******" type="password" :error="data__errors.password[0]"/>
                <InputGroup v-model="data.password_confirmation" label="Повтор пароля" placeholder="******" type="password" :error="data__errors.password[0]"/>
            </div>

            <div class="flex flex-col gap-[5px]">
                <Button v-on:click="action()">
                    <div v-if="!actionLoading">Зарегистрироваться</div>
                    <div v-else>Обработка...</div>
                </Button>
                <div class="text-sm text-right">Есть аккаунт? 
                    <router-link to="/login" class="underline">Авторизоваться</router-link>
                </div>
            </div>
        </div>
    </div>
    
</template>