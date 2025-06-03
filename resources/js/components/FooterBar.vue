<template>
    <div class="bg-[#696969] py-6">
        <v-container>
            <v-row class="justify-center">
                <!-- Información de contacto -->
                <v-col cols="12" md="5" class="px-6">
                    <div class="roboto flex flex-col gap-4">
                        <span class="text-lg font-bold text-[#DCDCDC]">Información de contacto</span>
                        <div class="flex flex-col gap-3">
                            <v-btn variant="text" class="justify-start px-0 text-[#bfbfbf] hover:text-white" href="mailto:autonova@autonova.es">
                                <v-icon icon="mdi-email" class="mr-3" />
                                <span class="text-base">autonova@autonova.es</span>
                            </v-btn>
                            <v-btn variant="text" class="justify-start px-0 text-[#bfbfbf] hover:text-white" href="tel:+34923435223">
                                <v-icon icon="mdi-phone" class="mr-3" />
                                <span class="text-base">923 435 223</span>
                            </v-btn>
                            <v-btn
                                variant="text"
                                class="justify-start px-0 text-[#bfbfbf] hover:text-white"
                                href="https://maps.google.com/?q=Calle+de+Alcalá,+123,+28009+Madrid"
                                target="_blank"
                            >
                                <v-icon icon="mdi-map-marker" class="mr-3" />
                                <span class="text-base">Calle de Alcalá, 123, 28009 Madrid, España</span>
                            </v-btn>
                        </div>
                    </div>
                </v-col>

                <v-divider vertical class="md-flex mx-4 hidden"></v-divider>

                <!-- Enlaces rápidos -->
                <v-col cols="12" md="5" class="px-6">
                    <div class="roboto flex flex-col gap-4">
                        <span class="text-lg font-bold text-[#DCDCDC]">Enlaces rápidos</span>
                        <div class="flex flex-col gap-3">
                            <v-btn variant="text" class="justify-start px-0 text-[#bfbfbf] hover:text-white" @click="application.loadAbout">
                                <v-icon icon="mdi-home" class="mr-3" />
                                <span class="text-base">Inicio</span>
                            </v-btn>
                            <v-btn variant="text" class="justify-start px-0 text-[#bfbfbf] hover:text-white" @click="application.loadServices">
                                <v-icon icon="mdi-cog" class="mr-3" />
                                <span class="text-base">Servicios</span>
                            </v-btn>
                            <v-btn variant="text" class="justify-start px-0 text-[#bfbfbf] hover:text-white" @click="application.loadItems">
                                <v-icon icon="mdi-package-variant" class="mr-3" />
                                <span class="text-base">Catálogo</span>
                            </v-btn>
                        </div>
                    </div>
                </v-col>
            </v-row>

            <!-- Copyright -->
            <v-divider class="border-opacity-10 my-4"></v-divider>
            <v-row>
                <v-col cols="12" class="text-center">
                    <div class="text-sm text-[#bfbfbf]">© {{ new Date().getFullYear() }} Autonova Parts. Todos los derechos reservados.</div>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script setup>
import { useApplicationStore } from '@/store/application';
const application = useApplicationStore();
</script>

<style scoped>
.v-btn {
    text-transform: none;
    letter-spacing: normal;
    min-height: 40px;
}

.v-btn:hover {
    transform: translateX(5px);
    transition: transform 0.2s ease;
}

.v-divider {
    border-color: rgba(255, 255, 255, 0.1);
}
</style>
