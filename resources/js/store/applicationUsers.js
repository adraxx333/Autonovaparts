import { defineStore } from 'pinia';
import axios from 'axios';
import { ref } from 'vue';

export const useApplicationUsersStore = defineStore('applicationUsers', () => {
    // Inicializar currentUser desde localStorage si existe
    const currentUser = ref(JSON.parse(localStorage.getItem('user')) || null);
    const isLoading = ref(false);
    const error = ref('');

    // Configurar axios para incluir el token en todas las peticiones
    const setupAxiosInterceptors = () => {
        const token = localStorage.getItem('token');
        if (token) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
    };

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
            // Guardar el token
            if (response.data.token) {
                localStorage.setItem('token', response.data.token);
                setupAxiosInterceptors();
            }
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
            // Guardar el token
            if (response.data.token) {
                localStorage.setItem('token', response.data.token);
                setupAxiosInterceptors();
            }
            return response;
        } catch (err) {
            error.value = err.response?.data?.message || 'Error al registrarse';
            throw err;
        } finally {
            isLoading.value = false;
        }
    };

    // Función para cerrar sesión
    const logout = async () => {
        try {
            isLoading.value = true;
            error.value = '';
            const response = await axios.post('/api/logout');
            console.log('Respuesta del servidor:', response.data); // Para debug

            // Limpiar el usuario y cualquier token almacenado
            setUser(null);
            localStorage.removeItem('user');
            localStorage.removeItem('token');
            delete axios.defaults.headers.common['Authorization'];

            return response.data;
        } catch (err) {
            console.error('Error en logout:', err); // Para debug
            error.value = err.response?.data?.message || 'Error al cerrar sesión';
            throw err;
        } finally {
            isLoading.value = false;
        }
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
