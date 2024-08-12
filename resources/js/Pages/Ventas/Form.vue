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
        <div class="grid gap-6 bg-white mb-8 md:grid-cols-1 border rounded-lg p-4">
    <!-- Columna 1: Datos Personales -->
    <div class="space-y-0">
    <div class="min-w-0 font-bold text-gray-700 text-xl p-4 rounded-lg shadow-xs">
        <p class="mb-2">INFORMACIÓN PERSONAL:</p> <!-- Espacio debajo del título -->
    </div>

   
    <div class="min-w-0 px-4 rounded-lg shadow-xs">
        <form class="mt-6 space-y-3 max-w-full">
                        <!-- DNI -->
                        <div class="flex items-center">
                            <div class="min-w-0 rounded-lg shadow-xs">
                                <p class="font-medium">DNI:</p>
                            </div>

                            <InputGroup :text="'DNI'" :required="req" v-model="form.dni">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                </svg>
                            </InputGroup>
                            <InputError :message="form.errors.dni"></InputError>

                            <button @click="buscarDNI" class="ml-2 p-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                Buscar
                            </button>
                        </div>

                        <!-- Nombres -->
                        <div>
                            <div class="min-w-0 rounded-lg shadow-xs">
                                <p class="font-medium">NOMBRES:</p>
                            </div>

                            <InputGroup :text="'NOMBRES'" :required="req" v-model="form.nombre">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </InputGroup>
                            <InputError :message="form.errors.nombre"></InputError>
                        </div>

                        <!-- Dirección -->
                        <div>
                            <div class="min-w-0 rounded-lg shadow-xs">
                                <p class="font-medium">DIRECCIÓN:</p>
                            </div>

                            <InputGroup :text="'DIRECCIÓN'" :required="req" v-model="form.direccion">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                </svg>
                            </InputGroup>
                            <InputError :message="form.errors.direccion"></InputError>
                        </div>

                        <!-- Edad -->
                        <div>
                            <div class="min-w-0 rounded-lg shadow-xs">
                                <p class="font-medium">EDAD:</p>
                            </div>

                            <InputGroup :text="'EDAD'" :required="req" v-model="form.edad">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.634a2.625 2.625 0 1 0-7.5 0V9m-3.6 12h14.7c.993 0 1.8-.846 1.8-1.875V14.25c0-1.038-.815-1.875-1.8-1.875H4.65c-.993 0-1.8.846-1.8 1.875V19.125C2.85 20.154 3.667 21 4.65 21Z" />
                                </svg>
                            </InputGroup>
                            <InputError :message="form.errors.edad"></InputError>
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <div class="min-w-0 rounded-lg shadow-xs">
                                <p class="font-medium">TELÉFONO:</p>
                            </div>

                            <InputGroup :text="'TELÉFONO'" :required="req" v-model="form.telefono">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.41V17.25c0 1.243-.964 2.25-2.25 2.25a15.785 15.785 0 0 1-6.943-1.92 15.785 15.785 0 0 1-6.943-1.92c-1.286 0-2.25-1.007-2.25-2.25v-5.5c0-1.243.964-2.25 2.25-2.25h2.25c.953 0 1.746.673 2.032 1.572l.672 2.147a1.875 1.875 0 0 1-.591 1.968l-.963.963a12.751 12.751 0 0 0 5.058 5.058l.963-.963a1.875 1.875 0 0 1 1.968-.591l2.147.672a2.062 2.062 0 0 1 1.572 2.032Z" />
                                </svg>
                            </InputGroup>
                            <InputError :message="form.errors.telefono"></InputError>
                        </div>

                        <!-- Nombre de Contacto -->
                        <div>
                            <div class="min-w-0 rounded-lg shadow-xs">
                                <p class="font-medium">NOMBRE DE CONTACTO:</p>
                            </div>

                            <InputGroup :text="'NOMBRE DE CONTACTO'" :required="req" v-model="form.nombreContacto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </InputGroup>
                            <InputError :message="form.errors.nombreContacto"></InputError>
                        </div>

                        <!-- Enfermedad -->
                        <div>
                            <div class="min-w-0 rounded-lg shadow-xs">
                                <p class="font-medium">ENFERMEDAD:</p>
                            </div>

                            <InputGroup :text="'ENFERMEDAD'" :required="req" v-model="form.enfermedad">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2.25m0-4.5h.008v.008H12v-.008Zm9.479 2.679a9.75 9.75 0 1 1-14.958 0 6 6 0 1 1 14.958 0Z" />
                                </svg>
                            </InputGroup>
                            <InputError :message="form.errors.enfermedad"></InputError>
                        </div>

                        <!-- Institución -->
                        <div>
                            <div class="min-w-0 rounded-lg shadow-xs">
                                <p class="font-medium">INSTITUCIÓN:</p>
                            </div>

                            <InputGroup :text="'INSTITUCIÓN'" :required="req" v-model="form.institucion">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0v-8.625m0 8.625v-12A2.25 2.25 0 0 1 5.625 5.25m15 14.25H4.125a.75.75 0 0 1-.75-.75V10.875a.75.75 0 0 1 .37-.647l7.875-4.5a.75.75 0 0 1 .66 0l7.875 4.5a.75.75 0 0 1 .37.647V18.75a.75.75 0 0 1-.75.75ZM5.625 5.25v-.75A2.25 2.25 0 0 1 7.875 2.25h8.25a2.25 2.25 0 0 1 2.25 2.25v.75m-3 3.75h-6.75m6.75 3h-6.75" />
                                </svg>
                            </InputGroup>
                            <InputError :message="form.errors.institucion"></InputError>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sección 2: Información de Membresías -->
            <div class="space-y-0">
                <div class="min-w-0 font-bold text-gray-700 text-xl p-4 rounded-lg shadow-xs">
                    <p class="mb-2">MEMBRESÍAS:</p>
                </div>

                <div class="min-w-0 px-4 rounded-lg shadow-xs">
                    <form class="mt-6 space-y-3 max-w-full">
                        <!-- Fecha de Registro -->
                        <div>
                            <div class="min-w-0 rounded-lg shadow-xs">
                                <p class="font-medium">FECHA DE REGISTRO:</p>
                            </div>

                            <InputGroup :text="'FECHA DE REGISTRO'" :required="req" v-model="form.fechaRegistro">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3.75V6M17.25 3.75V6m-10.5 0h10.5M3.75 9.75h16.5m-16.5 9h16.5M8.25 12h7.5m-7.5 3h4.5" />
                                </svg>
                            </InputGroup>
                            <InputError :message="form.errors.fechaRegistro"></InputError>
                        </div>

                        <!-- Fecha de Inicio -->
                        <div>
                            <div class="min-w-0 rounded-lg shadow-xs">
                                <p class="font-medium">FECHA DE INICIO:</p>
                            </div>

                            <InputGroup :text="'FECHA DE INICIO'" :required="req" v-model="form.fechaInicio">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5V6.375c0-.621-.504-1.125-1.125-1.125h-.75V3.75a.75.75 0 0 0-1.5 0v1.5h-2.25V3.75a.75.75 0 0 0-1.5 0v1.5h-3V3.75a.75.75 0 0 0-1.5 0v1.5H7.875V3.75a.75.75 0 0 0-1.5 0v1.5h-.75c-.621 0-1.125.504-1.125 1.125v1.125M3.75 7.5v12.75c0 1.242.758 2.25 1.875 2.25h12.75c1.117 0 1.875-1.008 1.875-2.25V7.5H3.75Z" />
                                </svg>
                            </InputGroup>
                            <InputError :message="form.errors.fechaInicio"></InputError>
                        </div>

                        <!-- Fecha de Finalización -->
                        <div>
                            <div class="min-w-0 rounded-lg shadow-xs">
                                <p class="font-medium">FECHA DE FINALIZACIÓN:</p>
                            </div>

                            <InputGroup :text="'FECHA DE FINALIZACIÓN'" :required="req" v-model="form.fechaFinalizacion">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5v12.75c0 1.242.758 2.25 1.875 2.25h12.75c1.117 0 1.875-1.008 1.875-2.25V7.5M3.75 7.5H20.25M6 5.25h12M8.25 3v1.5M15.75 3v1.5" />
                                </svg>
                            </InputGroup>
                            <InputError :message="form.errors.fechaFinalizacion"></InputError>
                        </div>

                        <!-- Nivel de Membresía -->
                        <div>
                            <div class="min-w-0 rounded-lg shadow-xs">
                                <p class="font-medium">NIVEL DE MEMBRESÍA:</p>
                            </div>

                            <InputGroup :text="'NIVEL DE MEMBRESÍA'" :required="req" v-model="form.nivelMembresia">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75l2.696 5.46 6.029.878-4.363 4.254 1.029 6.004-5.391-2.835-5.391 2.835 1.029-6.004-4.363-4.254 6.029-.878L12 3.75z" />
                                </svg>
                            </InputGroup>
                            <InputError :message="form.errors.nivelMembresia"></InputError>
                        </div>
                    </form>
    </div>

</div>


    <!-- Columna 2: En Caso de Accidente Contactar -->
    
</div>


    </AuthenticatedLayout>

</template>