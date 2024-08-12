<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import DarkButton from '@/Components/DarkButton.vue';

const props = defineProps({miembros:{type:Object}, });


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
            <div class="inline-flex overflow-hidden mb-4 w-full items-center justify-between">
                {{ miembros.nombre }} //             
                <p>  <span v-if="miembros.membresias && miembros.membresias.nombre">              <p>MEMBRESIA: {{ miembros.membresias.nombre }} // <span><td class="px-1 py-3 text-sm text-center"  :class="{
    'bg-orange-400 text-white': !miembros.fechaInicio,'bg-green-400 text-white': isActivo(miembros.fechaInicio, miembros.fechaFin),'bg-red-400 text-white': isVencido(miembros.fechaFin),}">

  {{ getStatusMessage(miembros.fechaInicio, miembros.fechaFin) }}
</td></span></p>
            </span></p>



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

    <div class="min-w-0 p-4 rounded-lg shadow-xs">
        <p class="font-medium">DNI:</p> <!-- Estilo opcional para distinguir el título del concepto -->
        <p>{{ miembros.dni }}</p>
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