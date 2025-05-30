<template>
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

<script setup></script>
