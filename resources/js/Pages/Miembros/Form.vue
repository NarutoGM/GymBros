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
            <form @submit.prevent="form.post(route('miembros.store'))">
                <!-- Datos Personales -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold">Datos Personales</h3>
                    <!-- DNI -->
                    <div class="mt-4">
                        <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                        <input type="number" v-model="form.dni" id="dni" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                               :class="{ 'border-red-500': form.errors.dni }">
                        <span v-if="form.errors.dni" class="text-red-500 text-sm">{{ form.errors.dni }}</span>
                    </div>

                    <!-- Nombre -->
                    <div class="mt-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" v-model="form.nombre" id="nombre" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                               :class="{ 'border-red-500': form.errors.nombre }">
                        <span v-if="form.errors.nombre" class="text-red-500 text-sm">{{ form.errors.nombre }}</span>
                    </div>

                    <!-- Dirección -->
                    <div class="mt-4">
                        <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                        <input type="text" v-model="form.direccion" id="direccion" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                               :class="{ 'border-red-500': form.errors.direccion }">
                        <span v-if="form.errors.direccion" class="text-red-500 text-sm">{{ form.errors.direccion }}</span>
                    </div>
                    
                    <!-- Otros campos -->
                    <!-- Teléfono -->
                    <div class="mt-4">
                        <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" v-model="form.telefono" id="telefono" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                               :class="{ 'border-red-500': form.errors.telefono }">
                        <span v-if="form.errors.telefono" class="text-red-500 text-sm">{{ form.errors.telefono }}</span>
                    </div>

                    <!-- Edad -->
                    <div class="mt-4">
                        <label for="edad" class="block text-sm font-medium text-gray-700">Edad</label>
                        <input type="number" v-model="form.edad" id="edad" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                               :class="{ 'border-red-500': form.errors.edad }">
                        <span v-if="form.errors.edad" class="text-red-500 text-sm">{{ form.errors.edad }}</span>
                    </div>
                </div>

                <!-- Contacto de Emergencia -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold">Contacto de Emergencia</h3>
                    <!-- Nombre del Contacto -->
                    <div class="mt-4">
                        <label for="nombreContacto" class="block text-sm font-medium text-gray-700">Nombre del Contacto</label>
                        <input type="text" v-model="form.nombreContacto" id="nombreContacto" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                               :class="{ 'border-red-500': form.errors.nombreContacto }">
                        <span v-if="form.errors.nombreContacto" class="text-red-500 text-sm">{{ form.errors.nombreContacto }}</span>
                    </div>
                </div>

                <!-- Condición de Salud -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold">Condición de Salud</h3>
                    <!-- Enfermedad -->
                    <div class="mt-4">
                        <label for="enfermedad" class="block text-sm font-medium text-gray-700">Enfermedad</label>
                        <input type="text" v-model="form.enfermedad" id="enfermedad" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                               :class="{ 'border-red-500': form.errors.enfermedad }">
                        <span v-if="form.errors.enfermedad" class="text-red-500 text-sm">{{ form.errors.enfermedad }}</span>
                    </div>

                    <!-- Institución -->
                    <div class="mt-4">
                        <label for="institucion" class="block text-sm font-medium text-gray-700">Institución</label>
                        <input type="text" v-model="form.institucion" id="institucion" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                               :class="{ 'border-red-500': form.errors.institucion }">
                        <span v-if="form.errors.institucion" class="text-red-500 text-sm">{{ form.errors.institucion }}</span>
                    </div>
                </div>

                <!-- Botón de Enviar -->
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