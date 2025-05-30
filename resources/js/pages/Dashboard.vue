<template>
    <TopBar></TopBar>

    <div class="min-h-screen w-full bg-[url('/images/car.jpg')] bg-cover bg-center">
        <AboutScreen v-if="application.screenSelected === 'about'"></AboutScreen>
        <ServiceScreen v-if="application.screenSelected === 'service'"></ServiceScreen>
        <ItemsScreen v-if="application.screenSelected === 'items'"></ItemsScreen>
    </div>
</template>

<script setup>
import TopBar from '@/components/TopBar.vue';
import { useApplicationStore } from '@/store/application';
import AboutScreen from './AboutScreen.vue';
import ItemsScreen from './ItemsScreen.vue';
import ServiceScreen from './ServiceSreen.vue';
// DATA
const application = useApplicationStore();
</script>
