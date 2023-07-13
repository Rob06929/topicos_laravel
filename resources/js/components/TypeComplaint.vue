<template>
    <div class="container">
        <div class="row justify-content-center">

            <div class="flex-col">
                <div class="flex-1 flex items-center justify-between m-4">
                    <!-- <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded" @click="createComplaints" >Crear Tipo</button> -->
                    <modal-create-complaints @updateArrayTypeComplaints="getTypesComplaints"/>
                </div>
                <div class="flex-1 flex items-center justify-center m-4">
                    <h1 class="text-3xl font-bold">Tipo de Denuncias</h1>

                </div>

                <div class="flex-1 m-4">
                    <div class="col-md-8">
                        <div class="card">

                            <div class="w-full  text-center">
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 font-bold border-2 bg-green-500 text-white">#</th>
                                            <th class="px-4 py-2 font-bold border-2 bg-green-500 text-white">Nombre</th>
                                            <th class="px-4 py-2 font-bold border-2 bg-green-500 text-white">Descripcion
                                            </th>
                                            <th class="px-4 py-2 font-bold border-2 bg-green-500 text-white">Area</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in arrayTypesComplaints" :key="item.id">
                                            <td class="border px-4 py-2">{{ index }}</td>
                                            <td class="border px-4 py-2">{{item.nombre}}</td>
                                            <td class="border px-4 py-2">{{item.descripcion}}</td>
                                            <td class="border px-4 py-2">{{item.area_name}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            arrayTypesComplaints: {},
        }
    },
    mounted() {
        console.log('Component mounted.');
        let me= this;
        me.getTypesComplaints();
    },
    methods: {
    getTypesComplaints() {
      axios.post('/type_complaint/getTypes', {
        // Cuerpo de la solicitud POST
        // Puedes agregar los datos que deseas enviar en el cuerpo de la solicitud aquí
      })
        .then(response => {
          // Manejar la respuesta de la solicitud POST exitosa
          console.log(response.data);
          let me= this;
          me.arrayTypesComplaints= response.data;
        })
        .catch(error => {
          // Manejar el error de la solicitud POST
          console.error(error);
        });
    },
    createComplaints(){
        let me= this;
        console.log('entra a crear denuncia');
    }
  }
}
</script>
