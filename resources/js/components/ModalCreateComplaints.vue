<template>
    <div>
        <!-- Botón para abrir el modal -->
        <button @click="openModal" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Crear
            Tipo</button>

        <!-- Modal -->
        <div v-if="isOpen" class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                <h2 class="text-2xl font-bold mb-4">Crear Tipo De Denuncia</h2>

                <div class="mb-4">
                    <label class="text-lg font-bold" for="nombre">Nombre</label>
                    <input type="text" id="nombre" v-model="nombre" class="w-full p-2 border border-gray-300 rounded">
                </div>

                <div class="mb-4">
                    <label class="text-lg font-bold" for="descripcion">Descripción</label>
                    <input type="text" id="descripcion" v-model="descripcion"
                        class="w-full p-2 border border-gray-300 rounded">
                </div>

                <div class="mb-4">
                    <v-select v-model="areaSelected" :reduce="(option) => option.id" :options="arrayArea" label="nombre"
                        track-by="id"></v-select>
                </div>

                <!-- <div>
                    <h3 class="text-xl font-bold mb-2">Seleccionar Area:</h3>
                    <v-select v-model="areaSelected" :options="arrayArea" label="nombre" track-by="id" class="w-full"
                        :class="[{ 'border-red-500': hasError }]" :styles="{ 'border-color': hasError ? 'red' : 'gray' }">
                        <template slot="no-options">No hay opciones disponibles</template>
                    </v-select>
                    <p class="text-red-500 text-sm mt-1" v-if="hasError">{{ errorText }}</p>
                </div> -->
                <button @click="guardar"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Registrar</button>
                <button @click="closeModal"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded ml-4">Cancelar</button>
            </div>
        </div>
    </div>
</template>
  
<script>

import VueSweetalert2 from 'vue-sweetalert2';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';
import vSelect from 'vue-select';

Vue.component('v-select', vSelect);
Vue.use(VueSweetalert2);
export default {
    data() {
        return {
            isOpen: false,
            nombre: '',
            descripcion: '',
            arrayArea: {},
            areaSelected: {},
        };
    },
    mounted() {
        let me = this;
        me.getTypeArea();
    },
    methods: {
        openModal() {
            this.isOpen = true;
        },
        closeModal() {
            this.isOpen = false;
            this.nombre = '';
            this.descripcion = '';
        },
        guardar() {
            // Aquí puedes implementar la lógica para guardar los datos ingresados en los inputs
            console.log('Guardar', this.nombre, this.descripcion, this.areaSelected);
            let me = this;
            if (me.nombre == '' || me.descripcion == '') {
                this.$swal.fire({
                    icon: 'warning',
                    title: 'Error',
                    text: 'Vuelva a intentarlo.',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#FF8800'
                });
            } else {
                axios.post('/type_complaint/store', {
                    nombre: me.nombre,
                    descripcion: me.descripcion,
                    id_area: me.areaSelected,
                    // Cuerpo de la solicitud POST
                    // Puedes agregar los datos que deseas enviar en el cuerpo de la solicitud aquí
                })
                    .then(response => {
                        // Manejar la respuesta de la solicitud POST exitosa
                        console.log(response.data);
                        
                        this.$emit('updateArrayTypeComplaints');   
                        // let me = this;
                        // me.arrayArea = response.data;
                        this.$swal.fire({
                            icon: 'success',
                            title: 'Creado correctamente!!!',
                            // confirmButtonColor: '#ff9900',
                            customClass: {
                                confirmButton: 'bg-green-500 hover:bg-green-600',
                            },
                        });
                    })
                    .catch(error => {
                        // Manejar el error de la solicitud POST
                        console.error(error);
                        this.$swal.fire({
                            icon: 'warning',
                            title: 'Error',
                            text: 'Vuelva a intentarlo.',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#FF8800'
                        });
                    });

                this.closeModal();
            }

        },
        getTypeArea() {
            axios.post('/getArea', {
                // Cuerpo de la solicitud POST
                // Puedes agregar los datos que deseas enviar en el cuerpo de la solicitud aquí
            })
                .then(response => {
                    // Manejar la respuesta de la solicitud POST exitosa
                    // console.log(response.data);
                    let me = this;
                    me.arrayArea = response.data;
                })
                .catch(error => {
                    // Manejar el error de la solicitud POST
                    console.error(error);
                });
        },
    }
};
</script>
  