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
           <div class="min-w-0  rounded-lg shadow-xs">
        <p class="font-medium">EDAD:</p>
    </div> 

           <InputGroup :text="'EDAD:'" :required="'required'" v-model="form.edad">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
</svg>


        </InputGroup>
           <InputError :message="form.errors.edad"></InputError>

           <div class="min-w-0  rounded-lg shadow-xs">
        <p class="font-medium">TELEFONO:</p>
    </div> 
           <InputGroup :text="'TELEFONO:'" :required="'required'" v-model="form.telefono">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5h3m-6.75 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-15a2.25 2.25 0 0 0-2.25-2.25H6.75A2.25 2.25 0 0 0 4.5 4.5v15a2.25 2.25 0 0 0 2.25 2.25Z" />
</svg>


        </InputGroup>
           <InputError :message="form.errors.telefono"></InputError>



           <div class="min-w-0  rounded-lg shadow-xs">
        <p class="font-medium">INFORMACION DE CONTACTO::</p>
    </div> 
           <InputGroup :text="'TELEFONO DE A QUIEN CONTACTAR:'" :required="'required'" v-model="form.nombreContacto">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
</svg>


        </InputGroup>
           <InputError :message="form.errors.nombreContacto"></InputError>

           <div class="min-w-0  rounded-lg shadow-xs">
        <p class="font-medium">ENFERMEDAD:</p>
    </div> 
           <InputGroup :text="'ENFERMEDAD:'" :required="'required'" v-model="form.enfermedad">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
</svg>


        </InputGroup>
           <InputError :message="form.errors.enfermedad"></InputError>


           <div class="min-w-0  rounded-lg shadow-xs">
        <p class="font-medium">INSTITUCION:</p>
    </div> 
           <InputGroup :text="'CLINICA Y/O HOSPITAL:'" :required="'required'" v-model="form.institucion">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
</svg>


        </InputGroup>
           <InputError :message="form.errors.institucion"></InputError>



        </form>
    </div>

</div>


    <!-- Columna 2: En Caso de Accidente Contactar -->
    
</div>


    </AuthenticatedLayout>

</template>