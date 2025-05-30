<template>
    <div>
        <!-- Modal con formulario -->
        <v-dialog v-model="dialog" max-width="500px" persistent>
            <v-card>
                <v-card-title class="d-flex justify-space-between align-center pa-4">
                    Formulario de Contacto
                    <v-btn icon @click="closeDialog">
                        <v-icon icon="mdi-close" />
                    </v-btn>
                </v-card-title>

                <v-divider></v-divider>

                <v-card-text class="pa-4">
                    <v-form ref="form" v-model="isFormValid" @submit.prevent="handleSubmit">
                        <!-- Información del usuario (solo lectura) -->
                        <div class="mb-6">
                            <div class="text-subtitle-2 text-grey mb-4">Información de contacto</div>
                            <v-text-field
                                v-model="formData.name"
                                label="Tu correo electrónico"
                                variant="outlined"
                                readonly
                                density="comfortable"
                                class="mb-6"
                                hint="Este es el correo desde el que envías el mensaje"
                                persistent-hint
                                :model-value="userEmail"
                            ></v-text-field>
                            <v-text-field
                                :model-value="companyEmail"
                                label="Correo electrónico de contacto"
                                variant="outlined"
                                readonly
                                density="comfortable"
                                hint="Este es el correo al que se enviará tu mensaje"
                                persistent-hint
                            ></v-text-field>
                        </div>

                        <!-- Campo de mensaje -->
                        <v-textarea
                            v-model="formData.message"
                            label="Mensaje"
                            :rules="messageRules"
                            required
                            variant="outlined"
                            rows="4"
                            class="mb-4"
                            placeholder="Escribe tu mensaje aquí..."
                            auto-grow
                        ></v-textarea>
                    </v-form>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions class="pa-4">
                    <v-spacer></v-spacer>
                    <v-btn color="grey-darken-1" variant="text" @click="closeDialog" class="mr-2"> Cancelar </v-btn>
                    <v-btn color="primary" :loading="loading" :disabled="!isFormValid" @click="handleSubmit"> Enviar Mensaje </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- Snackbar para mensajes -->
        <v-snackbar v-model="snackbar.show" :color="snackbar.color" :timeout="3000">
            {{ snackbar.text }}
        </v-snackbar>
    </div>
</template>

<script setup>
import { ref, reactive, watch, computed } from 'vue';
import { useApplicationUsersStore } from '@/store/applicationUsers';
import axios from 'axios';

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['update:modelValue']);
const applicationUsers = useApplicationUsersStore();

// Estado del modal
const dialog = ref(false);
const loading = ref(false);
const isFormValid = ref(false);
const form = ref(null);

// Estado del formulario
const formData = reactive({
    name: '',
    email: 'autonova@autonova.es',
    message: '',
});

// Computed para el email del usuario
const userEmail = computed(() => {
    const email = applicationUsers.currentUser?.email;
    console.log('Email del usuario:', email);
    return email || '';
});

// Computed para el email de la compañía
const companyEmail = computed(() => 'autonova@autonova.es');

// Verificar si el usuario está autenticado
const isAuthenticated = computed(() => {
    return applicationUsers.checkAuth();
});

// Estado del snackbar
const snackbar = reactive({
    show: false,
    text: '',
    color: 'success',
});

// Reglas de validación
const messageRules = [(v) => !!v || 'El mensaje es obligatorio', (v) => v.length >= 10 || 'El mensaje debe tener al menos 10 caracteres'];

// Función para cerrar el diálogo
const closeDialog = () => {
    dialog.value = false;
    emit('update:modelValue', false);
    form.value?.reset();
};

// Sincronizar el diálogo con la prop
watch(
    () => props.modelValue,
    (newValue) => {
        dialog.value = newValue;
        if (newValue) {
            if (!isAuthenticated.value) {
                snackbar.color = 'error';
                snackbar.text = 'Debes iniciar sesión para usar el formulario de contacto';
                snackbar.show = true;
                closeDialog();
                return;
            }
            console.log('Abriendo modal, usuario:', applicationUsers.currentUser);
            formData.name = userEmail.value;
        }
    },
    { immediate: true },
);

// Función para manejar el envío del formulario
const handleSubmit = async () => {
    if (!form.value.validate()) return;

    loading.value = true;

    try {
        await axios.post('/messages', {
            message: formData.message,
        });

        // Mostrar mensaje de éxito
        snackbar.color = 'success';
        snackbar.text = '¡Mensaje enviado con éxito!';
        snackbar.show = true;

        // Cerrar modal y resetear formulario
        closeDialog();
    } catch (error) {
        // Mostrar mensaje de error
        snackbar.color = 'error';
        snackbar.text = error.response?.data?.message || 'Error al enviar el mensaje. Por favor, intente nuevamente.';
        snackbar.show = true;
    } finally {
        loading.value = false;
    }
};
</script>

<style scoped>
.v-card {
    border-radius: 4px;
}

.v-btn {
    text-transform: none;
}

.v-text-field.v-field--readonly {
    opacity: 0.8;
}
</style>
