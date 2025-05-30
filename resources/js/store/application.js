import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useApplicationStore = defineStore('application', () => {
    const screenSelected = ref('about');

    const loadAbout = () => {
        console.log('about');
        screenSelected.value = 'about';
    };

    const loadServices = () => {
        console.log('service');
        screenSelected.value = 'service';
    };

    const loadItems = () => {
        console.log('items');
        screenSelected.value = 'items';
    };

    const loadPerfil = () => {
        console.log('perfil');
        screenSelected.value = 'perfil';
    };

    return {
        screenSelected,
        loadAbout,
        loadServices,
        loadItems,
        loadPerfil,
    };
});
