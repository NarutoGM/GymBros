<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import Modal from '@/Components/Modal.vue';
import DarkButton from '@/Components/DarkButton.vue';
import DeleteButton from '@/Components/DeleteButton.vue';
import {ref} from 'vue';
import { Head , useForm} from '@inertiajs/vue3';
import InputGroup from '@/Components/InputGroup.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import vueTailwindPaginationUmd from '@ocrv/vue-tailwind-pagination';
import Pagination from '@/Components/Pagination.vue';
import NavLink from '@/Components/NavLink.vue';

import Swal from 'sweetalert2';
const props= defineProps({
	miembros:{type:Object},flash:{type:Object}
	
});



const form = useForm({dni:'',nombre:''});

const v = ref({	nombre:'',duracion:'',precio:'',idMembresia:''});


const showModalDel = ref(false);




const title = ref('');




const msj = ref((props.flash.success != null) ? props.flash.success: '');
const classMsj = ref((props.flash.success != null) ? ' ' : 'hidden');




const openModalDel = (b) =>{
    form.dni = b.dni;
    form.nombre = b.nombre;
    showModalDel.value=true;

	
	
     
}

const closeModalDel = ()=>{
    showModalDel.value=false;
}

const deletedCursos= (idMembresia,nombre) =>{
    const alerta=Swal.mixin({
       buttonsStyling:true
    });
    alerta.fire({

        title:'Desea desabilitar la membresia '+  nombre +' ? ',
        icon:'question', showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Yes, delete',
        cancelButtonText:'<i class="fa-solid fa-ban"></i> Cancel',
    }).then((result) => {
        if(result.isConfirmed) {
		    
            form.delete(route('membresias.destroy',idMembresia),{
                onSuccess: () => {ok('Membresia eliminada')}
            });
			
        }
    });
}

const deletedMiembros= (dni,nombre) =>{
    const alerta=Swal.mixin({
       buttonsStyling:true
    });
    alerta.fire({

        title:'Desea eliminar a '+  nombre +' ? ',
        icon:'question', showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Yes, delete',
        cancelButtonText:'<i class="fa-solid fa-ban"></i> Cancel',
    }).then((result) => {
        if(result.isConfirmed) {
		    
            form.delete(route('membresias.destroy',dni),{
                onSuccess: () => {ok('Membresia eliminada')}
            });
			
        }
    });
}



const closeModalForm = () =>{
	showModalForm.value = false;
	form.reset();

}


const save = () => { 
    if (operation == 1) {
        form.post(route('membresias.store'), {
            onSuccess: () => { ok('Membresia creada') }
        });
    } else {
        form.put(route('membresias.update', form.idMembresia), {
            onSuccess: () => { ok('Membresia editada') }
        });

    }
};


const ok = (m) => {
    

	 form.reset();
	 msj.value = m;
	 classMsj.value = 'block'
	 setTimeout(() => {
		classMsj.value= 'hidden'
	 }, 5000);
}

const formPage = useForm({});

const onPageClick = (event)=>{
    formPage.get(route('membresias.index',{page:event}));
}




</script>
<script>
export default {
  props: ['b'], // Asegúrate de recibir el prop 'b' si es necesario
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
			GESTION DE MIEMBROS //

		</template>

		<DIV class="pb-2 flex justify-between items-center">

			
<DarkButton> <div class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg>
<P class="text-xl mx-2">NUEVO REGISTRO</P> 
	</div>
		</DarkButton>
		<vueTailwindPaginationUmd class="relative" 
       :current="miembros.currentPage" :total="miembros.total" 
       :per-page="miembros.perPage"
       @page-changed="$event => onPageClick($event)"
       ></vueTailwindPaginationUmd>
	   

		</DIV>


		<div class="inline-flex overflow-hidden mb-4 w-full  bg-white rounded-lg shadow-md" :class="classMsj">
				<div class="flex justify-center items-center w-12 bg-green-500">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg>

				</div>
				
				<div class="px-4 py-2 -mx-3">
					<div class="mx-3">
						<span class="font-semibold text-green-500">Success</span>
						<p class="text-sm text-gray-600">{{msj}}</p>
					</div>
				</div>
			</div>		
			
			

			<div class="w-full overflow-hidden rounded-lg border shadow-md">
    <div class="w-full overflow-x-auto bg-white">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-sm font-semibold tracking-wide text-gray-100 uppercase border-b bg-blue-800">
                    <th class="px-1 py-3 text-center">DNI</th>
                    <th class="px-1 py-3 text-center">NOMBRES</th>
                    <th class="px-1 py-3 text-center">ESTADO</th>
                    <th class="px-1 py-3 text-center">NUMERO</th>
                    <th class="px-1 py-3 text-center">FECHA INICIO</th>
                    <th class="px-1 py-3 text-center">FECHA FIN</th>
                    <th class="px-1 py-3 text-center">MEMBRESIA</th>
                    <th class="px-1 py-3 text-center">VER</th>

                    <th class="px-1 py-3 text-center">EDITAR</th>
                    <th class="px-1 py-3 text-center">BORRAR</th>
                    <th class="px-1 py-3 text-center">PLAN</th>

                </tr>
            </thead>
            <tbody class="text-gray-900 font-bold divide-y dark:divide-gray-700 dark:bg-blue-50">
                <tr v-for="(b, i) in miembros.data" :key="b.dni" class="text-gray-500">
                    <td class="px-1 py-3 text-sm text-center">{{ b.dni }}</td>
                    <td class="px-1 py-3 text-sm text-center">{{ b.nombre }}</td>

                    <td class="px-1 py-3 text-sm text-center"  :class="{
    'bg-orange-400 text-white': !b.fechaInicio,'bg-green-400 text-white': isActivo(b.fechaInicio, b.fechaFin),'bg-red-400 text-white': isVencido(b.fechaFin),}">

  {{ getStatusMessage(b.fechaInicio, b.fechaFin) }}
</td>

                    <td class="px-1 py-3 text-sm text-center">{{ b.telefono }}</td>
                    <td class="px-1 py-3 text-sm text-center">{{ b.fechaInicio }}</td>
                    <td class="px-1 py-3 text-sm text-center">{{ b.fechaFin }}</td>

                    <td class="px-1 py-3 text-sm text-center">
                            {{ b.membresias ? b.membresias.nombre : '' }}
                    </td>

                    <td class="px-1 py-3 text-sm text-center">
                        <NavLink :href="route('miembros.show',b.dni)">
                        <SecondaryButton>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
</svg>

                        </SecondaryButton>
                        </NavLink>
 
 

                    </td>


                    <td class="px-1 py-3 text-sm text-center">
                        <WarningButton >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                            </svg>
                        </WarningButton>
                    </td>
                    <td class="px-1 py-3 text-sm text-center">
                        <DeleteButton @click="$event => deletedMiembros(b.dni, b.nombre)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                            </svg>
                        </DeleteButton>
                    </td>
                    <td class="px-1 py-3 text-sm text-center">
                        <SecondaryButton @click="$event => deletedMiembros(b.dni, b.nombre)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                            </svg>

                        </SecondaryButton>
                    </td>

                </tr>
            </tbody>
        </table>
    </div>
    <div
					class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
					<pagination :links="miembros.links" />
				</div>
</div>

   

        <Modal :show="showModalDel" @close="closeModalDel">
            <div class="p-6">
                  <p class="text-2xl text-gray-500">
                    Estas seguro de que deseas elimnar a 
                    <span class="text-2xl font-medium text-gray-900">{{ b.nombre }}</span> ? 
                </p>
                <PrimaryButton @click="deletedCursos">Si, eliminar</PrimaryButton>   
            </div>
            <div class="m-6 flex justify-end">
                <SecondaryButton @click="closeModalDel">Cancel</SecondaryButton>
            </div>
        </Modal>
		
	</AuthenticatedLayout>
</template>
