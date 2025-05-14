<template>
    <v-carousel height="700" progress="primary" hide-delimiter-background cycle>
        <v-carousel-item v-for="(slide, i) in slides" :key="i">
            <v-sheet height="100%">
                <div
                    class="d-flex fill-height align-center justify-center"
                    :style="`background-image: url(${slide.imageUrl}); background-size: cover; background-position: center;`"
                >
                    <div class="w-3/4 rounded-lg bg-[rgba(0,0,0,0.4)] py-9">
                        <div class="flex flex-col items-center justify-center gap-12 px-10 text-center text-white">
                            <div class="roboto text-4xl font-bold">{{ slide.title }}</div>
                            <div class="roboto text-xl">{{ slide.text }}</div>
                        </div>
                    </div>
                </div>
            </v-sheet>
        </v-carousel-item>
    </v-carousel>
</template>
<script setup>
// El objeto tiene que tener los campos imageUrl, title y text para que funcione.
defineProps({
    slides: {
        type: Object,
        required: true,
    },
});
</script>

<style scoped>
:deep(.v-carousel__controls .v-icon) {
    color: gray !important;
}

:deep(.v-carousel__controls .v-btn--active .v-icon) {
    color: #3b82f6 !important;
}

.roboto {
    font-family: 'Roboto', sans-serif;
    font-optical-sizing: auto;
    font-style: normal;
    font-variation-settings: 'wdth' 100;
}
</style>
