<script setup>

    import { ref } from 'vue';
    import { registerUser } from '@/api/User';
    import { notify } from "@kyvg/vue3-notification";

    /**
     * Components
     */
    import InputGroup from '../../components/UI/InputGroup.vue'
    import Button from '../../components/UI/Button.vue'
    import router from '@/router';

    /**
     * Data and variables
     */
    const actionLoading = ref(false);
    const fields = [
        'first_name', 'middle_name', 'last_name', 'company_name', 'email', 'password', 'password_confirmation'
    ];

    const data = ref(Object.fromEntries(fields.map(field => [field, null])));
    const data__errors = ref(Object.fromEntries(fields.map(field => [field, []])));

    const resetErrors = () => {
        Object.keys(data__errors.value).forEach(key => {
            data__errors.value[key] = [];
        });
    };

    /**
     * Methods
     */
    const action = async () => {
        actionLoading.value = true;

        try {
            resetErrors()

            const response = await registerUser(data.value);

            notify({
                title: "Регистрация",
                text: response.data.message,
                type: 'success'
            });
            actionLoading.value = false;

            router.push('/login');
            
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
                    <div>{{ actionLoading ? 'Регистрация...' : 'Зарегистрироваться' }}</div>
                </Button>
                <div class="text-sm text-right">Есть аккаунт? 
                    <router-link to="/login" class="underline">Авторизоваться</router-link>
                </div>
            </div>
        </div>
    </div>
    
</template>