<template>
    <v-dialog v-model="dialog" max-width="600px">
        <v-card class="rounded-lg">
            <v-card-title class="d-flex align-center pa-4 bg-primary text-white">
                <span class="text-h5">Confirmar Pedido</span>
                <v-spacer></v-spacer>
                <v-btn icon="mdi-close" variant="text" color="white" @click="closeDialog" class="ml-2"></v-btn>
            </v-card-title>

            <v-card-text class="pa-6">
                <!-- Resumen del pedido -->
                <div class="mb-6">
                    <h3 class="text-h6 font-weight-bold mb-4">Resumen del Pedido</h3>
                    <v-list class="bg-grey-lighten-4 pa-2 rounded-lg">
                        <v-list-item v-for="item in cart.items" :key="item.id" class="mb-2 rounded-lg bg-white">
                            <template v-slot:prepend>
                                <v-img :src="item.image_url" width="50" height="50" cover class="rounded-lg"></v-img>
                            </template>

                            <v-list-item-title class="font-weight-medium">{{ item.name }}</v-list-item-title>
                            <v-list-item-subtitle class="text-primary">{{ formatPrice(item.price) }} x {{ item.quantity }}</v-list-item-subtitle>

                            <template v-slot:append>
                                <span class="font-weight-bold">{{ formatPrice(item.price * item.quantity) }}</span>
                            </template>
                        </v-list-item>
                    </v-list>
                </div>

                <v-divider class="my-6"></v-divider>

                <!-- Total -->
                <div class="d-flex justify-space-between align-center mb-6">
                    <span class="text-h6 font-weight-bold">Total:</span>
                    <span class="text-h6 font-weight-bold text-primary">{{ formatPrice(cart.totalPrice) }}</span>
                </div>

                <!-- Información de contacto -->
                <v-form ref="form" v-model="valid">
                    <h3 class="text-h6 font-weight-bold mb-4">Información de Contacto</h3>
                    <v-text-field
                        v-model="formData.email"
                        label="Email"
                        type="email"
                        :rules="[rules.required, rules.email]"
                        required
                        variant="outlined"
                        density="comfortable"
                        class="mb-3"
                    ></v-text-field>

                    <v-text-field
                        v-model="formData.phone"
                        label="Teléfono"
                        type="tel"
                        :rules="[rules.required, rules.phone]"
                        required
                        variant="outlined"
                        density="comfortable"
                        class="mb-4"
                    ></v-text-field>

                    <h3 class="text-h6 font-weight-bold mb-4">Dirección de Envío</h3>
                    <v-text-field
                        v-model="formData.name"
                        label="Nombre completo"
                        :rules="[rules.required]"
                        required
                        variant="outlined"
                        density="comfortable"
                        class="mb-3"
                    ></v-text-field>

                    <v-text-field
                        v-model="formData.address"
                        label="Dirección"
                        :rules="[rules.required]"
                        required
                        variant="outlined"
                        density="comfortable"
                        class="mb-3"
                    ></v-text-field>

                    <v-row>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.city"
                                label="Ciudad"
                                :rules="[rules.required]"
                                required
                                variant="outlined"
                                density="comfortable"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.postalCode"
                                label="Código Postal"
                                :rules="[rules.required, rules.postalCode]"
                                required
                                variant="outlined"
                                density="comfortable"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions class="pa-4">
                <v-spacer></v-spacer>
                <v-btn color="grey-darken-1" variant="text" @click="closeDialog" class="mr-2">Cancelar</v-btn>
                <v-btn color="primary" @click="confirmOrder" :loading="loading" :disabled="!valid || loading" class="px-6"> Confirmar Pedido </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref, reactive, watch } from 'vue';
import { useCartStore } from '@/store/cart';
import axios from 'axios';

const props = defineProps({
    modelValue: {
        type: Boolean,
        required: true,
    },
});

const emit = defineEmits(['update:modelValue', 'order-confirmed']);

const dialog = ref(props.modelValue);
const cart = useCartStore();
const form = ref(null);
const valid = ref(false);
const loading = ref(false);

const formData = reactive({
    email: '',
    phone: '',
    name: '',
    address: '',
    city: '',
    postalCode: '',
});

const rules = {
    required: (v) => !!v || 'Este campo es requerido',
    email: (v) => /.+@.+\..+/.test(v) || 'Email debe ser válido',
    phone: (v) => /^[0-9]{9}$/.test(v) || 'Teléfono debe ser válido',
    postalCode: (v) => /^[0-9]{5}$/.test(v) || 'Código postal debe ser válido',
};

const formatPrice = (price) => {
    return new Intl.NumberFormat('es-ES', {
        style: 'currency',
        currency: 'EUR',
    }).format(price);
};

const closeDialog = () => {
    dialog.value = false;
    emit('update:modelValue', false);
};

const confirmOrder = async () => {
    if (!form.value.validate()) return;

    loading.value = true;
    try {
        // Verificar que todos los IDs son UUIDs válidos
        const isValidUUID = (uuid) => {
            const uuidRegex = /^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i;
            return uuidRegex.test(uuid);
        };

        const orderData = {
            total_amount: cart.totalPrice,
            items: cart.items.map((item) => {
                if (!isValidUUID(item.id)) {
                    throw new Error(`ID de parte inválido: ${item.id}`);
                }
                return {
                    part_id: item.id,
                    part_name: item.name,
                    part_code: item.part_code || item.code,
                    price: parseFloat(item.price),
                    quantity: parseInt(item.quantity),
                };
            }),
            shipping_info: {
                ...formData,
            },
        };

        console.log('Enviando datos del pedido:', orderData);

        const response = await axios.post('/orders', orderData);

        if (response.status === 201) {
            cart.clearCart();
            closeDialog();
            emit('order-confirmed');
        }
    } catch (error) {
        console.error('Error al procesar el pedido:', error);
        if (error.response?.data?.errors) {
            const errorMessages = Object.values(error.response.data.errors).flat();
            alert(errorMessages.join('\n'));
        } else {
            alert(error.message || 'Error al procesar el pedido. Por favor, intente nuevamente.');
        }
    } finally {
        loading.value = false;
    }
};

watch(
    () => props.modelValue,
    (newValue) => {
        dialog.value = newValue;
    },
);

watch(dialog, (newValue) => {
    emit('update:modelValue', newValue);
});
</script>

<style scoped>
.v-card {
    border-radius: 12px;
    overflow: hidden;
}

.v-list-item {
    border-radius: 8px;
    transition: all 0.3s ease;
}

.v-list-item:hover {
    background-color: rgba(var(--v-theme-primary), 0.05);
}

.v-btn {
    text-transform: none;
    letter-spacing: normal;
}
</style>
