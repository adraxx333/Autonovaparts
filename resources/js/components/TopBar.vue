<template>
    <div class="flex h-16 justify-around border-b-2 border-b-blue-400">
        <img @click="application.loadAbout" :src="imageTitle" height="60" class="w-auto object-contain hover:cursor-pointer" alt="Autonovaparts" />
        <div class="flex h-full">
            <button @click="application.loadAbout" class="h-full w-28 text-center">
                <div
                    :class="{
                        'border-t-4 border-t-blue-400 text-blue-400': application.screenSelected === 'about',
                    }"
                    class="roboto flex h-full w-full items-center justify-center transition duration-300 ease-in-out hover:border-t-4 hover:border-t-blue-400 hover:text-blue-400"
                >
                    <span>Conócenos</span>
                </div>
            </button>
            <button @click="application.loadServices" class="h-full w-28 text-center">
                <div
                    :class="{
                        'border-t-4 border-t-blue-400 text-blue-400': application.screenSelected === 'service',
                    }"
                    class="roboto flex h-full w-full items-center justify-center transition duration-300 ease-in-out hover:border-t-4 hover:border-t-blue-400 hover:text-blue-400"
                >
                    <span>Servicios</span>
                </div>
            </button>
            <button @click="application.loadItems" class="h-full w-28 text-center">
                <div
                    :class="{
                        'border-t-4 border-t-blue-400 text-blue-400': application.screenSelected === 'items',
                    }"
                    class="roboto flex h-full w-full items-center justify-center transition duration-300 ease-in-out hover:border-t-4 hover:border-t-blue-400 hover:text-blue-400"
                >
                    <span>Catálogo</span>
                </div>
            </button>
            <v-menu>
                <template v-slot:activator="{ props }">
                    <button v-bind="props" class="h-full w-28 text-center">
                        <div
                            :class="{
                                'border-t-4 border-t-blue-400 text-blue-400': application.screenSelected === 'perfil',
                            }"
                            class="roboto flex h-full w-full items-center justify-center transition duration-300 ease-in-out hover:border-t-4 hover:border-t-blue-400 hover:text-blue-400"
                        >
                            <span>Perfil</span>
                            <v-icon size="small" class="ml-1">mdi-chevron-down</v-icon>
                        </div>
                    </button>
                </template>

                <v-list class="pa-0">
                    <!-- Información del usuario -->
                    <v-list-item class="border-b">
                        <v-list-item-title class="font-semibold">{{ user?.name || 'Usuario' }}</v-list-item-title>
                        <v-list-item-subtitle class="text-xs text-gray-500">{{ user?.email || 'usuario@email.com' }}</v-list-item-subtitle>
                    </v-list-item>

                    <!-- Mis Pedidos -->
                    <v-list-item @click="handleNavigation('orders')" class="cursor-pointer">
                        <template v-slot:prepend>
                            <v-icon>mdi-package-variant</v-icon>
                        </template>
                        <v-list-item-title>Mis Pedidos</v-list-item-title>
                    </v-list-item>

                    <v-divider></v-divider>

                    <!-- Cerrar Sesión -->
                    <v-list-item @click="logout" class="cursor-pointer">
                        <template v-slot:prepend>
                            <v-icon color="error">mdi-logout</v-icon>
                        </template>
                        <v-list-item-title class="text-error">Cerrar Sesión</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </div>
        <div class="flex items-center">
            <v-btn icon="mdi-cart-outline" variant="text" @click="cartDrawer = true" class="relative">
                <v-icon icon="mdi-cart-outline" size="large"></v-icon>
                <div v-if="cart.totalItems > 0" class="cart-badge">
                    {{ cart.totalItems }}
                </div>
            </v-btn>
        </div>
    </div>
    <CartDrawer v-model="cartDrawer" />
</template>

<script setup>
import { useApplicationStore } from '@/store/application';
import { ref, computed } from 'vue';
import { useCartStore } from '@/store/cart';
import CartDrawer from './CartDrawer.vue';
import { useApplicationUsersStore } from '@/store/applicationUsers';

const application = useApplicationStore();
const imageTitle = ref('/images/autonovaparts_title.jpg');
const cartDrawer = ref(false);
const cart = useCartStore();
const users = useApplicationUsersStore();
const user = computed(() => users.currentUser);

const logout = async () => {
    try {
        const response = await users.logout();
        if (response.success) {
            // Limpiar todo el estado local
            localStorage.clear();
            sessionStorage.clear();

            // Forzar un reload completo y redirigir
            window.location.href = '/login';
        }
    } catch (error) {
        console.error('Error al cerrar sesión:', error);
    }
};

// Verificar si el usuario está autenticado antes de cargar ciertas pantallas
const handleNavigation = (screen) => {
    if (!users.checkAuth() && ['orders', 'favorites', 'settings'].includes(screen)) {
        application.loadLogin();
        return;
    }

    switch (screen) {
        case 'orders':
            application.loadOrders();
            break;
        case 'favorites':
            application.loadFavorites();
            break;
        case 'settings':
            application.loadSettings();
            break;
    }
};
</script>

<style>
.roboto {
    font-family: 'Roboto', sans-serif;
    font-optical-sizing: auto;
    font-style: normal;
    font-variation-settings: 'wdth' 100;
}

.cart-badge {
    position: absolute;
    top: 0;
    right: 0;
    background-color: #ff5252;
    color: white;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    transform: translate(25%, -25%);
}

.group:hover .group-hover\:block {
    display: block;
}

/* Animación para el dropdown */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.group:hover .group-hover\:block {
    animation: slideDown 0.2s ease-out;
}
</style>
