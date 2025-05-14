<template>
    <v-timeline>
        <v-timeline-item v-for="(item, i) in items" :key="i" :dot-color="item.color" :icon="item.icon" fill-dot>
            <v-card class="w-96">
                <v-card-title :class="['text-h6', `bg-${item.color}`, 'text-white']">
                    {{ item.title }}
                </v-card-title>
                <v-card-text class="bg-white py-6 text-black">
                    <p class="text-lg font-bold">
                        {{ item.text }}
                    </p>
                </v-card-text>
            </v-card>
        </v-timeline-item>
    </v-timeline>
</template>
<script setup>
import { computed } from 'vue';

const items = computed(() => [
    {
        color: 'red-lighten-2',
        icon: 'mdi-star',
        title: '2010',
        text: 'Fundación de Autonova Parts',
    },
    {
        color: 'purple-lighten-2',
        icon: 'mdi-book-variant',
        title: '2015',
        text: 'Expansión a nivel nacional',
    },
    {
        color: 'green-lighten-1',
        icon: 'mdi-airballoon',
        title: '2020',
        text: 'Lanzamiento de tienda online',
    },
    {
        color: 'indigo-lighten-2',
        icon: 'mdi-layers-triple',
        title: '2023',
        text: '+10.000 clientes satisfechos como podria hacer esto',
    },
]);
</script>
