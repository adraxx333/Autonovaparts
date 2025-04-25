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
                        <v-form class="flex flex-1 flex-col justify-between gap-8 overflow-auto">
                            <div class="flex-none">
                                <v-text-field
                                    v-model="email"
                                    color="primary"
                                    label="Correo electrónico"
                                    type="email"
                                    required
                                    class="mt-2"
                                    variant="outlined"
                                    prepend-inner-icon="mdi-email"
                                    :rules="emailRules"
                                    placeholder="ejemplo@correo.com"
                                    density="comfortable"
                                ></v-text-field>
                                <v-text-field
                                    v-model="password"
                                    color="primary"
                                    label="Contraseña"
                                    :type="showPassword ? 'text' : 'password'"
                                    required
                                    variant="outlined"
                                    class="mt-12 sm:mt-6"
                                    prepend-inner-icon="mdi-lock"
                                    :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                    @click:append-inner="showPassword = !showPassword"
                                    :rules="passwordRules"
                                    placeholder="••••••••"
                                    density="comfortable"
                                ></v-text-field>

                                <div class="mt-1 flex items-end justify-end">
                                    <a href="#" class="text-primary text-sm hover:text-blue-700"> ¿Olvidaste tu contraseña? </a>
                                </div>
                            </div>

                            <!-- Botón -->
                            <div class="flex-none">
                                <v-btn type="submit" color="primary" block size="large" elevation="2" :loading="isLoading" min-height="44">
                                    <v-icon left class="mr-2">mdi-login</v-icon>
                                    Iniciar Sesión
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

// DATA
const imageTitle = ref('/images/autonovaparts_title.jpg');
const email = ref('');
const password = ref('');
const remember = ref(false);
const showPassword = ref(false);
const isLoading = ref(false);

// Reglas de validación
const emailRules = [(v) => !!v || 'El correo es requerido', (v) => /.+@.+\..+/.test(v) || 'El correo debe ser válido'];

const passwordRules = [(v) => !!v || 'La contraseña es requerida', (v) => v?.length >= 6 || 'La contraseña debe tener al menos 6 caracteres'];

const handleLogin = async () => {
    try {
        isLoading.value = true;
        // Simular tiempo de carga
        await new Promise((resolve) => setTimeout(resolve, 1000));

        console.log('Iniciando sesión...', {
            email: email.value,
            password: password.value,
            remember: remember.value,
        });
    } catch (error) {
        console.error('Error al iniciar sesión:', error);
    } finally {
        isLoading.value = false;
    }
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
