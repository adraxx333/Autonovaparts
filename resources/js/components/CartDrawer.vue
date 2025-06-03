<template>
    <v-navigation-drawer v-model="drawer" location="right" temporary width="400">
        <v-list>
            <v-list-item>
                <template v-slot:prepend>
                    <v-icon icon="mdi-cart" size="large" color="primary"></v-icon>
                </template>
                <v-list-item-title class="text-h6">Carrito de Compras</v-list-item-title>
                <template v-slot:append>
                    <v-btn icon="mdi-close" variant="text" @click="drawer = false"></v-btn>
                </template>
            </v-list-item>
        </v-list>

        <v-divider></v-divider>

        <v-list v-if="cart.items.length > 0" class="pa-4">
            <v-list-item v-for="item in cart.items" :key="item.id" class="mb-4">
                <template v-slot:prepend>
                    <v-img :src="item.image_url" width="60" height="60" cover class="rounded"></v-img>
                </template>

                <v-list-item-title class="font-weight-bold">{{ item.name }}</v-list-item-title>
                <v-list-item-subtitle class="text-primary">{{ formatPrice(item.price) }} x {{ item.quantity }}</v-list-item-subtitle>

                <template v-slot:append>
                    <div class="d-flex align-center">
                        <v-btn icon="mdi-minus" size="small" variant="text" @click="cart.updateQuantity(item.id, item.quantity - 1)"></v-btn>
                        <span class="mx-2">{{ item.quantity }}</span>
                        <v-btn
                            icon="mdi-plus"
                            size="small"
                            variant="text"
                            @click="cart.updateQuantity(item.id, item.quantity + 1)"
                            :disabled="item.quantity >= item.stock"
                        ></v-btn>
                        <v-btn icon="mdi-delete" size="small" variant="text" color="error" @click="cart.removeItem(item.id)" class="ml-2"></v-btn>
                    </div>
                </template>
            </v-list-item>
        </v-list>

        <v-list v-else class="pa-4">
            <v-list-item>
                <v-list-item-title class="text-grey text-center">El carrito está vacío</v-list-item-title>
            </v-list-item>
        </v-list>

        <v-divider></v-divider>

        <v-list v-if="cart.items.length > 0" class="pa-4">
            <v-list-item>
                <v-list-item-title class="text-h6">Total: {{ formatPrice(cart.totalPrice) }}</v-list-item-title>
            </v-list-item>

            <v-list-item>
                <v-btn block color="primary" @click="showConfirmationDialog" :loading="isProcessing" :disabled="isProcessing" class="mt-4">
                    {{ isProcessing ? 'Procesando...' : 'Proceder al Pago' }}
                </v-btn>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>

    <!-- Diálogo de confirmación -->
    <OrderConfirmationDialog v-model="showConfirmation" @order-confirmed="handleOrderConfirmed" />
</template>

<script setup>
import { ref, watch } from 'vue';
import { useCartStore } from '@/store/cart';
import OrderConfirmationDialog from './OrderConfirmationDialog.vue';

const props = defineProps({
    modelValue: {
        type: Boolean,
        required: true,
    },
});

const emit = defineEmits(['update:modelValue']);

const drawer = ref(props.modelValue);
const cart = useCartStore();
const isProcessing = ref(false);
const showConfirmation = ref(false);

watch(
    () => props.modelValue,
    (newValue) => {
        drawer.value = newValue;
    },
);

watch(drawer, (newValue) => {
    emit('update:modelValue', newValue);
});

const formatPrice = (price) => {
    return new Intl.NumberFormat('es-ES', {
        style: 'currency',
        currency: 'EUR',
    }).format(price);
};

const showConfirmationDialog = () => {
    showConfirmation.value = true;
};

const handleOrderConfirmed = () => {
    drawer.value = false;
};
</script>

<style scoped>
.v-list-item {
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.v-list-item:last-child {
    border-bottom: none;
}
</style>
