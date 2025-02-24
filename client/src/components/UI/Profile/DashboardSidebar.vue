<script setup>
    import { logoutUser } from '@/api/User';
    import Cars from '@/components/Icons/cars.vue';
    import Employees from '@/components/Icons/employees.vue';
    import Home from '@/components/Icons/home.vue';
    import Notify from '@/components/Icons/notify.vue';
    import Quit from '@/components/Icons/quit.vue';
    import Settings from '@/components/Icons/settings.vue';
    import SideDashboard from '@/components/Icons/sideDashboard.vue';
    import Tasks from '@/components/Icons/tasks.vue';
    import router from '@/router';

    import { useAuthStore } from '@/stores/auth';

    const authStore = useAuthStore()

    const logout = () => {
        logoutUser(authStore.token).then(res => {
            authStore.logout()
            router.push('/login')
        }).catch(err => {
            authStore.logout()
            router.push('/login')
        })
    }
</script>

<template>
    <div class="border-1 border-white border-r-gray-300 w-auto lg:max-w-[250px] flex flex-col justify-between h-full p-4">
        <div>
            <div class="flex flex-row items-center justify-between">
                <div class="font-bold text-2xl hidden lg:block">Logistics App</div>
                <!-- <SideDashboard /> -->
            </div>
            <hr class="border-gray-300 my-[30px]">
            <div class="flex flex-col gap-[30px]">
                <div class="flex flex-col">
                    <router-link to="/me" class="flex flex-row items-center gap-[15px] p-2 rounded-[12px] hover:bg-dark-50/70 hover:cursor-pointer">
                        <Home />
                        <div class="text-sm font-bold hidden lg:block">Главная</div>
                    </router-link>
                    <div class="flex flex-row items-center gap-[15px] p-2 rounded-[12px] hover:bg-dark-50/70 hover:cursor-pointer">
                        <Notify />
                        <div class="text-sm font-bold hidden lg:block">Уведомления</div>
                    </div>
                </div>

                <div class="flex flex-col">
                    <div class="text-sm mb-[15px] hidden lg:block">Основное</div>

                    <router-link to="/me/tasks" class="flex flex-row items-center gap-[15px] p-2 rounded-[12px] hover:bg-dark-50/70 hover:cursor-pointer">
                        <Tasks />
                        <div class="text-sm font-bold hidden lg:block">Задачи</div>
                    </router-link>
                    <router-link to="/me/employees" class="flex flex-row items-center gap-[15px] p-2 rounded-[12px] hover:bg-dark-50/70 hover:cursor-pointer">
                        <Employees />
                        <div class="text-sm font-bold hidden lg:block">Сотрудники</div>
                    </router-link>
                    <div class="flex flex-row items-center gap-[15px] p-2 rounded-[12px] hover:bg-dark-50/70 hover:cursor-pointer">
                        <Cars />
                        <div class="text-sm font-bold hidden lg:block">Автомобили</div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="flex-col gap-4 bg-dark-999 p-4 rounded-[12px] mb-[20px] hidden lg:flex">
                <div class="text-white font-bold text-sm">Заголовок</div>
                <div class="text-white text-xs">Какая-то важная или интересная информация будет здесь</div>
            </div>

            <div class="flex flex-col">
                <div class="flex flex-row items-center gap-[15px] p-2 rounded-[12px] hover:bg-dark-50/70 hover:cursor-pointer">
                    <Settings />
                    <div class="text-sm font-bold hidden lg:block">Настройки</div>
                </div>
                <div class="flex flex-row items-center gap-[15px] p-2 rounded-[12px] hover:bg-dark-50/70 hover:cursor-pointer" v-on:click="logout()">
                    <Quit />
                    <div class="text-sm font-bold hidden lg:block">Выход</div>
                </div>
            </div>

            <hr class="border-gray-300 my-[30px]">

            <div class="flex items-center justify-center lg:gap-[15px]">
                <div class="w-[24px] h-[24px] rounded-full bg-dark-50"></div>
                <div class="flex flex-col gap-[5px] hidden lg:block">
                    <div class="text-sm font-bold">{{ authStore.user.first_name }} {{ authStore.user.last_name }}</div>
                    <div class="text-xs">{{ authStore.user.email }}</div>
                </div>
            </div>
        </div>
    </div>
</template>