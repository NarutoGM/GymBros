<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import DarkButton from '@/Components/DarkButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputGroup from '@/Components/InputGroup.vue';
import InputError from '@/Components/InputError.vue';
import { ref } from 'vue';

const props = defineProps({
miembros:{type:Object},
membresias:{type:Object},
membresiasOfMiembros:{type:Object}
});

const form = useForm({
 dni:'', nombre: '', direccion: '', telefono: '', edad: '', nombreContacto: '', enfermedad: '', institucion: '', fechaRegistro: '', fechaInicio: '', fechaFin: '',membresias:[]

})

const title_form = ref(

  (props.miembros==null) ? 'Registrar un nuevo miembro' : 'Editar informacion de un miembro'

);

const req = ref('required');
const msj = ref('');
const classMsj = ref('hidden');
</script>
<script>
export default {
  props: ['miembros'], // Asegúrate de recibir el prop 'b' si es necesario
  methods: {
    isActivo(fechaInicio, fechaFin) {
      const hoy = new Date();
      return fechaInicio && fechaFin && new Date(fechaInicio) <= hoy && hoy <= new Date(fechaFin);
    },
    isVencido(fechaFin) {
      const hoy = new Date();
      return fechaFin && new Date(fechaFin) < hoy;
    },
    getStatusMessage(fechaInicio, fechaFin) {
      if (!fechaInicio) {
        return 'Asignar Matrícula';
      } else if (this.isActivo(fechaInicio, fechaFin)) {
        return 'Activo';
      } else if (this.isVencido(fechaFin)) {
        return 'RENOVAR';
      }
      return '';
    },
  },
};
</script>
<template>

	<Head title="MEMBRESIAS" />
	
	<AuthenticatedLayout>
		<template #header>
                {{ title_form }} 

            <div class="inline-flex overflow-hidden mb-4 w-full items-center justify-between">
                <NavLink :href="route('miembros.index')">
                    <DarkButton>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
</svg>

                    </DarkButton>
                  </NavLink>
            </div>


		</template>
        <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg p-4">
    <!-- Columna 1: Datos Personales -->
    <div class="space-y-0">
    <div class="min-w-0 font-bold text-gray-700 text-xl p-4 rounded-lg shadow-xs">
        <p class="mb-2">INFORMACIÓN PERSONAL:</p> <!-- Espacio debajo del título -->
    </div>

   
    <div class="min-w-0 px-4 rounded-lg shadow-xs">
        <form class="mt-6  space-y-3 max-w-xl">
            <div class="min-w-0  rounded-lg shadow-xs">
        <p class="font-medium">DNI:</p>
    </div> 


           <InputGroup :text="'DNI'" :required="'required'" v-model="form.dni">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
</svg>

        </InputGroup>
           <InputError :message="form.errors.dni"></InputError>

           <div class="min-w-0  rounded-lg shadow-xs">
        <p class="font-medium">DIRECCION:</p>
    </div> 
           <InputGroup :text="'DIRECCION:'" :required="'required'" v-model="form.direccion">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
</svg>


        </InputGroup>
           <InputError :message="form.errors.direccion"></InputError>

        </form>
    </div>


 
   
    <div class="min-w-0 p-4 rounded-lg shadow-xs">
        <p class="font-medium">DIRECCIÓN:</p>
        <p>{{ miembros.direccion }}</p>
    </div>
    <div class="min-w-0 p-4 rounded-lg shadow-xs">
        <p class="font-medium">EDAD:</p>
        <p>{{ miembros.edad }}</p>
    </div>
    <div class="min-w-0 p-4 rounded-lg shadow-xs">
        <p class="font-medium">TELÉFONO:</p>
        <p>{{ miembros.telefono }}</p>
    </div>
</div>


    <!-- Columna 2: En Caso de Accidente Contactar -->
    
</div>


<div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg p-4">
    

    <!-- Columna 2: En Caso de Accidente Contactar -->
    <div class="space-y-0">
        <div class="min-w-0 font-bold text-gray-700 text-xl p-4 rounded-lg shadow-xs">
            <p>INFORMACION DE CONTACTO:</p>
        </div>

        <div class="min-w-0 p-4 rounded-lg shadow-xs">
            <p>CONTACTAR A: </p>
            <p>{{ miembros.nombreContacto }}</p>
        </div>

        <div class="min-w-0 p-4 rounded-lg shadow-xs">
            <p>ENFERMEDAD: </p>
            <p>{{ miembros.enfermedad }}</p>
        </div>
        <div class="min-w-0 p-4 rounded-lg shadow-xs">
            <p>INSTITUCION: </p>
            <p>{{ miembros.institucion }}</p>
        </div>
       
    </div>
</div>
<div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg p-4">
    

    <!-- Columna 2: En Caso de Accidente Contactar -->
    <div class="space-y-0">
        <div class="min-w-0 font-bold text-gray-700 text-xl p-4 rounded-lg shadow-xs">
            <p>INFORMACION DE MATRICULA:</p>
        </div>

        
        <div class="min-w-0 p-4 rounded-lg shadow-xs">
            <p>FECHA DE CREACION: </p>
            <p>{{ miembros.fechaRegistro }}</p>
        </div>
        <div class="min-w-0 p-4 rounded-lg shadow-xs">
            <p>FECHA DE INICIO DE MATRICULA: </p>
            <p>{{ miembros.fechaInicio }}</p>
        </div>
        <div class="min-w-0 p-4 rounded-lg shadow-xs">
            <p>FECHA FIN DE MATRICULA: </p>
            <p>{{ miembros.fechaFin }}</p>
        </div>
       
    </div>
</div>
    </AuthenticatedLayout>

</template>