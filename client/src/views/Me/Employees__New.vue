<script setup>
    import Button from '@/components/UI/Button.vue';
    import Dots from '@/components/Icons/dots.vue';
    import Delete from '@/components/Icons/delete.vue';
    import Edit from '@/components/Icons/edit.vue';
    import Copy from '@/components/Icons/copy-large.vue';
    import InputGroup from '@/components/UI/InputGroup.vue'

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
    <!-- <div class="mt-6 text-2xl font-bold">Ваши сотрудники</div> -->
     <div class="mt-6 flex items-center justify-between">
        <div>
            <div class="text-2xl font-bold">Сотрудник</div>
            <div class="text-xs">Добавление нового сотрудника</div>
        </div>
        <div class="flex items-center gap-[10px]">
            <router-link to="/me/employees" class="text-sm border border-dark-50 py-[6px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
                <div class="flex items-center gap-[10px]">
                    <Delete/>
                    <div>Отмена</div>
                </div>
            </router-link>
            <button type="button" class="text-sm bg-sky-400 text-white py-[6px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
                <div class="flex items-center gap-[10px]">
                    <Edit color="#FFF"/>
                    <div>Сохранить</div>
                </div>
            </button>
        </div>
     </div>

    <hr class="border-gray-300 my-[24px]">

    <div class="mt-6">
        <div class="grid grid-cols-12 gap-5">
            <div class="col-span-4">
                <div class="text-base">Основная информация</div>
                <hr class="border-gray-300 my-3">
                <div class="flex flex-col gap-6">
                    <InputGroup label="Фамилия" placeholder="Иванов"/>
                    <InputGroup label="Имя" placeholder="Иван"/>
                    <InputGroup label="Отчество" placeholder="Иванович"/>
                    <div class="flex flex-col gap-[5px] w-full">
                        <label class="text-sm opacity-[60%]">Должность</label>
                        <select name="" id="" class="text-sm w-full border border-gray-300 focus:border-gray-700 bg-dark-100 py-[6px] px-[9px] rounded-[6px]">
                            <option value="2">Логист</option>
                            <option value="3">Менеджер</option>
                            <option value="4">Водитель</option>
                        </select>
                    </div>
                </div>

                <div class="text-base mt-6">Личный кабинет</div>
                <hr class="border-gray-300 my-3">
                <div>
                    <InputGroup label="Пароль" placeholder="******"/>
                    <div>
                        <button type="button" class="text-sm bg-dark-999 text-white py-[6px] px-[9px] rounded-[6px] w-auto hover:cursor-pointer">
                            <div class="flex items-center gap-[10px]">
                                <Copy/>
                            </div>
                        </button type="button">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>