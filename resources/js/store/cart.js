import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export const useCartStore = defineStore('cart', () => {
    // Estado
    const items = ref([]);
    const loading = ref(false);
    const error = ref(null);

    // Validación de UUID
    const isValidUUID = (uuid) => {
        const uuidRegex = /^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i;
        return uuidRegex.test(uuid);
    };

    // Getters
    const totalItems = computed(() => {
        return items.value.reduce((total, item) => total + item.quantity, 0);
    });

    const totalPrice = computed(() => {
        return items.value.reduce((total, item) => total + item.price * item.quantity, 0);
    });

    // Acciones
    const addItem = (product) => {
        console.log('Añadiendo producto al carrito:', product);

        // Validar que el ID es un UUID válido
        if (!isValidUUID(product.id)) {
            console.error('ID de producto inválido:', product.id);
            throw new Error('ID de producto inválido');
        }

        const existingItem = items.value.find((item) => item.id === product.id);

        if (existingItem) {
            if (existingItem.quantity < product.stock) {
                existingItem.quantity++;
            }
        } else {
            const newItem = {
                id: product.id,
                name: product.name,
                code: product.code,
                part_code: product.part_code || product.code,
                price: parseFloat(product.price),
                stock: parseInt(product.stock),
                image_url: product.image_url,
                quantity: 1,
            };

            console.log('Nuevo item añadido:', newItem);
            items.value.push(newItem);
        }

        saveCart();
    };

    const removeItem = (productId) => {
        if (!isValidUUID(productId)) {
            console.error('ID de producto inválido:', productId);
            return;
        }
        items.value = items.value.filter((item) => item.id !== productId);
        saveCart();
    };

    const updateQuantity = (productId, quantity) => {
        if (!isValidUUID(productId)) {
            console.error('ID de producto inválido:', productId);
            return;
        }
        const item = items.value.find((item) => item.id === productId);
        if (item) {
            item.quantity = Math.min(quantity, item.stock);
            saveCart();
        }
    };

    const clearCart = () => {
        items.value = [];
        saveCart();
    };

    // Persistencia del carrito
    const saveCart = () => {
        localStorage.setItem('cart', JSON.stringify(items.value));
    };

    const loadCart = () => {
        const savedCart = localStorage.getItem('cart');
        if (savedCart) {
            const parsedCart = JSON.parse(savedCart);
            // Validar que todos los IDs son UUIDs válidos
            if (parsedCart.every((item) => isValidUUID(item.id))) {
                items.value = parsedCart;
            } else {
                console.error('Carrito inválido encontrado en localStorage');
                items.value = [];
                saveCart();
            }
        }
    };

    // Inicializar carrito
    loadCart();

    return {
        items,
        loading,
        error,
        totalItems,
        totalPrice,
        addItem,
        removeItem,
        updateQuantity,
        clearCart,
        saveCart,
    };
});
