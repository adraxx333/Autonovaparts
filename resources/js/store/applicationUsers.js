import { defineStore } from 'pinia';
import axios from 'axios';
import { ref } from 'vue';

export const useApplicationUsersStore = defineStore('applicationUsers', () => {
    // Inicializar currentUser desde localStorage si existe
    const currentUser = ref(JSON.parse(localStorage.getItem('user')) || null);
    const isLoading = ref(false);
    const error = ref('');

    // Función para actualizar el usuario y guardarlo en localStorage
    const setUser = (user) => {
        currentUser.value = user;
        if (user) {
            localStorage.setItem('user', JSON.stringify(user));
        } else {
            localStorage.removeItem('user');
        }
    };

    const login = async ({ email, password }) => {
        try {
            isLoading.value = true;
            error.value = '';
            const response = await axios.post('/api/login', { email, password });
            console.log('Respuesta del login:', response.data);
            setUser(response.data.user);
            return response;
        } catch (err) {
            error.value = err.response?.data?.message || 'Error al iniciar sesión';
            throw err;
        } finally {
            isLoading.value = false;
        }
    };

    const register = async ({ name, email, password, password_confirmation }) => {
        try {
            isLoading.value = true;
            error.value = '';
            const response = await axios.post('/api/register', {
                name,
                email,
                password,
                password_confirmation,
            });
            console.log('Respuesta del registro:', response.data);
            setUser(response.data.user);
            return response;
        } catch (err) {
            error.value = err.response?.data?.message || 'Error al registrarse';
            throw err;
        } finally {
            isLoading.value = false;
        }
    };

    // Función para cerrar sesión
    const logout = () => {
        setUser(null);
    };

    // Función para verificar si hay un usuario logueado
    const checkAuth = () => {
        console.log('Estado actual del usuario:', currentUser.value);
        return currentUser.value !== null;
    };

    return {
        currentUser,
        isLoading,
        error,
        login,
        register,
        logout,
        checkAuth,
    };
});
