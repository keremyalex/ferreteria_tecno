<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
//import VisitasFooter from '@/Components/VisitasFooter.vue';
import { Head } from '@inertiajs/vue3';
import ProductoBuy from './Components/ProductoBuy.vue';

//import PizzaBuy from './Components/PizzaBuy.vue';


defineProps({
    producto: {
        type: Object,
        required: true
    },
    // visitas: {
    //     type: Object,
    //     required: true
    // },
    tamaño: {
        type: Object,
        required: true
    },
    categoria: {
        type: Object,
        required: true
    }
});

</script>


<template>

    <Head title="Producto" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Producto: {{ producto.nombre }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- <PizzaBuy :producto="producto"/> -->
                        <ProductoBuy :producto="producto"/>
                    </div>
                </div>
            </div>
        </div>

        <!-- <VisitasFooter :visitas="visitas.cant" /> -->

    </AuthenticatedLayout>
</template>
