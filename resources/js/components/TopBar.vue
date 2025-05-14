<template>
    <div class="flex h-16 justify-around border-b-2 border-b-blue-400">
        <img :src="imageTitle" height="60" class="w-auto object-contain" alt="AutonovaParts" />
        <div class="flex h-full">
            <button @click="loadAbout" class="h-full w-28 text-center">
                <div
                    :class="{
                        'border-t-4 border-t-blue-400 text-blue-400': valueSelected === 'about',
                    }"
                    class="roboto flex h-full w-full items-center justify-center transition duration-300 ease-in-out hover:border-t-4 hover:border-t-blue-400 hover:text-blue-400"
                >
                    <span>Conócenos</span>
                </div>
            </button>
            <button @click="loadServices" class="h-full w-28 text-center">
                <div
                    :class="{
                        'border-t-4 border-t-blue-400 text-blue-400': valueSelected === 'services',
                    }"
                    class="roboto flex h-full w-full items-center justify-center transition duration-300 ease-in-out hover:border-t-4 hover:border-t-blue-400 hover:text-blue-400"
                >
                    <span>Servicios</span>
                </div>
            </button>
            <button @click="loadItems" class="h-full w-28 text-center">
                <div
                    :class="{
                        'border-t-4 border-t-blue-400 text-blue-400': valueSelected === 'items',
                    }"
                    class="roboto flex h-full w-full items-center justify-center transition duration-300 ease-in-out hover:border-t-4 hover:border-t-blue-400 hover:text-blue-400"
                >
                    <span>Catálogo</span>
                </div>
            </button>
            <button @click="loadPerfil" class="h-full w-28 text-center">
                <div
                    :class="{
                        'border-t-4 border-t-blue-400 text-blue-400': valueSelected === 'perfil',
                    }"
                    class="roboto flex h-full w-full items-center justify-center transition duration-300 ease-in-out hover:border-t-4 hover:border-t-blue-400 hover:text-blue-400"
                >
                    <span>Perfil</span>
                </div>
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
const emit = defineEmits(['loadAbout', 'loadServices', 'loadItems', 'loadPerfil']);
const imageTitle = ref('/images/autonovaparts_title.jpg');
const valueSelected = ref('about');

const loadAbout = () => {
    emit('loadAbout');
    valueSelected.value = 'about';
};

const loadServices = () => {
    emit('loadServices');
    valueSelected.value = 'services';
};

const loadItems = () => {
    emit('loadItems');
    valueSelected.value = 'items';
};

const loadPerfil = () => {
    emit('loadPerfil');
    valueSelected.value = 'perfil';
};
</script>

<style>
.roboto {
    font-family: 'Roboto', sans-serif;
    font-optical-sizing: auto;
    font-style: normal;
    font-variation-settings: 'wdth' 100;
}
</style>
