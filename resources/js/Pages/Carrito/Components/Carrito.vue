<script setup>
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';


const props = defineProps({
    pedido: {
        type: Object,
        required: true
    },
    detalles: {
        type: Array,
        required: true
    },
    total: {
        type: Number,
        required: true
    }
})

const qr = ref([])


const checkout = () => {

    try {
        const url = `/carrito/${props.pedido.id}/checkout`;
        axios.get(url)
        .then(response => {
            qr.value = response.data.qr;
            console.log(response.data.qr);
        });
    } catch (error) {
        console.log(error);
    }




}

const del = (detalle) => {
    const form = useForm({
        detalle: detalle
    })

    form.delete(route('carrito.destroy', detalle));

}

</script>

<template>
    <div class="p-6 bg-white border-b border-gray-200 lg:p-8">
        <div class="bg-gray-200 rounded-lg">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="px-3 py-3 ">Producto</th>
                        <th class="px-3 py-3 ">Cantidad</th>
                        <th class="px-3 py-3 ">Precio Unitario</th>
                        <th class="px-3 py-3 ">Subtotal</th>
                        <th class="px-3 py-3 ">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t border-gray-200" v-for="detalle in detalles" :key="detalle.id">
                        <td class="px-6 py-4 text-center ">{{ detalle.producto.nombre }}</td>
                        <td class="px-6 py-4 text-center ">{{ detalle.cantidad }}</td>
                        <td class="px-6 py-4 text-center ">{{ detalle.producto.precio }} Bs.</td>
                        <td class="px-6 py-4 text-center ">{{ detalle.precio }} Bs.</td>
                        <td class="px-6 py-4 text-center ">
                            <button
                                @click="del(detalle)"
                                class="px-4 py-2 font-bold text-white bg-red-800 rounded-full hover:bg-red-700"
                            >
                                X
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-end mt-8">

            <div class="p-3 bg-gray-200 rounded-lg">
                <p>
                    <span class="font-bold ">Total: </span>
                    <span class="">{{ total }} Bs.</span>
                </p>
                <div class="p-3" v-if="detalles != []">
                    <button @click="checkout()" class="p-2 text-white bg-green-800 rounded-lg hover:bg-green-600">
                        Realizar pedido
                    </button>
                </div>
            </div>
        </div>

        <div class="flex justify-center" v-if="qr.length > 0">
            <img :src="qr" alt="qr">
        </div>

    </div>
</template>
