<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ProductoForm from './Components/ProductoForm.vue';

defineProps({
    producto: {
        type: Object,
        required: true
    }
})

</script>

<template>
    <Head title="Editar Pizza" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Editar Producto: {{ producto.nombre }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <ProductoForm
                            :producto="producto"
                        />
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>


