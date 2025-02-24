<script setup>
    import Button from '@/components/UI/Button.vue';
    import Dots from '@/components/Icons/dots.vue';
    import Delete from '@/components/Icons/delete.vue';
    import Edit from '@/components/Icons/edit.vue';

    import { ref } from 'vue';

    defineProps({
        uuid: String,
        datetime: Date,
        address_from: String,
        address_to: String,
        cargo: String,
        deadline: Date,
    });

    const show_modal = ref(false);
    const show_modal2 = ref(false);

    const hideModal = () => {
        show_modal.value = false;
        show_modal2.value = false;
    };

    const hideModal2 = () => {
        setTimeout(() => {
            show_modal.value = false;
        }, 100);
    };
</script>

<template>
    <div class="mt-6 text-2xl font-bold">Ваши сотрудники</div>

    <hr class="border-gray-300 my-[24px]">

    <div class="flex items-center justify-end">
        <router-link to="/me/employees/new" class="text-sm bg-dark-999 text-white py-[6px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
            Добавить сотрудника
        </router-link>
    </div>


    <div class="mt-6">
        <div class="flex flex-col gap-3 ">
            <div class="text-xs opacity-[60%]">1-10 из 74 записей</div>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="text-xs font-normal py-3 text-left">ФИО</th>
                        <th class="text-xs font-normal py-3 text-left">Электронная почта</th>
                        <th class="text-xs font-normal py-3 text-left">Должность</th>
                        <th class="text-xs font-normal py-3 border-b-1 border-gray-300 text-left">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-xs font-normal py-2 border-t-1 border-gray-300">Ивано Иван Иванович</td>
                        <td class="text-xs font-normal py-2 border-t-1 border-gray-300">ivanov@gmail.com</td>
                        <td class="text-xs font-normal py-2 border-t-1 border-gray-300">Водитель</td>
                        <td class="text-xs font-normal py-2 flex">
                            <div class="relative">
                                <div 
                                    class="hover:cursor-pointer hover:bg-dark-50/70 p-1 rounded-[6px]"
                                    @mouseover="show_modal = true"
                                    @mouseleave="hideModal2">
                                    <Dots />
                                </div>
                                <div 
                                    v-if="show_modal || show_modal2" 
                                    @mouseover="show_modal2 = true" 
                                    @mouseleave="hideModal" 
                                    class="absolute flex flex-col bg-white top-[35px] right-0 p-[3px] rounded-[5px] gap-[10px] border border-gray-300">
                                    <div class="flex items-center gap-[5px] py-[3px] px-[6px] hover:cursor-pointer hover:bg-dark-50/70 rounded-[3px]">
                                        <Edit />
                                        <div class="text-sm">Редактировать</div>
                                    </div>
                                    <hr class="border-gray-300">
                                    <div class="flex items-center gap-[5px] py-[3px] px-[6px] hover:cursor-pointer hover:bg-red-100 rounded-[3px]">
                                        <Delete />
                                        <div class="text-sm">Удалить</div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>