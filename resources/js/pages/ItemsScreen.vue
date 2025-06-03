<template>
    <v-container>
        <v-row class="fill-height">
            <!-- Filtros -->
            <v-col cols="12" md="3" class="px-2">
                <v-card class="mb-4 h-100">
                    <v-card-title class="d-flex justify-space-between align-center">
                        Filtros
                        <v-btn variant="text" color="primary" @click="resetFilters" :disabled="loading"> Limpiar </v-btn>
                    </v-card-title>

                    <v-card-text>
                        <!-- Loading overlay -->
                        <div v-if="loading" class="loading-overlay">
                            <v-progress-circular indeterminate color="primary" size="32"></v-progress-circular>
                        </div>

                        <!-- Búsqueda por texto -->
                        <v-text-field
                            v-model="filters.search"
                            label="Buscar por nombre o código"
                            prepend-inner-icon="mdi-magnify"
                            clearable
                            class="mb-4"
                            :disabled="loading"
                        ></v-text-field>

                        <!-- Filtro por marca -->
                        <v-select v-model="filters.brand" :items="brands" label="Marca" clearable class="mb-4" :disabled="loading"></v-select>

                        <!-- Filtro por modelo -->
                        <v-select
                            v-model="filters.model"
                            :items="filteredModels"
                            label="Modelo"
                            clearable
                            class="mb-4"
                            :disabled="!filters.brand || loading"
                        ></v-select>

                        <!-- Filtro por categoría -->
                        <v-select
                            v-model="filters.category"
                            :items="categories"
                            label="Categoría"
                            clearable
                            class="mb-4"
                            item-title="title"
                            item-value="value"
                            :loading="loading"
                            :disabled="loading"
                        ></v-select>

                        <!-- Filtro por precio -->
                        <v-range-slider
                            v-model="filters.price"
                            :min="0"
                            :max="1000"
                            label="Rango de precio"
                            thumb-label
                            class="mb-4"
                            :disabled="loading"
                        ></v-range-slider>

                        <!-- Filtro por disponibilidad -->
                        <v-switch
                            v-model="filters.onlyAvailable"
                            label="Solo disponibles"
                            color="primary"
                            class="mb-4"
                            :disabled="loading"
                        ></v-switch>

                        <!-- Ordenar por -->
                        <v-select v-model="filters.sortBy" :items="sortOptions" label="Ordenar por" class="mb-4" :disabled="loading"></v-select>
                    </v-card-text>
                </v-card>
            </v-col>

            <!-- Lista de productos -->
            <v-col cols="12" md="9" class="px-2">
                <v-card class="h-100">
                    <v-card-title class="d-flex justify-space-between align-center">
                        Catálogo de Productos
                        <v-chip color="primary" class="ml-2"> {{ filteredAndSortedItems.length }} productos </v-chip>
                    </v-card-title>

                    <v-card-text class="pa-4" style="height: calc(100% - 64px); overflow-y: auto">
                        <!-- Loading state -->
                        <div v-if="loading" class="d-flex align-center justify-center" style="height: 300px">
                            <v-progress-circular indeterminate color="primary" size="64"></v-progress-circular>
                        </div>

                        <!-- Content when loaded -->
                        <template v-else>
                            <v-row>
                                <v-col v-for="item in paginatedItems" :key="item.id" cols="12" sm="6" md="4">
                                    <v-card variant="outlined" class="d-flex flex-column h-100">
                                        <div class="image-container">
                                            <v-img :src="item.image_url" :aspect-ratio="16 / 9" cover class="product-image" @error="handleImageError">
                                                <template v-slot:placeholder>
                                                    <v-row class="fill-height ma-0" align="center" justify="center">
                                                        <v-progress-circular indeterminate color="primary"></v-progress-circular>
                                                    </v-row>
                                                </template>
                                                <template v-slot:error>
                                                    <v-row class="fill-height ma-0" align="center" justify="center">
                                                        <v-icon size="large" color="grey">mdi-image-off</v-icon>
                                                    </v-row>
                                                </template>
                                            </v-img>
                                        </div>

                                        <v-card-title class="text-subtitle-1 text-truncate py-2">{{ item.name }}</v-card-title>

                                        <v-card-text class="flex-grow-1 py-2">
                                            <div class="text-subtitle-1 font-weight-bold mb-1">€{{ item.price }}</div>
                                            <div class="text-caption text-truncate-2 mb-1">{{ item.description }}</div>
                                            <div class="mt-1">
                                                <v-chip size="small" color="primary" class="mr-2 mb-1">
                                                    {{ item.category?.name }}
                                                </v-chip>
                                                <v-chip size="small" :color="item.stock > 0 ? 'success' : 'error'" class="mb-1">
                                                    {{ item.stock > 0 ? `${item.stock} disponibles` : 'No disponible' }}
                                                </v-chip>
                                            </div>
                                        </v-card-text>

                                        <v-card-actions class="pt-0">
                                            <v-btn color="primary" variant="text" block @click="openDetails(item)"> Ver detalles </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-col>
                            </v-row>

                            <!-- Mensaje cuando no hay resultados -->
                            <v-row v-if="filteredAndSortedItems.length === 0">
                                <v-col cols="12" class="text-center">
                                    <v-alert type="info" text="No se encontraron productos con los filtros seleccionados"></v-alert>
                                </v-col>
                            </v-row>
                        </template>
                    </v-card-text>
                </v-card>

                <!-- Navegación simple -->
                <div v-if="totalPages > 1" class="mt-2 w-100 text-center">
                    <v-btn
                        color="primary"
                        class="mr-6"
                        :disabled="currentPage === 1"
                        @click="currentPage--"
                        icon="mdi-chevron-left"
                        size="small"
                    ></v-btn>
                    <v-btn
                        color="primary"
                        :disabled="currentPage === totalPages"
                        @click="currentPage++"
                        icon="mdi-chevron-right"
                        size="small"
                    ></v-btn>
                </div>
            </v-col>
        </v-row>

        <!-- Diálogo de detalles -->
        <v-dialog v-model="showDetails" max-width="800px">
            <v-card v-if="selectedItem">
                <v-img :src="selectedItem.image_url" :aspect-ratio="16 / 9" cover class="product-detail-image" @error="handleImageError">
                    <template v-slot:placeholder>
                        <v-row class="fill-height ma-0" align="center" justify="center">
                            <v-progress-circular indeterminate color="primary"></v-progress-circular>
                        </v-row>
                    </template>
                    <template v-slot:error>
                        <v-row class="fill-height ma-0" align="center" justify="center">
                            <v-icon size="large" color="grey">mdi-image-off</v-icon>
                        </v-row>
                    </template>
                </v-img>

                <v-card-title class="text-h5">
                    {{ selectedItem.name }}
                    <v-chip color="primary" class="ml-2">{{ selectedItem.category?.name }}</v-chip>
                </v-card-title>

                <v-card-text>
                    <v-row>
                        <v-col cols="12" md="8">
                            <div class="text-h6 mb-2">€{{ selectedItem.price }}</div>
                            <div class="text-body-1 mb-4">{{ selectedItem.description }}</div>

                            <!-- Información de stock -->
                            <v-alert
                                :type="selectedItem.stock > 0 ? 'success' : 'error'"
                                :text="selectedItem.stock > 0 ? `Disponibles: ${selectedItem.stock} unidades` : 'No disponible'"
                                class="mb-4"
                            ></v-alert>

                            <!-- Código del producto -->
                            <div class="text-caption mb-4">Código: {{ selectedItem.code }}</div>

                            <!-- Modelos compatibles -->
                            <div v-if="selectedItem.models?.length" class="mb-4">
                                <div class="text-subtitle-1 mb-2">Modelos compatibles:</div>
                                <v-chip-group>
                                    <v-chip v-for="model in selectedItem.models" :key="model.id" size="small" class="mr-2 mb-2">
                                        {{ model.brand }} - {{ model.name }}
                                    </v-chip>
                                </v-chip-group>
                            </div>
                        </v-col>

                        <v-col cols="12" md="4">
                            <!-- Información adicional -->
                            <v-card variant="outlined" class="mb-4">
                                <v-card-title class="text-subtitle-1">Información adicional</v-card-title>
                                <v-card-text>
                                    <div class="mb-2">
                                        <v-icon size="small" class="mr-2">mdi-calendar</v-icon>
                                        Añadido: {{ formatDate(selectedItem.created_at) }}
                                    </div>
                                    <div class="mb-2">
                                        <v-icon size="small" class="mr-2">mdi-update</v-icon>
                                        Última actualización: {{ formatDate(selectedItem.updated_at) }}
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" variant="text" @click="showDetails = false"> Cerrar </v-btn>
                    <v-btn
                        color="primary"
                        :disabled="selectedItem.stock === 0"
                        @click="addToCart(selectedItem)"
                        :loading="loadingItems.includes(selectedItem.id)"
                    >
                        <v-icon start icon="mdi-cart-plus"></v-icon>
                        {{ selectedItem.stock > 0 ? 'Añadir al carrito' : 'No disponible' }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- Snackbar para notificaciones -->
        <v-snackbar v-model="snackbar.show" :color="snackbar.color" timeout="3000">
            {{ snackbar.text }}
            <template v-slot:actions>
                <v-btn icon="mdi-close" variant="text" @click="snackbar.show = false"></v-btn>
            </template>
        </v-snackbar>
    </v-container>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import { usePartsStore } from '@/store/applicationParts';
import { useCartStore } from '@/store/cart';

// Store
const partsStore = usePartsStore();
const cart = useCartStore();

// Estado de los items
const items = computed(() => partsStore.parts);
const categories = computed(() => partsStore.categories);
const brands = computed(() => partsStore.brands);
const loading = computed(() => partsStore.loading);

// Imagen por defecto
const defaultImage = '/images/no-image.svg';

// Función para manejar errores de imagen
const handleImageError = (event) => {
    if (event.target) {
        event.target.src = defaultImage;
    }
};

// Opciones de ordenamiento
const sortOptions = [
    { title: 'Precio: Menor a Mayor', value: 'price_asc' },
    { title: 'Precio: Mayor a Menor', value: 'price_desc' },
    { title: 'Nombre: A-Z', value: 'name_asc' },
    { title: 'Nombre: Z-A', value: 'name_desc' },
    { title: 'Más recientes', value: 'newest' },
];

// Estado de los filtros
const filters = ref({
    search: '',
    brand: null,
    model: null,
    category: null,
    price: [0, 1000],
    onlyAvailable: false,
    sortBy: 'price_asc',
});

// Computed para modelos filtrados por marca
const filteredModels = computed(() => {
    if (!filters.value.brand) return [];
    const models = new Set();
    items.value.forEach((item) => {
        item.models?.forEach((model) => {
            if (model.brand === filters.value.brand) {
                models.add(model.name);
            }
        });
    });
    return Array.from(models);
});

// Computed para items filtrados y ordenados
const filteredAndSortedItems = computed(() => {
    const result = items.value.filter((item) => {
        // Filtro de búsqueda
        if (filters.value.search) {
            const searchLower = filters.value.search.toLowerCase();
            if (!item.name.toLowerCase().includes(searchLower) && !item.code.toLowerCase().includes(searchLower)) {
                return false;
            }
        }

        // Filtro de marca
        if (filters.value.brand) {
            const hasBrand = item.models?.some((model) => model.brand === filters.value.brand);
            if (!hasBrand) return false;
        }

        // Filtro de modelo
        if (filters.value.model) {
            const hasModel = item.models?.some((model) => model.name === filters.value.model);
            if (!hasModel) return false;
        }

        // Filtro de categoría
        if (filters.value.category && item.category?.name !== filters.value.category) return false;

        // Filtro de precio
        if (item.price < filters.value.price[0] || item.price > filters.value.price[1]) return false;

        // Filtro de disponibilidad
        if (filters.value.onlyAvailable && item.stock === 0) return false;

        return true;
    });

    // Ordenamiento
    result.sort((a, b) => {
        switch (filters.value.sortBy) {
            case 'price_asc':
                return a.price - b.price;
            case 'price_desc':
                return b.price - a.price;
            case 'name_asc':
                return a.name.localeCompare(b.name);
            case 'name_desc':
                return b.name.localeCompare(a.name);
            case 'newest':
                return new Date(b.created_at) - new Date(a.created_at);
            default:
                return 0;
        }
    });

    return result;
});

// Estado de paginación
const itemsPerPage = 6;
const currentPage = ref(1);

// Computed para el total de páginas
const totalPages = computed(() => {
    return Math.ceil(filteredAndSortedItems.value.length / itemsPerPage);
});

// Computed para los items de la página actual
const paginatedItems = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredAndSortedItems.value.slice(start, end);
});

// Observar cambios en los filtros para resetear la página
watch(
    filters,
    () => {
        currentPage.value = 1;
    },
    { deep: true },
);

// Observar cambios en el total de páginas para ajustar la página actual
watch(totalPages, (newTotal) => {
    if (currentPage.value > newTotal) {
        currentPage.value = newTotal || 1;
    }
});

// Función para resetear filtros
const resetFilters = () => {
    filters.value = {
        search: '',
        brand: null,
        model: null,
        category: null,
        price: [0, 1000],
        onlyAvailable: false,
        sortBy: 'price_asc',
    };
    currentPage.value = 1;
};

// Cargar datos al montar el componente
onMounted(async () => {
    await partsStore.initializeData();
});

// Estado para el diálogo de detalles
const showDetails = ref(false);
const selectedItem = ref(null);

// Función para abrir el diálogo de detalles
const openDetails = (item) => {
    selectedItem.value = item;
    showDetails.value = true;
};

// Estado para el carrito
const loadingItems = ref([]);
const snackbar = ref({
    show: false,
    text: '',
    color: 'success',
});

// Añadir al carrito
const addToCart = async (item) => {
    loadingItems.value.push(item.id);

    try {
        // Simulamos una pequeña demora para mejor UX
        await new Promise((resolve) => setTimeout(resolve, 500));

        // Preparamos el item para el carrito
        const cartItem = {
            id: item.id,
            name: item.name,
            price: item.price,
            image_url: item.image_url || defaultImage,
            quantity: 1,
            stock: item.stock,
            code: item.code,
            part_code: item.code, // Añadimos el part_code también
        };

        cart.addItem(cartItem);
        cart.saveCart();

        snackbar.value = {
            show: true,
            text: `${item.name} añadido al carrito`,
            color: 'success',
        };
    } catch (error) {
        console.error('Error al añadir al carrito:', error);
        snackbar.value = {
            show: true,
            text: 'Error al añadir al carrito',
            color: 'error',
        };
    } finally {
        loadingItems.value = loadingItems.value.filter((id) => id !== item.id);
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
</script>

<style scoped>
.v-card {
    transition: transform 0.2s;
}

.h-100 {
    height: 100%;
}

.fill-height {
    height: 100%;
}

.flex-grow-1 {
    flex-grow: 1;
}

.image-container {
    position: relative;
    width: 100%;
    padding-top: 56.25%; /* Aspect ratio 16:9 */
    overflow: hidden;
}

.product-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.text-truncate-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Estilos para el scrollbar */
.v-card-text::-webkit-scrollbar {
    width: 6px;
}

.v-card-text::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.v-card-text::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

.v-card-text::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Asegurar que la columna de productos no desborde */
.v-col.px-2 {
    padding-left: 8px !important;
    padding-right: 8px !important;
}

.product-detail-image {
    border-radius: 4px 4px 0 0;
}

.v-dialog {
    border-radius: 8px;
}

.loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1;
}

.v-card-text {
    position: relative;
}
</style>
