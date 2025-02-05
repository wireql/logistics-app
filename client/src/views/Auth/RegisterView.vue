<script setup>
    import InputGroup from '../../components/UI/InputGroup.vue'
    import Button from '../../components/UI/Button.vue'
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
                    <InputGroup label="Фамилия" placeholder="Иванов"/>
                    <InputGroup label="Имя" placeholder="Иван"/>
                </div>
                <InputGroup label="Название компании" placeholder="ООО “СуперКомпани”"/>
                <InputGroup label="Электронная почта" placeholder="example@gmail.com" type="email" name="email"/>
                <InputGroup label="Пароль" placeholder="*******" type="password"/>
                <InputGroup label="Повтор пароля" placeholder="******" type="password"/>
            </div>

            <div class="flex flex-col gap-[5px]">
                <Button>Зарегистрироваться</Button>
                <div class="text-sm text-right">Есть аккаунт? 
                    <router-link to="/login" class="underline">Авторизоваться</router-link>
                </div>
            </div>
        </div>
    </div>
    
</template>