import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useAuthStore = defineStore('auth', () => {
    const token = ref(localStorage.getItem('token') || null);
    const user = ref(JSON.parse(localStorage.getItem('user')) || null);

    const setUser = (data) => {
        user.value = data;
        localStorage.setItem('user', JSON.stringify(data));
    };

    const setToken = (data) => {
        token.value = data;
        localStorage.setItem('token', data);
    };

    const logout = () => {
        token.value = null;
        user.value = null;

        localStorage.removeItem('token');
        localStorage.removeItem('user');
    };

    return {
        token,
        user,
        setUser,
        setToken,
        logout
    };
});
