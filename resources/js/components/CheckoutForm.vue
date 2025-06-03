<template>
    <v-form ref="form" v-model="valid" @submit.prevent="submitForm">
        <v-container>
            <v-row>
                <!-- Información de contacto -->
                <v-col cols="12" md="6">
                    <h3 class="text-h6 mb-4">Información de contacto</h3>

                    <v-text-field v-model="formData.email" label="Email" type="email" :rules="[rules.required, rules.email]" required></v-text-field>

                    <v-text-field v-model="formData.phone" label="Teléfono" type="tel" :rules="[rules.required, rules.phone]" required></v-text-field>
                </v-col>

                <!-- Información de envío -->
                <v-col cols="12" md="6">
                    <h3 class="text-h6 mb-4">Dirección de envío</h3>

                    <v-text-field v-model="formData.name" label="Nombre completo" :rules="[rules.required]" required></v-text-field>

                    <v-text-field v-model="formData.address" label="Dirección" :rules="[rules.required]" required></v-text-field>

                    <v-row>
                        <v-col cols="6">
                            <v-text-field v-model="formData.city" label="Ciudad" :rules="[rules.required]" required></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="formData.postalCode"
                                label="Código Postal"
                                :rules="[rules.required, rules.postalCode]"
                                required
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-col>

                <!-- Resumen del pedido -->
                <v-col cols="12">
                    <v-divider class="my-4"></v-divider>
                    <h3 class="text-h6 mb-4">Resumen del pedido</h3>

                    <v-list>
                        <v-list-item v-for="item in cart.items" :key="item.id">
                            <template v-slot:prepend>
                                <v-img :src="item.image_url" width="50" height="50" cover class="rounded"></v-img>
                            </template>

                            <v-list-item-title>{{ item.name }}</v-list-item-title>
                            <v-list-item-subtitle> {{ formatPrice(item.price) }} x {{ item.quantity }} </v-list-item-subtitle>

                            <template v-slot:append>
                                {{ formatPrice(item.price * item.quantity) }}
                            </template>
                        </v-list-item>
                    </v-list>

                    <v-divider class="my-4"></v-divider>

                    <div class="d-flex justify-space-between align-center">
                        <span class="text-h6">Total:</span>
                        <span class="text-h6">{{ formatPrice(cart.totalPrice) }}</span>
                    </div>
                </v-col>

                <!-- Botón de pago -->
                <v-col cols="12" class="text-center">
                    <v-btn color="primary" size="large" type="submit" :loading="loading" :disabled="!valid"> Realizar Pedido </v-btn>
                </v-col>
            </v-row>
        </v-container>
    </v-form>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { useCartStore } from '@/store/cart';

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

const submitForm = async () => {
    if (!form.value.validate()) return;

    loading.value = true;
    try {
        // Aquí implementaremos la lógica para procesar el pago
        console.log('Procesando pedido:', {
            ...formData,
            items: cart.items,
            total: cart.totalPrice,
        });

        // Simulamos un delay
        await new Promise((resolve) => setTimeout(resolve, 2000));

        // Limpiamos el carrito después del pago exitoso
        cart.clearCart();
        cart.saveCart();

        // Aquí podríamos redirigir a una página de confirmación
    } catch (error) {
        console.error('Error al procesar el pedido:', error);
    } finally {
        loading.value = false;
    }
};
</script>
