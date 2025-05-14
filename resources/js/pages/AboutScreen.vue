<template>
    <CarouselImages id="init" :slides="slides"></CarouselImages>
    <div class="h-36 w-full bg-[url('/images/fond_blue.jpg')] bg-cover bg-center"></div>
    <div class="flex w-full flex-col items-center justify-center gap-32 bg-white px-8 py-14">
        <div id="values"></div>
        <div class="flex w-full items-center justify-center gap-4 lg:w-1/2">
            <div class="h-0.5 w-full bg-gray-300"></div>
            <span class="text-3xl font-semibold whitespace-nowrap text-gray-400">Nuestros valores</span>
            <div class="h-0.5 w-full bg-gray-300"></div>
        </div>
        <div class="w-full p-8">
            <div class="flex flex-col items-center gap-12 lg:flex-row lg:justify-around">
                <div class="flex w-72 flex-col" v-for="(value, i) in values" :key="i">
                    <div
                        class="roboto flex min-h-64 w-full flex-col items-center justify-center gap-6 rounded-t-xl bg-[#F8F8FF] px-6 py-6 text-center"
                    >
                        <span class="text-xl font-bold">{{ value.title }}</span>
                        <span>{{ value.text }}</span>
                    </div>
                    <div class="flex w-full items-center justify-center bg-blue-400 py-2">
                        <v-icon :icon="value.icon" color="white" size="x-large" />
                    </div>
                </div>
            </div>
        </div>
        <div id="history"></div>
        <div class="flex w-full items-center justify-center gap-4 lg:w-1/2">
            <div class="h-0.5 w-full bg-gray-300"></div>
            <span class="text-3xl font-semibold whitespace-nowrap text-gray-400">Nuestra historia</span>
            <div class="h-0.5 w-full bg-gray-300"></div>
        </div>
        <HistoryLine></HistoryLine>
    </div>

    <div class="h-32 w-full bg-transparent"></div>

    <div id="footer" class="flex w-full justify-around bg-[#696969] py-8">
        <div class="roboto flex flex-col gap-8">
            <span class="text-lg font-bold text-[#DCDCDC]">Información de contacto</span>
            <div class="flex flex-col gap-2">
                <div class="flex gap-2 text-[#bfbfbf]">
                    <v-icon icon="mdi-email" color="#bfbfbf" />
                    <span>autonova@autonova.es</span>
                </div>
                <div class="flex gap-2 text-[#bfbfbf]">
                    <v-icon icon="mdi-phone" color="#bfbfbf" />
                    <span>923 435 223</span>
                </div>
                <div class="flex gap-2 text-[#bfbfbf]">
                    <v-icon icon="mdi-map-marker" color="#bfbfbf" />
                    <span>Calle de Alcalá, 123, 28009 Madrid, España </span>
                </div>
            </div>
        </div>
        <div class="roboto flex flex-col gap-8">
            <span class="text-lg font-bold text-[#DCDCDC]">Enlaces</span>
            <div class="flex flex-col gap-2">
                <div class="flex gap-2 text-[#bfbfbf]">
                    <v-icon icon="mdi-arrow-right" color="#bfbfbf" />
                    <a href="#init" class="text-md text-[#bfbfbf] underline">Inicio</a>
                </div>
                <div class="flex gap-2 text-[#bfbfbf]">
                    <v-icon icon="mdi-arrow-right" color="#bfbfbf" />
                    <a href="#values" class="text-md text-[#bfbfbf] underline">Nuestros valores</a>
                </div>
                <div class="flex gap-2 text-[#bfbfbf]">
                    <v-icon icon="mdi-arrow-right" color="#bfbfbf" />
                    <a href="#history" class="text-md text-[#bfbfbf] underline">Nuestra historia</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import CarouselImages from '@/components/CarouselImages.vue';
import HistoryLine from '@/components/HistoryLine.vue';
import { computed } from 'vue';

//COMPUTED
const slides = computed(() => [
    {
        imageUrl: '/images/fabric.jpg',
        title: 'Quiénes somos',
        text: 'En Autonova Parts nos dedicamos a ofrecer piezas de recambio de alta calidad para vehículos de todo tipo. Con más de 20 años de experiencia, trabajamos con los mejores fabricantes para asegurar que nuestros productos sean duraderos y confiables. Nuestro objetivo es que nuestros clientes encuentren todo lo que necesitan en un solo lugar, con el mejor servicio y al mejor precio.',
    },
    {
        imageUrl: '/images/robotics_automation.jpg',
        title: 'Catálogo de Productos',
        text: 'En nuestro catálogo encontrarás una variedad de repuestos y accesorios para vehículos. Cada producto ha sido seleccionado cuidadosamente para garantizar su calidad y rendimiento. Ya sea que necesites piezas para un coche, moto o camión, tenemos lo que buscas. Navega por nuestras categorías y encuentra la pieza ideal para tu vehículo.',
    },
    {
        imageUrl: '/images/transform_car.jpg',
        title: 'Nuestra Misión',
        text: 'Nuestra misión es ser el principal proveedor de autopartes en línea, brindando a nuestros clientes productos de calidad superior a precios competitivos. Creemos en la satisfacción total del cliente, por lo que ofrecemos soporte personalizado y un proceso de compra fácil y rápido. Estamos comprometidos con la excelencia y la innovación en todo lo que hacemos.',
    },
]);

const values = computed(() => [
    {
        icon: 'mdi-wrench',
        title: 'Compromiso con la calidad',
        text: 'Seleccionamos cuidadosamente cada repuesto y trabajamos con proveedores de confianza para asegurar durabilidad y rendimiento en cada pieza.',
    },
    {
        icon: 'mdi-chat',
        title: 'Transparencia',
        text: 'Creemos en la honestidad: precios claros, condiciones justas y atención directa sin letra pequeña.',
    },
    {
        icon: 'mdi-handshake',
        title: 'Atención al cliente',
        text: 'Nuestro equipo está siempre disponible para ayudarte a encontrar lo que necesitas y resolver tus dudas con rapidez y cercanía.',
    },
    {
        icon: 'mdi-rocket-launch',
        title: 'Innovación constantee',
        text: 'Nos adaptamos a las nuevas tecnologías del sector automotriz para ofrecerte soluciones modernas y eficientes.',
    },
]);
</script>

<style scoped>
.roboto {
    font-family: 'Roboto', sans-serif;
    font-optical-sizing: auto;
    font-style: normal;
    font-variation-settings: 'wdth' 100;
}
</style>
