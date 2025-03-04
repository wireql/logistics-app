<script setup>
    /**
     * 
     */
    import { ref } from 'vue';
    import { loginUser } from '@/api/User';
    import { notify } from "@kyvg/vue3-notification";
    import { useAuthStore } from '@/stores/auth';

    /**
     * Components
     */
    import InputGroup from '../../components/UI/InputGroup.vue'
    import Button from '../../components/UI/Button.vue'
    import router from '@/router';

    const authStore = useAuthStore();

    /**
     * Data and variables
     */
    const actionLoading = ref(false);
    const fields = [
        'email', 'password'
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

            const response = await loginUser(data.value);

            notify({
                title: "Успешно",
                text: response.data.message,
                type: 'success'
            });
            actionLoading.value = false;

            authStore.setUser(response.data.data.user)
            authStore.setToken(response.data.data.token)
            router.push('/me');
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
                <div class="font-bold text-2xl">Авторизация</div>
                <div class="text-sm">С возвращением!</div>
            </div>

            <div class="flex flex-col gap-6">
                <InputGroup label="Электронная почта" placeholder="example@gmail.com" type="email" name="email" v-model="data.email" :error="data__errors.email[0]"/>
                <div class="flex flex-col gap-[3px]">
                    <InputGroup label="Пароль" placeholder="*******" type="password" :error="data__errors.password[0]" v-model="data.password"/>
                    <a href="/" class="text-right text-xs underline opacity-[60%]">Забыли пароль?</a>
                </div>
            </div>

            <div class="flex flex-col gap-[5px]">
                <Button v-on:click="action()">
                    <div>{{ actionLoading ? 'Авторизация...' : 'Авторизоваться' }}</div>
                </Button>
                <div class="text-sm text-right">Нет аккаунта? 
                    <router-link to="/register" class="underline">Зарегистрироваться</router-link>
                </div>
            </div>
        </div>
    </div>
    
</template>