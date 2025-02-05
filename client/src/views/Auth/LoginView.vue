<script setup>
    import InputGroup from '../../components/UI/InputGroup.vue'
    import Button from '../../components/UI/Button.vue'
</script>

<template>
    
    <div class="flex justify-center mt-[100px]">
        <div class="flex flex-col gap-6 max-w-[300px] w-full">
            <div class="flex flex-col gap-[5px]">
                <div class="font-bold text-2xl">Авторизация</div>
                <div class="text-sm">С возвращением!</div>
            </div>

            <div class="flex flex-col gap-6">
                <InputGroup label="Электронная почта" placeholder="example@gmail.com" type="email" name="email"/>
                <div class="flex flex-col gap-[3px]">
                    <InputGroup label="Пароль" placeholder="*******" type="password"/>
                    <a href="/" class="text-right text-xs underline opacity-[60%]">Забыли пароль?</a>
                </div>
            </div>

            <div class="flex flex-col gap-[5px]">
                <Button>Авторизоваться</Button>
                <div class="text-sm text-right">Нет аккаунта? 
                    <router-link to="/register" class="underline">Зарегистрироваться</router-link>
                </div>
            </div>
        </div>
    </div>
    
</template>