<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({

    producto: {
        type: Object,
        required: false
    }

})

const form = useForm({
    nombre: '',
    imagen: null,
    tamaño: '',
    precio: '',
    cantidad: '',
    descripcion: '',
    categoria: '',
    //foto_preview: null,
});

const buttonLabel = props.producto ? 'Editar producto' : 'Registrar producto';

// Asignar valores si existe `pizza`

if (props.producto) {
    form.nombre = props.producto.nombre;
    form.imagen = props.producto.imagen;
    form.tamaño = props.producto.tamaño;
    form.precio = props.producto.precio;
    form.cantidad = props.producto.cantidad;
    form.descripcion = props.producto.descripcion;
    form.categoria = props.producto.categoria;
    //form.foto_preview = props.producto.imagen_url;
}

const handleFileChange = (e) => {
    form.foto = e.target.files[0];
    form.foto_preview = URL.createObjectURL(e.target.files[0]);
};

const submit = () => {
    form.precio = parseFloat(form.precio);
    if (props.producto) {
        form.put(route('productos.update', props.producto.id));
    } else {
        form.post(route('productos.store'));
    }
};





</script>

<template>

    <div class="p-6 bg-white border-b border-gray-200 lg:p-8">
        <div class="flex justify-between">
            <h1 class="mt-3 text-2xl font-medium text-gray-900">
                Formulario de productos
            </h1>
        </div>

        <div class="flex flex-col justify-center">
            <form @submit.prevent='submit'>
                <div>
                    <InputLabel for="nombre" value="Nombre" />

                    <TextInput id="nombre" type="text" class="block w-full mt-1" v-model="form.nombre" required
                        autofocus />

                    <InputError class="mt-2" :message="form.errors.nombre" />
                </div>

                <div>
                    <InputLabel for="imagen" value="Imagen" />

                    <TextInput id="imagen" type="text" class="block w-full mt-1" v-model="form.imagen" required
                        autofocus />

                    <InputError class="mt-2" :message="form.errors.imagen" />
                </div>

                <div>
                    <InputLabel for="tamaño" value="Tamaño" />

                    <TextInput id="tamaño" type="text" class="block w-full mt-1" v-model="form.tamaño" required
                        autofocus />

                    <InputError class="mt-2" :message="form.errors.tamaño" />
                </div>

                <div class="mt-4">
                    <InputLabel for="precio" value="Precio" />

                    <TextInput id="precio" type="text" class="block w-full mt-1" v-model.number="form.precio"
                        required />

                    <InputError class="mt-2" :message="form.errors.precio" />
                </div>

                <div class="mt-4">
                    <InputLabel for="cantidad" value="Cantidad" />

                    <TextInput id="cantidad" type="text" class="block w-full mt-1" v-model.number="form.cantidad"
                        required />

                    <InputError class="mt-2" :message="form.errors.cantidad" />
                </div>

                <div class="mt-4">
                    <InputLabel for="descripcion" value="Descripcion" />

                    <TextInput id="descripcion" type="text" class="block w-full mt-1" v-model="form.descripcion"
                        required />

                    <InputError class="mt-2" :message="form.errors.descripcion" />
                </div>

                <div class="mt-4">
                    <InputLabel for="categoria" value="Categoria" />

                    <TextInput id="categoria" type="text" class="block w-full mt-1" v-model="form.categoria"
                        required />

                    <InputError class="mt-2" :message="form.errors.categoria" />
                </div>

                <!-- <div class="mt-4">
                    <InputLabel for="foto" value="Foto del Producto" />

                    <input id="foto" type="file" name="foto" class="block w-full mt-1" accept="image/*"
                        @change="handleFileChange" />
                </div>

                <div v-if="form.foto_preview" class="w-1/4 mt-4">
                    <p>Preview de la imagen:</p>
                    <img width="200" :src="form.foto_preview" />
                </div> -->


                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        {{ buttonLabel }}
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>


</template>
