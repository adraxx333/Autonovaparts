<template>
    <TopBar @load-about="loadAbout" @load-services="loadServices" @load-items="loadItems" @load-perfil="loadPerfil"></TopBar>

    <div class="min-h-screen w-full bg-[url('/images/car.jpg')] bg-cover bg-center">
        <AboutScreen v-if="valueSelected === 'about'"></AboutScreen>
    </div>
</template>

<script setup>
import TopBar from '@/components/TopBar.vue';
import { ref } from 'vue';
import AboutScreen from './AboutScreen.vue';

// DATA
const valueSelected = ref('about');

//METHOD
const loadAbout = () => {
    console.log('about');
    valueSelected.value = 'about';
};

const loadServices = () => {
    console.log('service');
    valueSelected.value = 'service';
};

const loadItems = () => {
    console.log('items');
    valueSelected.value = 'items';
};

const loadPerfil = () => {
    console.log('perfil');
    valueSelected.value = 'perfil';
};
</script>
