<template>
    <div class="container mx-auto px-4 py-8">
        <!-- Header con título y botón de actualizar -->
        <div class="mb-8 flex items-center justify-between px-8">
            <div>
                <h1 class="text-3xl font-bold text-white">Mis Pedidos</h1>
                <p class="mt-1 text-sm text-gray-200">Gestiona y revisa el estado de tus pedidos</p>
            </div>
            <v-btn color="primary" @click="loadOrders" :loading="isLoading" elevation="2">
                <v-icon icon="mdi-refresh" start />
                Actualizar
            </v-btn>
        </div>

        <!-- Estado de carga -->
        <div v-if="isLoading" class="flex h-64 items-center justify-center">
            <v-progress-circular indeterminate color="primary" size="64"></v-progress-circular>
        </div>

        <!-- Mensaje de error -->
        <v-alert v-if="error" type="error" class="mx-8 mb-6" closable @click:close="error = ''" elevation="2">
            <template v-slot:prepend>
                <v-icon icon="mdi-alert-circle" />
            </template>
            {{ error }}
        </v-alert>

        <!-- Lista de pedidos -->
        <div v-if="!isLoading && orders.length > 0" class="space-y-6 px-8">
            <v-card v-for="order in paginatedOrders" :key="order.uuid" class="mb-6 overflow-hidden bg-white/90 backdrop-blur-sm" elevation="2">
                <!-- Header de la tarjeta -->
                <v-card-title class="bg-primary/10 px-12 py-6">
                    <div class="flex w-full items-center justify-between">
                        <div class="flex items-center gap-4">
                            <span class="text-lg leading-none font-semibold text-gray-800">Pedido #{{ order.order_number }}</span>
                            <v-select
                                v-model="order.status"
                                :items="statusOptions"
                                :color="getStatusColor(order.status)"
                                density="compact"
                                variant="plain"
                                class="w-40"
                                hide-details
                                @update:model-value="updateOrderStatus(order)"
                            >
                                <template v-slot:selection="{ item }">
                                    <v-chip :color="getStatusColor(item.value)" size="small" elevation="1" class="w-full justify-center">
                                        {{ getStatusText(item.value) }}
                                    </v-chip>
                                </template>
                            </v-select>
                        </div>
                        <div class="text-sm text-gray-600">
                            {{ formatDate(order.created_at) }}
                        </div>
                    </div>
                </v-card-title>

                <v-card-text class="p-12">
                    <!-- Grid de información principal -->
                    <div class="mb-12 grid grid-cols-1 gap-12 md:grid-cols-2">
                        <!-- Detalles del pedido -->
                        <div class="mx-8 rounded-lg p-12">
                            <h3 class="mb-6 text-xl font-semibold text-gray-800">Detalles del Pedido</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Total:</span>
                                    <span class="font-semibold text-gray-800">{{ formatPrice(order.total) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Items:</span>
                                    <span class="font-semibold text-gray-800">{{ order.items_count }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Dirección de envío -->
                        <div class="mx-8 rounded-lg p-12">
                            <h3 class="mb-6 text-xl font-semibold text-gray-800">Dirección de Envío</h3>
                            <p class="text-gray-600">{{ order.shipping_address }}</p>
                        </div>
                    </div>

                    <!-- Tabla de items -->
                    <div class="mt-12 rounded-lg border border-gray-200 bg-white/80">
                        <h3 class="mb-6 px-12 pt-12 text-xl font-semibold text-gray-800">Items del Pedido</h3>
                        <v-table class="rounded-lg">
                            <thead>
                                <tr class="bg-primary/5">
                                    <th class="px-12 py-6 text-left font-semibold text-gray-600">Producto</th>
                                    <th class="px-12 py-6 text-left font-semibold text-gray-600">Código</th>
                                    <th class="px-12 py-6 text-center font-semibold text-gray-600">Cantidad</th>
                                    <th class="px-12 py-6 text-right font-semibold text-gray-600">Precio</th>
                                    <th class="px-12 py-6 text-right font-semibold text-gray-600">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in order.items" :key="item.id" class="border-b border-gray-100">
                                    <td class="px-12 py-8">{{ item.part.name }}</td>
                                    <td class="px-12 py-8">{{ item.part.code }}</td>
                                    <td class="px-12 py-8 text-center">{{ item.quantity }}</td>
                                    <td class="px-12 py-8 text-right">{{ formatPrice(item.price) }}</td>
                                    <td class="px-12 py-8 text-right font-semibold">{{ formatPrice(item.subtotal) }}</td>
                                </tr>
                            </tbody>
                        </v-table>
                    </div>
                </v-card-text>
            </v-card>

            <!-- Paginación -->
            <div class="mt-8 flex items-center justify-center gap-6">
                <v-btn
                    color="primary"
                    variant="elevated"
                    :disabled="currentPage === 1"
                    @click="currentPage--"
                    prepend-icon="mdi-chevron-left"
                    size="large"
                    class="font-weight-bold"
                    elevation="2"
                >
                    Anterior
                </v-btn>

                <div class="rounded-lg bg-white/80 px-6 py-2 text-base font-semibold text-gray-700 shadow-sm">
                    Página {{ currentPage }} de {{ totalPages }}
                </div>

                <v-btn
                    color="primary"
                    variant="elevated"
                    :disabled="currentPage === totalPages"
                    @click="currentPage++"
                    append-icon="mdi-chevron-right"
                    size="large"
                    class="font-weight-bold"
                    elevation="2"
                >
                    Siguiente
                </v-btn>
            </div>
        </div>

        <!-- Mensaje cuando no hay pedidos -->
        <v-alert v-if="!isLoading && orders.length === 0" type="info" class="mx-8 mt-6 bg-white/90 backdrop-blur-sm" elevation="2">
            <template v-slot:prepend>
                <v-icon icon="mdi-information" />
            </template>
            No tienes pedidos realizados.
        </v-alert>
    </div>
</template>

<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import axios from 'axios';

// Estado de los pedidos
const orders = ref([]);
const isLoading = ref(true);
const error = ref('');
const currentPage = ref(1);
const itemsPerPage = 3;
const totalItems = ref(0);

// Computed para el total de páginas
const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage));

// Computed para los items de la página actual
const paginatedOrders = computed(() => {
    if (!orders.value) return [];
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return orders.value.slice(start, end);
});

// Opciones de estado
const statusOptions = [
    { title: 'Pendiente', value: 'pending' },
    { title: 'En Proceso', value: 'processing' },
    { title: 'Enviado', value: 'shipped' },
    { title: 'Entregado', value: 'delivered' },
    { title: 'Cancelado', value: 'cancelled' },
];

// Función para cargar los pedidos
const loadOrders = async () => {
    try {
        isLoading.value = true;
        error.value = '';
        const response = await axios.get('/orders');
        orders.value = response.data || [];
        totalItems.value = orders.value.length;
        currentPage.value = 1;
    } catch (err) {
        error.value = err.response?.data?.message || 'Error al cargar los pedidos';
        console.error('Error al cargar pedidos:', err);
        orders.value = [];
    } finally {
        isLoading.value = false;
    }
};

// Función para actualizar el estado del pedido
const updateOrderStatus = async (order) => {
    if (!order || !order.uuid) return;

    try {
        await axios.patch(`/orders/${order.uuid}/status`, {
            status: order.status,
        });
        error.value = '';
    } catch (err) {
        error.value = err.response?.data?.message || 'Error al actualizar el estado del pedido';
        console.error('Error al actualizar estado:', err);
        await loadOrders();
    }
};

// Función para formatear la fecha
const formatDate = (date) => {
    if (!date) return 'Fecha no disponible';

    try {
        const dateObj = new Date(date);
        if (isNaN(dateObj.getTime())) {
            return 'Fecha inválida';
        }

        return dateObj.toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: false,
        });
    } catch (error) {
        console.error('Error al formatear fecha:', error);
        return 'Error en fecha';
    }
};

// Función para formatear el precio
const formatPrice = (price) => {
    return new Intl.NumberFormat('es-ES', {
        style: 'currency',
        currency: 'EUR',
    }).format(price);
};

// Función para obtener el color del estado
const getStatusColor = (status) => {
    const colors = {
        pending: 'warning',
        processing: 'info',
        shipped: 'success',
        delivered: 'success',
        cancelled: 'error',
    };
    return colors[status] || 'grey';
};

// Función para obtener el texto del estado
const getStatusText = (status) => {
    const texts = {
        pending: 'Pendiente',
        processing: 'En Proceso',
        shipped: 'Enviado',
        delivered: 'Entregado',
        cancelled: 'Cancelado',
    };
    return texts[status] || status;
};

// Observar cambios en el total de páginas para ajustar la página actual
watch(totalPages, (newTotal) => {
    if (currentPage.value > newTotal) {
        currentPage.value = newTotal || 1;
    }
});

// Cargar pedidos al montar el componente
onMounted(() => {
    loadOrders();
});
</script>

<style scoped>
.container {
    max-width: 1200px;
}

.v-card {
    transition: transform 0.2s ease-in-out;
}

.v-card:hover {
    transform: translateY(-2px);
}

.v-table {
    border-radius: 8px;
    overflow: hidden;
}

.v-table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.875rem;
}

.v-table td {
    font-size: 0.875rem;
}
</style>
