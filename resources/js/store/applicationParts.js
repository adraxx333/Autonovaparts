import { defineStore } from 'pinia';
import { ref } from 'vue';
import axios from 'axios';

export const usePartsStore = defineStore('applicationParts', () => {
    // Estado
    const parts = ref([]);
    const categories = ref([]);
    const brands = ref([]);
    const loading = ref(false);
    const error = ref(null);

    // Acciones
    const loadParts = async () => {
        loading.value = true;
        error.value = null;
        try {
            const response = await axios.get('/api/parts');
            parts.value = response.data;
        } catch (err) {
            error.value = err.message;
            console.error('Error cargando partes:', err);
        } finally {
            loading.value = false;
        }
    };

    const loadCategories = async () => {
        loading.value = true;
        error.value = null;
        try {
            const response = await axios.get('/api/categories');
            console.log('Categorías recibidas:', response.data); // Debug
            categories.value = response.data.map((category) => ({
                title: category.name,
                value: category.name,
                id: category.id,
            }));
            console.log('Categorías procesadas:', categories.value); // Debug
        } catch (err) {
            error.value = err.message;
            console.error('Error cargando categorías:', err);
        } finally {
            loading.value = false;
        }
    };

    const loadModels = async () => {
        loading.value = true;
        error.value = null;
        try {
            const response = await axios.get('/api/models');
            // Extraer marcas únicas de los modelos
            const uniqueBrands = new Set();
            response.data.forEach((model) => {
                if (model.brand) uniqueBrands.add(model.brand);
            });
            brands.value = Array.from(uniqueBrands).map((brand) => ({
                title: brand,
                value: brand,
            }));
        } catch (err) {
            error.value = err.message;
            console.error('Error cargando modelos:', err);
        } finally {
            loading.value = false;
        }
    };

    const loadModelsByBrand = async (brand) => {
        loading.value = true;
        error.value = null;
        try {
            const response = await axios.get(`/api/models/brand/${brand}`);
            return response.data.map((model) => ({
                title: model.name,
                value: model.name,
            }));
        } catch (err) {
            error.value = err.message;
            console.error('Error cargando modelos por marca:', err);
            return [];
        } finally {
            loading.value = false;
        }
    };

    const getPartById = async (id) => {
        loading.value = true;
        error.value = null;
        try {
            const response = await axios.get(`/api/parts/${id}`);
            return response.data;
        } catch (err) {
            error.value = err.message;
            console.error('Error cargando parte:', err);
            return null;
        } finally {
            loading.value = false;
        }
    };

    const getCategoryById = async (id) => {
        loading.value = true;
        error.value = null;
        try {
            const response = await axios.get(`/api/categories/${id}`);
            return response.data;
        } catch (err) {
            error.value = err.message;
            console.error('Error cargando categoría:', err);
            return null;
        } finally {
            loading.value = false;
        }
    };

    const getModelById = async (id) => {
        loading.value = true;
        error.value = null;
        try {
            const response = await axios.get(`/api/models/${id}`);
            return response.data;
        } catch (err) {
            error.value = err.message;
            console.error('Error cargando modelo:', err);
            return null;
        } finally {
            loading.value = false;
        }
    };

    // Inicializar datos
    const initializeData = async () => {
        await Promise.all([loadParts(), loadCategories(), loadModels()]);
    };

    return {
        // Estado
        parts,
        categories,
        brands,
        loading,
        error,
        // Acciones
        loadParts,
        loadCategories,
        loadModels,
        loadModelsByBrand,
        getPartById,
        getCategoryById,
        getModelById,
        initializeData,
    };
});
