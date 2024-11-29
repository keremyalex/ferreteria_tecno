<script setup>
import { Link } from '@inertiajs/vue3';
import Producto from './Producto.vue';

defineProps({
    productos: {
        type: Array,
        required: true
    },
});

</script>

<template>
    <div class="p-6 bg-white border-b border-gray-200 lg:p-8">

    <div class="flex justify-between">
        <h1 class="mt-3 text-2xl font-medium text-gray-900">
            Menú de Productos
        </h1>
        <Link class="p-2 m-5 bg-red-800 rounded-lg hover:bg-red-700" :href="route('productos.create')">
            <p class="text-white">+ Nuevo Producto</p>
        </Link>
    </div>

    <div class="flex flex-col lg:grid lg:grid-cols-2 lg:grid-rows-5">
        <Producto v-for="producto in productos" :key="producto.id" :producto="producto" />
    </div>

    </div>
</template>
