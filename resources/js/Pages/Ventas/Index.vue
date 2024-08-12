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
	ventas:{type:Object},flash:{type:Object}
	
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
			REPORTE DE VENTAS //

		</template>

		<DIV class="pb-2 flex justify-between items-center">

			
<DarkButton> <div class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg>
<P class="text-xl mx-2">NUEVO REGISTRO</P> 
	</div>
		</DarkButton>

        
		<vueTailwindPaginationUmd class="relative" 
       :current="ventas.currentPage" :total="ventas.total" 
       :per-page="ventas.perPage"
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

                    <th class="px-1 py-3 text-center">FECHA</th>
                    <th class="px-1 py-3 text-center">HORAS</th>

                    <th class="px-1 py-3 text-center">CLIENTE</th>

                    <th class="px-1 py-3 text-center">USUARIO</th>
                    <th class="px-1 py-3 text-center">DOCUMENTO</th>

                    <th class="px-1 py-3 text-center">#</th>
                    <th class="px-1 py-3 text-center">TOTAL VENTA</th>
                    <th class="px-1 py-3 text-center">VER DETALLES</th>
                    <th class="px-1 py-3 text-center">IMPRIMIR</th>



                </tr>
            </thead>
            <tbody class="text-gray-900 font-bold divide-y dark:divide-gray-700 dark:bg-blue-50">
                <tr v-for="(b, i) in ventas.data" :key="b.idVentas" class="text-gray-500">
                    <td class="px-1 py-3 text-sm text-center">{{ new Date(b.fecha).toLocaleDateString() }}</td>
<td class="px-1 py-3 text-sm text-center">{{ new Date(b.fecha).toLocaleTimeString() }}</td>


                    <td class="px-1 py-3 text-sm text-center">{{ b.cliente }}</td>

           
                    <td class="px-1 py-3 text-sm text-center">{{ b.user.name  }}</td>
                    <td class="px-1 py-3 text-sm text-center">{{ b.tipofacturacion }}</td>
                    <td class="px-1 py-3 text-sm text-center">
    {{ new Date(b.fecha).getFullYear() + '-' + b.idVentas.toString().padStart(7, '0') }}
</td>
                    <td class="px-1 py-3 text-sm text-center">{{ b.montoneto }}</td>

                



                    <td class="px-1 py-3 text-sm text-center">
                        <SecondaryButton @click="$event => deletedMiembros(b.dni, b.nombre)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
</svg>


                        </SecondaryButton>
                    </td>                
                   
                    <td class="px-1 py-3 text-sm text-center">
                        <SecondaryButton @click="$event => deletedMiembros(b.dni, b.nombre)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
</svg>


                        </SecondaryButton>
                    </td>

                </tr>
            </tbody>
        </table>
    </div>
    <div
					class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
					<pagination :links="ventas.links" />
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
