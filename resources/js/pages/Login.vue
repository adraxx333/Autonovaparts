<template>
    <v-app>
        <v-main>
            <div class="flex h-screen w-full items-center justify-center bg-gradient-to-br from-black to-blue-900 p-6 lg:p-20">
                <div class="flex h-full w-full flex-col items-center gap-8 bg-white sm:h-auto sm:w-[700px] sm:rounded-xl sm:shadow-2xl">
                    <div class="flex w-full flex-col items-center justify-around">
                        <img :src="imageTitle" class="h-32 w-auto object-contain" alt="AutonovaParts" />
                        <h2 class="text-2xl font-bold text-gray-800">Tu Socio en Repuestos</h2>
                        <p class="mt-2 text-sm text-gray-600">Calidad y Confianza en Cada Pieza</p>
                    </div>
                    <v-divider class="w-full border-black" :thickness="1"></v-divider>
                    <div class="flex h-full w-full flex-col px-4 py-6 sm:px-6 sm:py-6">
                        <v-form @submit.prevent="handleLogin" class="flex flex-1 flex-col justify-between gap-8 overflow-auto">
                            <div class="flex-none">
                                <v-text-field
                                    v-if="!isLogin"
                                    v-model="name"
                                    color="primary"
                                    ref="nameInput"
                                    label="Nombre de usuario"
                                    type="input"
                                    required
                                    class="mt-2"
                                    variant="outlined"
                                    prepend-inner-icon="mdi-account"
                                    :rules="nameRules"
                                    placeholder="Nombre de usuario"
                                    density="comfortable"
                                ></v-text-field>

                                <v-text-field
                                    v-model="email"
                                    color="primary"
                                    ref="emailInput"
                                    label="Correo electrónico"
                                    type="email"
                                    required
                                    :class="[isLogin ? 'mt-2' : 'mt-8', 'sm:mt-6']"
                                    variant="outlined"
                                    prepend-inner-icon="mdi-email"
                                    :rules="emailRules"
                                    placeholder="ejemplo@correo.com"
                                    density="comfortable"
                                ></v-text-field>

                                <v-text-field
                                    v-model="password"
                                    color="primary"
                                    ref="passwordInput"
                                    label="Contraseña"
                                    :type="showPassword ? 'text' : 'password'"
                                    required
                                    variant="outlined"
                                    :class="[isLogin ? 'mt-12' : 'mt-8', 'sm:mt-6']"
                                    prepend-inner-icon="mdi-lock"
                                    :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                    @click:append-inner="showPassword = !showPassword"
                                    :rules="passwordRules"
                                    placeholder="••••••••"
                                    density="comfortable"
                                ></v-text-field>

                                <v-text-field
                                    v-if="!isLogin"
                                    v-model="confirmPassword"
                                    color="primary"
                                    ref="confirmPassInput"
                                    label="Confirma contraseña"
                                    :type="showConfirmPassword ? 'text' : 'password'"
                                    required
                                    variant="outlined"
                                    :class="[isLogin ? 'mt-12' : 'mt-8', 'sm:mt-6']"
                                    prepend-inner-icon="mdi-lock"
                                    :append-inner-icon="showConfirmPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                    @click:append-inner="showConfirmPassword = !showConfirmPassword"
                                    :rules="confirmPasswordRules"
                                    placeholder="••••••••"
                                    density="comfortable"
                                ></v-text-field>

                                <div class="mt-1 flex items-end justify-end">
                                    <a href="#" @click="changeAuth" class="text-primary text-sm hover:text-blue-700">
                                        {{ isLogin ? '¿No tienes cuenta? Registrate' : '¿Ya tienes cuenta? Inicia sesión' }}
                                    </a>
                                </div>
                            </div>
                            <v-alert v-if="error" :text="error" type="error"></v-alert>
                            <!-- Botón -->
                            <div class="flex-none">
                                <v-btn
                                    type="submit"
                                    color="primary"
                                    block
                                    size="large"
                                    elevation="2"
                                    :loading="applicationUsers.isLoading"
                                    min-height="44"
                                >
                                    <v-icon left class="mr-2">mdi-login</v-icon>
                                    {{ isLogin ? 'Iniciar Sesión' : 'Registarse' }}
                                </v-btn>
                            </div>
                        </v-form>
                    </div>
                </div>
            </div>
        </v-main>
    </v-app>
</template>

<script setup>
import { ref } from 'vue';
import { useApplicationUsersStore } from '@/store/applicationUsers';

// DATA
const imageTitle = ref('/images/autonovaparts_title.jpg');
const email = ref('');
const name = ref('');
const error = ref('');
const password = ref('');
const confirmPassword = ref('');
const showPassword = ref(false);
const showConfirmPassword = ref('');
const isLogin = ref(true);
const applicationUsers = useApplicationUsersStore();

// Refs para los campos de Vuetify
const emailInput = ref(null);
const passwordInput = ref(null);
const nameInput = ref(null);

// Reglas de validación
const emailRules = [(v) => !!v || 'El nombre de usuario es requerido', (v) => /.+@.+\..+/.test(v) || 'El correo debe ser válido'];
const nameRules = [(v) => !!v || 'El nombre de usuario es requerido', (v) => (v && v.length >= 3) || 'Debe tener al menos 3 caracteres'];
const passwordRules = [(v) => !!v || 'La contraseña es requerida', (v) => v?.length >= 6 || 'La contraseña debe tener al menos 6 caracteres'];
const confirmPasswordRules = [
    (v) => !!v || 'La contraseña es requerida',
    (v) => v?.length >= 6 || 'La contraseña debe tener al menos 6 caracteres',
    (v) => v === password.value || 'La contraseña no coincide',
];

const handleLogin = async () => {
    try {
        error.value = '';
        let response;

        if (isLogin.value) {
            response = await applicationUsers.login({
                email: email.value,
                password: password.value,
            });
        } else {
            response = await applicationUsers.register({
                name: name.value,
                email: email.value,
                password: password.value,
                password_confirmation: confirmPassword.value,
            });
        }

        if (response.data.success) {
            error.value = '';
            window.location.href = response.data.redirect;
        }
    } catch (err) {
        if (err.response?.data?.errors) {
            const errors = err.response.data.errors;
            if (errors.error) {
                error.value = errors.error[0];
            }
        } else {
            error.value = applicationUsers.error;
        }
    }
};

const changeAuth = () => {
    isLogin.value = !isLogin.value;
    email.value = '';
    password.value = '';
    name.value = '';
    error.value = '';
    showPassword.value = false;
    confirmPassword.value = '';

    // Limpiar reglas si el campo existe
    emailInput.value?.resetValidation();
    passwordInput.value?.resetValidation();
    nameInput.value?.resetValidation();
};
</script>

<style scoped>
.v-application {
    background: transparent !important;
}

/* Ajustes para móviles */
@media (max-width: 640px) {
    .v-text-field {
        font-size: 14px;
    }

    .v-btn {
        height: 48px;
    }

    .v-checkbox {
        margin-top: 0;
    }
}

/* Mejoras visuales generales */
.v-text-field.v-text-field--outlined .v-field__outline {
    border-radius: 8px;
}

.v-btn {
    text-transform: none;
    letter-spacing: 0.5px;
    font-weight: 500;
}
</style>
