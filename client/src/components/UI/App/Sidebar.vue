<script setup>
import router from '@/router';
import { logoutUser } from '@/api/User';
import { ref } from 'vue';

import Cars from '@/components/Icons/cars.vue';
import Employees from '@/components/Icons/employees.vue';
import Home from '@/components/Icons/home.vue';
import Notify from '@/components/Icons/notify.vue';
import Quit from '@/components/Icons/quit.vue';
import Settings from '@/components/Icons/settings.vue';
import Tasks from '@/components/Icons/tasks.vue';

import { useAuthStore } from '@/stores/auth';
import Address from '@/components/Icons/address.vue';
import Logo from './Sidebar/Logo.vue';
import ButtonLink from './Sidebar/ButtonLink.vue';
import NotificationBlock from './Sidebar/NotificationBlock.vue';
import UserInformation from './Sidebar/UserInformation.vue';

const logoutLoading = ref(false);

const authStore = useAuthStore();

const logout = async () => {
    logoutLoading.value = true;

    try {
        const response = await logoutUser(authStore.token);

        authStore.logout();
        router.push('/login');
    } catch (err) {
        authStore.logout();
        router.push('/login');
    } finally {
        logoutLoading.value = false;
    }
};
</script>

<template>
    <div
        class="border-1 border-white border-r-gray-300 w-auto lg:max-w-[250px] flex flex-col justify-between h-full p-4"
    >
        <div>
            <div class="flex flex-row items-center justify-between">
                <Logo />
            </div>

            <hr class="border-gray-300 my-[30px]" />

            <div class="flex flex-col gap-[30px]">
                <div class="flex flex-col">
                    <ButtonLink :path="{ name: 'Dashboard' }" title="Главная">
                        <Home />
                    </ButtonLink>

                    <ButtonLink
                        :path="{ name: 'Dashboard' }"
                        title="Уведомления"
                    >
                        <Notify />
                    </ButtonLink>
                </div>

                <div class="flex flex-col">
                    <div class="text-sm mb-[15px] hidden lg:block">
                        Основное
                    </div>

                    <ButtonLink
                        :path="{ name: 'RouteListsIndex' }"
                        title="Маршрутные листы"
                    >
                        <Tasks />
                    </ButtonLink>
                    <ButtonLink
                        :path="{ name: 'EmployeesIndex' }"
                        title="Сотрудники"
                    >
                        <Employees />
                    </ButtonLink>
                    <ButtonLink
                        :path="{ name: 'VehiclesIndex' }"
                        title="Автомобили"
                    >
                        <Cars />
                    </ButtonLink>
                    <ButtonLink :path="{ name: 'AddressIndex' }" title="Адреса">
                        <Address color="#212529" />
                    </ButtonLink>
                </div>
            </div>
        </div>

        <div>
            <NotificationBlock />

            <div class="flex flex-col">
                <ButtonLink :path="{ name: 'Dashboard' }" title="Настройки">
                    <Settings />
                </ButtonLink>
                <ButtonLink
                    v-on:click="logout()"
                    :title="logoutLoading ? 'Выходим...' : 'Выход'"
                >
                    <Quit />
                </ButtonLink>
            </div>

            <hr class="border-gray-300 my-[30px]" />

            <UserInformation :data="authStore.user" />
        </div>
    </div>
</template>
