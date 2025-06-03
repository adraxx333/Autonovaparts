<template>
    <v-app>
        <v-main>
            <TopBar></TopBar>

            <div class="min-h-screen w-full bg-[url('/images/car.jpg')] bg-cover bg-center">
                <component :is="getCurrentComponent" v-if="application.currentComponent"></component>
                <div class="h-32 w-full bg-transparent"></div>
            </div>

            <FooterBar></FooterBar>
        </v-main>
    </v-app>
</template>

<script setup>
import TopBar from '@/components/TopBar.vue';
import FooterBar from '@/components/FooterBar.vue';
import { useApplicationStore } from '@/store/application';
import AboutScreen from './AboutScreen.vue';
import ItemsScreen from './ItemsScreen.vue';
import ServiceScreen from './ServiceSreen.vue';
import OrdersScreen from './OrdersScreen.vue';
import { watch, computed } from 'vue';

// DATA
const application = useApplicationStore();

// Mapeo de componentes
const components = {
    AboutScreen: AboutScreen,
    ServicesScreen: ServiceScreen,
    ItemsScreen: ItemsScreen,
    OrdersScreen: OrdersScreen,
};

// Computed para obtener el componente actual
const getCurrentComponent = computed(() => {
    return components[application.currentComponent] || null;
});

// Watcher para desplazar la vista hacia arriba cuando cambie la pantalla
watch(
    () => application.screenSelected,
    () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        });
    },
);
</script>
