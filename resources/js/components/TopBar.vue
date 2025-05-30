<template>
    <div class="flex h-16 justify-around border-b-2 border-b-blue-400">
        <img :src="imageTitle" height="60" class="w-auto object-contain" alt="Autonovaparts" />
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
            <button @click="application.loadPerfil" class="h-full w-28 text-center">
                <div
                    :class="{
                        'border-t-4 border-t-blue-400 text-blue-400': application.screenSelected === 'perfil',
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
import { useApplicationStore } from '@/store/application';
import { ref } from 'vue';

const application = useApplicationStore();
const imageTitle = ref('/images/autonovaparts_title.jpg');
</script>

<style>
.roboto {
    font-family: 'Roboto', sans-serif;
    font-optical-sizing: auto;
    font-style: normal;
    font-variation-settings: 'wdth' 100;
}
</style>
