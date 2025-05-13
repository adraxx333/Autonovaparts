<template>
    <TopBar @load-about="loadAbout" @load-services="loadServices" @load-items="loadItems" @load-perfil="loadPerfil"></TopBar>
</template>

<script setup>
import TopBar from '@/components/TopBar.vue';

const loadAbout = () => {
    console.log('about');
};

const loadServices = () => {
    console.log('service');
};

const loadItems = () => {
    console.log('items');
};

const loadPerfil = () => {
    console.log('perfil');
};
</script>
