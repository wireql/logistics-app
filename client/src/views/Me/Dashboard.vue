<script setup>
import Cars from '@/components/Icons/cars.vue';
import Employees from '@/components/Icons/employees.vue';
import Home from '@/components/Icons/home.vue';
import Notify from '@/components/Icons/notify.vue';
import Quit from '@/components/Icons/quit.vue';
import Settings from '@/components/Icons/settings.vue';
import SideDashboard from '@/components/Icons/sideDashboard.vue';
import Tasks from '@/components/Icons/tasks.vue';
</script>

<template>
    <div class="border-1 border-white border-r-gray-300 max-w-[250px] flex flex-col justify-between h-screen p-4">
        <div>
            <div class="flex flex-row items-center justify-between">
                <div class="font-bold text-2xl">Logistics</div>
                <SideDashboard />
            </div>
            <hr class="border-gray-300 my-[30px]">
            <div class="flex flex-col gap-[30px]">
                <div class="flex flex-col">
                    <div class="flex flex-row items-center gap-[15px] p-2 rounded-[12px] hover:bg-dark-50/70 hover:cursor-pointer">
                        <Home />
                        <div class="text-sm font-bold">Главная</div>
                    </div>
                    <div class="flex flex-row items-center gap-[15px] p-2 rounded-[12px] hover:bg-dark-50/70 hover:cursor-pointer">
                        <Notify />
                        <div class="text-sm font-bold">Уведомления</div>
                    </div>
                </div>

                <div class="flex flex-col">
                    <div class="text-sm mb-[15px]">Основное</div>

                    <div class="flex flex-row items-center gap-[15px] p-2 rounded-[12px] hover:bg-dark-50/70 hover:cursor-pointer">
                        <Tasks />
                        <div class="text-sm font-bold">Задачи</div>
                    </div>
                    <div class="flex flex-row items-center gap-[15px] p-2 rounded-[12px] hover:bg-dark-50/70 hover:cursor-pointer">
                        <Employees />
                        <div class="text-sm font-bold">Сотрудники</div>
                    </div>
                    <div class="flex flex-row items-center gap-[15px] p-2 rounded-[12px] hover:bg-dark-50/70 hover:cursor-pointer">
                        <Cars />
                        <div class="text-sm font-bold">Автомобили</div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="flex flex-col gap-4 bg-dark-999 p-4 rounded-[12px] mb-[20px]">
                <div class="text-white font-bold text-sm">Заголовок</div>
                <div class="text-white text-xs">Какая-то важная или интересная информация будет здесь</div>
            </div>

            <div class="flex flex-col">
                <div class="flex flex-row items-center gap-[15px] p-2 rounded-[12px] hover:bg-dark-50/70 hover:cursor-pointer">
                    <Settings />
                    <div class="text-sm font-bold">Настройки</div>
                </div>
                <div class="flex flex-row items-center gap-[15px] p-2 rounded-[12px] hover:bg-dark-50/70 hover:cursor-pointer">
                    <Quit />
                    <div class="text-sm font-bold">Выход</div>
                </div>
            </div>

            <hr class="border-gray-300 my-[30px]">

            <div class="flex items-center gap-[15px]">
                <div class="w-[24px] h-[24px] rounded-full bg-dark-50"></div>
                <div class="flex flex-col gap-[5px]">
                    <div class="text-sm font-bold">Дмитрий Батькович</div>
                    <div class="text-xs">email@email.ru</div>
                </div>
            </div>
        </div>
    </div>
</template>