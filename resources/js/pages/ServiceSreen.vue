<template>
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-white px-4 py-16 sm:px-6 lg:px-8">
        <!-- Título Principal con decoración -->
        <div class="relative mb-32 text-center">
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="h-1 w-32 rounded-full bg-gradient-to-r from-blue-500 via-blue-400 to-blue-500 opacity-30"></div>
            </div>
            <h1 class="relative bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-5xl font-bold text-transparent sm:text-6xl md:text-7xl">
                Nuestros Servicios
            </h1>
            <div class="mt-4 flex items-center justify-center space-x-2">
                <div class="h-2 w-2 rounded-full bg-blue-400"></div>
                <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                <div class="h-2 w-2 rounded-full bg-blue-400"></div>
            </div>
            <p class="mx-auto mt-8 max-w-3xl text-xl leading-relaxed font-light text-gray-600">
                Soluciones integrales para el mantenimiento y reparación de tu vehículo
            </p>
        </div>

        <!-- Grid de Servicios -->
        <div class="mx-auto my-12 max-w-7xl">
            <div class="flex flex-wrap justify-center gap-10">
                <div
                    v-for="service in services"
                    :key="service.title"
                    class="group perspective w-full max-w-sm sm:w-[calc(50%-20px)] lg:w-[calc(33.333%-27px)]"
                >
                    <div class="transform-style-3d relative h-[320px] w-full transition-transform duration-500 group-hover:rotate-y-180">
                        <!-- Frente de la tarjeta -->
                        <div
                            class="absolute flex h-full w-full flex-col items-center justify-center rounded-3xl border border-gray-100 bg-white p-8 shadow-2xl backface-hidden"
                        >
                            <div
                                class="mb-8 flex h-24 w-24 transform items-center justify-center rounded-3xl bg-gradient-to-br from-blue-500 to-blue-600 transition-transform duration-300 group-hover:scale-110"
                            >
                                <v-icon :icon="service.icon" size="48" color="white" />
                            </div>
                            <h3
                                class="bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-center text-2xl font-bold text-gray-900 text-transparent"
                            >
                                {{ service.title }}
                            </h3>
                        </div>

                        <!-- Reverso de la tarjeta -->
                        <div
                            class="absolute flex h-full w-full rotate-y-180 flex-col items-center justify-center rounded-3xl bg-gradient-to-br from-blue-500 to-blue-600 p-8 shadow-2xl backface-hidden"
                        >
                            <div class="mb-6 h-1 w-16 rounded-full bg-white/30"></div>
                            <p class="text-center text-lg leading-relaxed font-light text-white">
                                {{ service.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de CTA -->
        <div class="mt-32 flex justify-center">
            <v-btn color="primary" size="large" prepend-icon="mdi-email" @click="openContactForm">¿Necesitas ayuda? Contáctanos </v-btn>
        </div>
    </div>
    <ContactForm v-model="showContactForm" />
</template>

<script setup>
import ContactForm from '@/components/ContactForm.vue';
import { ref } from 'vue';

const showContactForm = ref(false);

const openContactForm = () => {
    showContactForm.value = true;
};

const services = [
    {
        title: 'Venta de Repuestos Originales',
        description:
            'Amplio catálogo de piezas originales para todas las marcas y modelos de vehículos, garantizando la mejor calidad y compatibilidad.',
        icon: 'mdi-car-cog',
    },
    {
        title: 'Diagnóstico Electrónico',
        description: 'Tecnología de última generación para identificar y resolver problemas en tu vehículo con precisión y rapidez.',
        icon: 'mdi-tools',
    },
    {
        title: 'Soporte Técnico Postventa',
        description: 'Asesoramiento profesional y soporte continuo después de tu compra, asegurando tu completa satisfacción.',
        icon: 'mdi-headset',
    },
    {
        title: 'Entrega Rápida a Domicilio',
        description: 'Servicio de entrega express para que recibas tus repuestos cuando los necesites, con seguimiento en tiempo real.',
        icon: 'mdi-truck-delivery',
    },
];
</script>

<style>
.perspective {
    perspective: 1000px;
}

.transform-style-3d {
    transform-style: preserve-3d;
}

.backface-hidden {
    backface-visibility: hidden;
}

.rotate-y-180 {
    transform: rotateY(180deg);
}

@keyframes gradient {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}
</style>
