<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import DarkButton from '@/Components/DarkButton.vue';

const props = defineProps({
  miembros:{type:Object},membresias:{type:Object} // Asegúrate de que `timeDifference` esté definido como prop	
});

const form = useForm({
  dni: props.miembros.dni, 
  nombre: props.miembros.nombre, 
  direccion: props.miembros.direccion, 
  telefono: props.miembros.telefono, 
  edad: props.miembros.edad, 
  nombreContacto: props.miembros.nombreContacto, 
  telefonoContacto: props.miembros.telefonoContacto, 
  enfermedad: props.miembros.enfermedad, 
  institucion: props.miembros.institucion
});

function toggleAccordion(sectionId) {
  const section = document.getElementById(sectionId);
  section.classList.toggle('hidden');
}

</script>

<template>
    <Head title="EDITAR INFORMACION" />
    
    <AuthenticatedLayout>
        <template #header>
            <div class="inline-flex overflow-hidden mb-4 w-full items-center justify-between">
                EDITAR INFORMACION DE UN MIEMBRO 
                <NavLink :href="route('miembros.index')">
                    <DarkButton>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                        </svg>
                    </DarkButton>
                </NavLink>
            </div>
        </template>




        <div class="container mx-auto p-4">

          <div class="container mx-auto p-4">
            <form @submit.prevent="form.put(route('miembros.update', form.dni))">
              <!-- Acordeón - Datos Personales -->
                <div class="mb-4 border border-gray-200 rounded-lg">
                  <button type="button" class="w-full p-4 text-left bg-white border-b border-blue-500 focus:outline-none" @click="toggleAccordion('section1')">
                        <div class="flex items-center">
                            <!-- Círculo con el número 1 -->
                            <div class="flex items-center justify-center w-6 h-6 mr-2 text-white bg-blue-500 rounded-full">
                                1
                            </div>
                            <span class="font-bold">Datos Personales</span>
                        </div>
                    </button>
                    <div id="section1" class="hidden p-4">
                        <div class="mb-4">
                          <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                        <input type="number" readonly  v-model="form.dni" id="dni" class="mt-1 block w-full p-2 border border-gray-300 bg-gray-200 rounded-md"
                               :class="{ 'border-red-500': form.errors.dni }">
                        <span v-if="form.errors.dni" class="text-red-500 text-sm">{{ form.errors.dni }}</span>
                        </div>
                        <div class="mb-4">
                          <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" v-model="form.nombre" id="nombre" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                               :class="{ 'border-red-500': form.errors.nombre }">
                        <span v-if="form.errors.nombre" class="text-red-500 text-sm">{{ form.errors.nombre }}</span>
                        </div>
                        <div class="mb-4">
                          <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                        <input type="text" v-model="form.direccion" id="direccion" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                               :class="{ 'border-red-500': form.errors.direccion }">
                        <span v-if="form.errors.direccion" class="text-red-500 text-sm">{{ form.errors.direccion }}</span>
                        </div>
                        <div class="mb-4">
                          <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" v-model="form.telefono" id="telefono" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                               :class="{ 'border-red-500': form.errors.telefono }">
                        <span v-if="form.errors.telefono" class="text-red-500 text-sm">{{ form.errors.telefono }}</span>
                        </div>
                        <div class="mb-4">
                          <label for="edad" class="block text-sm font-medium text-gray-700">Edad</label>
                        <input type="number" v-model="form.edad" id="edad" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                               :class="{ 'border-red-500': form.errors.edad }">
                        <span v-if="form.errors.edad" class="text-red-500 text-sm">{{ form.errors.edad }}</span>
                        </div>
                    </div>
                </div>

                <!-- Acordeón - Contacto de Emergencia -->
                <div class="mb-4 border border-gray-200 rounded-lg">
                    <button type="button" class="w-full p-4 text-left bg-white border-b border-blue-500 focus:outline-none" @click="toggleAccordion('section2')">
                      <div class="flex items-center">
                      <div class="flex items-center justify-center w-6 h-6 mr-2 text-white bg-blue-500 rounded-full">
                                2
                            </div>  
                      <span class="font-bold">Contacto de Emergencia</span>
                    </div>
                    </button>
                    <div id="section2" class="hidden p-4">
                        <div class="mb-4">
                          <label for="nombreContacto" class="block text-sm font-medium text-gray-700">Nombre del Contacto</label>
                        <input type="text" v-model="form.nombreContacto" id="nombreContacto" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                               :class="{ 'border-red-500': form.errors.nombreContacto }">
                        <span v-if="form.errors.nombreContacto" class="text-red-500 text-sm">{{ form.errors.nombreContacto }}</span>
                        </div>
                        <div class="mb-4">
                            <label for="telefonoContacto" class="block text-sm font-medium text-gray-700">Teléfono del Contacto</label>
                            <input type="text" id="telefonoContacto" v-model="form.telefonoContacto" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                </div>

                <!-- Acordeón - Condición de Salud -->
                <div class="mb-4 border border-gray-200 rounded-lg">
                    <button type="button" class="w-full p-4 text-left bg-white border-b border-blue-500 focus:outline-none" @click="toggleAccordion('section3')">
                      <div class="flex items-center">
                      <div class="flex items-center justify-center w-6 h-6 mr-2 text-white bg-blue-500 rounded-full">
                                3
                            </div>  
                            <span class="font-bold">Condición de Salud</span>
                          </div>
                    </button>
                    <div id="section3" class="hidden p-4">
                        <div class="mb-4">
                          <label for="enfermedad" class="block text-sm font-medium text-gray-700">Enfermedad</label>
                        <input type="text" v-model="form.enfermedad" id="enfermedad" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                               :class="{ 'border-red-500': form.errors.enfermedad }">
                        <span v-if="form.errors.enfermedad" class="text-red-500 text-sm">{{ form.errors.enfermedad }}</span>
                        </div>
                        <div class="mb-4">
                          <label for="institucion" class="block text-sm font-medium text-gray-700">Institución</label>
                        <input type="text" v-model="form.institucion" id="institucion" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                               :class="{ 'border-red-500': form.errors.institucion }">
                        <span v-if="form.errors.institucion" class="text-red-500 text-sm">{{ form.errors.institucion }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <DarkButton type="submit">Registrar</DarkButton>
                </div>
            </form>

        


        </div>


  </div>


    </AuthenticatedLayout>
</template>


<style scoped>
/* Estilos opcionales */
</style>