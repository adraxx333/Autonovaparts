import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export const useApplicationStore = defineStore('application', () => {
    const screenSelected = ref('about');
    const currentComponent = ref('AboutScreen');
    const previousScreen = ref(null);

    // Computed para verificar si estamos en una pantalla protegida
    const isProtectedScreen = computed(() => {
        return ['orders', 'favorites', 'settings'].includes(screenSelected.value);
    });

    // Función para navegar a una pantalla
    const navigateTo = (screen) => {
        previousScreen.value = screenSelected.value;
        screenSelected.value = screen;
    };

    const loadAbout = () => {
        navigateTo('about');
        currentComponent.value = 'AboutScreen';
    };

    const loadServices = () => {
        navigateTo('service');
        currentComponent.value = 'ServicesScreen';
    };

    const loadItems = () => {
        navigateTo('items');
        currentComponent.value = 'ItemsScreen';
    };

    const loadLogin = () => {
        navigateTo('login');
        currentComponent.value = 'LoginScreen';
    };

    const loadOrders = () => {
        navigateTo('orders');
        currentComponent.value = 'OrdersScreen';
    };

    // Función para volver a la pantalla anterior
    const goBack = () => {
        if (previousScreen.value) {
            navigateTo(previousScreen.value);
        }
    };

    return {
        screenSelected,
        currentComponent,
        previousScreen,
        isProtectedScreen,
        navigateTo,
        loadAbout,
        loadServices,
        loadItems,
        loadLogin,
        loadOrders,
        goBack,
    };
});
