<script setup>
    import InputGroup from '../../components/UI/InputGroup.vue'
    import Button from '../../components/UI/Button.vue'
    import { ref } from 'vue';
    import { loginUser } from '@/api/User';
    import { notify } from "@kyvg/vue3-notification";

    import { useAuthStore } from '@/stores/auth';
    import router from '@/router';

    const authStore = useAuthStore();

    const data = ref({
        email: null,
        password: null,
    })

    const data__errors = ref({
        email: [],
        password: [],
    });
    const actionLoading = ref(false);

    const action = () => {
        actionLoading.value = true;

        data__errors.value = {
            email: [],
            password: [],
        }

        loginUser(data.value).then(res => {
            notify({
                title: "Авторизация",
                text: "Вы успешно авторизировались!",
                type: 'success'
            });
            actionLoading.value = false;

            authStore.setUser(res.data.data.user)
            authStore.setToken(res.data.data.token)
            router.push('/me');
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
                    <div v-if="!actionLoading">Авторизоваться</div>
                    <div v-else>Обработка...</div>
                </Button>
                <div class="text-sm text-right">Нет аккаунта? 
                    <router-link to="/register" class="underline">Зарегистрироваться</router-link>
                </div>
            </div>
        </div>
    </div>
    
</template>