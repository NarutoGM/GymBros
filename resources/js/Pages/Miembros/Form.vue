<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import DarkButton from '@/Components/DarkButton.vue';

const props = defineProps({});

const form = useForm({
  dni: '', 
  nombre: '', 
  direccion: '', 
  telefono: '', 
  edad: '', 
  nombreContacto: '', 
  enfermedad: '', 
  institucion: ''
});

function toggleAccordion(sectionId) {
  const section = document.getElementById(sectionId);
  section.classList.toggle('hidden');
}
</script>

<template>
    <Head title="REGISTRAR VENTAS" />
    
    <AuthenticatedLayout>
        <template #header>
            <div class="inline-flex overflow-hidden mb-4 w-full items-center justify-between">
                REGISTRAR NUEVO MIEMBRO 
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
            <form @submit.prevent="form.post('/ruta/de/registro')">
                <!-- Acordeón - Datos Personales -->
                <div class="mb-4 border border-gray-200 rounded-lg">
                    <button type="button" class="w-full p-4 text-left bg-white border-b border-gray-200 focus:outline-none" @click="toggleAccordion('section1')">
                        <span class="font-bold">Datos Personales</span>
                    </button>
                    <div id="section1" class="hidden p-4">
                        <div class="mb-4">
                            <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                            <input type="text" id="dni" v-model="form.dni" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" id="nombre" v-model="form.nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                            <input type="text" id="direccion" v-model="form.direccion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <input type="text" id="telefono" v-model="form.telefono" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="edad" class="block text-sm font-medium text-gray-700">Edad</label>
                            <input type="text" id="edad" v-model="form.edad" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                </div>

                <!-- Acordeón - Contacto de Emergencia -->
                <div class="mb-4 border border-gray-200 rounded-lg">
                    <button type="button" class="w-full p-4 text-left bg-white border-b border-gray-200 focus:outline-none" @click="toggleAccordion('section2')">
                        <span class="font-bold">Contacto de Emergencia</span>
                    </button>
                    <div id="section2" class="hidden p-4">
                        <div class="mb-4">
                            <label for="nombreContacto" class="block text-sm font-medium text-gray-700">Nombre del Contacto</label>
                            <input type="text" id="nombreContacto" v-model="form.nombreContacto" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="telefonoContacto" class="block text-sm font-medium text-gray-700">Teléfono del Contacto</label>
                            <input type="text" id="telefonoContacto" v-model="form.telefonoContacto" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                </div>

                <!-- Acordeón - Condición de Salud -->
                <div class="mb-4 border border-gray-200 rounded-lg">
                    <button type="button" class="w-full p-4 text-left bg-white border-b border-gray-200 focus:outline-none" @click="toggleAccordion('section3')">
                        <span class="font-bold">Condición de Salud</span>
                    </button>
                    <div id="section3" class="hidden p-4">
                        <div class="mb-4">
                            <label for="enfermedad" class="block text-sm font-medium text-gray-700">Enfermedad</label>
                            <input type="text" id="enfermedad" v-model="form.enfermedad" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="institucion" class="block text-sm font-medium text-gray-700">Institución de Salud</label>
                            <input type="text" id="institucion" v-model="form.institucion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
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