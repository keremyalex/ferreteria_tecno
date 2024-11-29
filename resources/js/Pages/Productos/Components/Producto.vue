<script setup>

import Cart from '@/Components/Cart.vue';
import CustomButton from '@/Components/CustomButton.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    producto: {
        type: Object,
        required: true
    }
});

const { auth } = usePage().props;

const form = useForm({});

const submit = () => {
    if (confirm("¿Estás seguro de que deseas eliminar esta producto?")) {
        form.delete(route('productos.destroy', props.producto));
    }
};

const esAdmin = computed(() => {
    if(auth.user) {
        return auth.user.es_administrador;
    }
    return false; // Example: return auth.user.es_cliente;
});

</script>


<template>
    <div class="flex m-2 bg-white border rounded-lg">
        <img :src="producto.imagen" class="rounded-l-lg" width="200" alt="{{producto.nombre}}">
        <div>
            <Link class="px-3 pt-3 font-bold uppercase hover:text-xl hover:text-red-800 hover:cursor-pointer"
                :href="route('productos.show', producto)">{{ producto.nombre }} - {{ producto.tamaño }}</Link>
            <!-- {{route('pizzas.show', pizza.id)}} -->
            <p class="px-3 "><span class="font-bold">Cantidad:</span> {{ producto.cantidad }} Unit.</p>
            <p class="px-3 "><span class="font-bold">Precio:</span> {{ producto.precio }} Bs.</p>
            <p class="px-3 "><span class="font-bold">Categoría:</span> {{ producto.categoria }}</p>
            <p class="px-3 lowercase ">
                <span class="font-bold capitalize">Descripción: </span>
                {{ producto.descripcion }}
            </p>

            <Link class="inline-block p-5 m-3 bg-red-800 rounded-lg hover:bg-red-700" href="#">
            <div class="flex justify-center">
                <p class="text-white">+</p>
                <Cart :producto="producto" />
            </div>
            </Link>

            <div v-if="esAdmin">
                <div class="flex justify-around m-3">
                    <div class="p-2 bg-green-800 rounded-lg">
                        <Link :href="route('productos.edit', producto)">
                        <p class="text-sm text-white uppercase"> Editar </p>
                        </Link>
                    </div>

                    <form @submit.prevent="submit">
                        <CustomButton class="mx-2">
                            Eliminar
                        </CustomButton>
                    </form>
                </div>
            </div>


        </div>
    </div>
</template>
