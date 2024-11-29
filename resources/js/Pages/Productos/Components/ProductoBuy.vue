<script setup>
import CustomButton from '@/Components/CustomButton.vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';


const props = defineProps({
    producto: {
        type: Object,
        required: true
    },
    // tamano: {
    //     type: Object,
    //     required: true
    // },
    // categoria: {
    //     type: Object,
    //     required: true
    // }
});

const form = useForm({
    cantidad: 1,
    producto_id: props.producto.id,
});

const submit = () => {
    form.post(route('carrito.store'), {
        onFinish: () => form.reset('cantidad'),
    });
};

</script>
<template>
    <div class="p-6 bg-white border-b border-gray-200 lg:p-8">
        <!-- {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}} -->

        <div class="flex m-2 bg-white border rounded-lg">
            <img :src="producto.imagen" class="rounded-l-lg" width="500" :alt="producto.nombre">
            <div class="flex flex-col justify-center ">
                <p class="px-3 pt-3 text-xl font-bold uppercase ">{{ producto.nombre }} - {{ producto.tamaño }}</p>
                <p class="px-3 "><span class="font-bold">Precio:</span> {{ producto.precio }} Bs.</p>
                <p class="px-3 lowercase ">
                    <span class="font-bold capitalize">Descripción: </span>
                    {{ producto.descripcion }}
                </p>
                <p class="px-3 lowercase ">
                    <span class="font-bold capitalize">Categoria: </span>
                    {{ producto.categoria }}
                </p>

                <form @submit.prevent="submit" class="px-3 mt-5">
                    <InputLabel for="cantidad" value="Cantidad" />

                    <TextInput id="cantidad" type="number" class="block w-full my-1" v-model.number="form.cantidad" required autofocus/>

                    <InputError class="m-2" :message="form.errors.cantidad" />
                    <CustomButton>
                        Agregar al carrito
                    </CustomButton>
                </form>

                <!-- {{-- formulario para cantidad de compra --}} -->
            <!-- <form wire:submit.prevent='carrito' class="px-3 mt-5">
                <x-label for="cantidad" value="{{ __('Cantidad') }}"/>
                <x-input type="number" wire:model="cantidad" id="cantidad" min="1" value="{{old('cantidad')}}"/>
                <x-button>
                    Agregar al carrito
                </x-button>
            </form> -->

            </div>
        </div>

    </div>
</template>
