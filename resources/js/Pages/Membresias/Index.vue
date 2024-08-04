<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import DeleteButton from '@/Components/DeleteButton.vue';
import {ref} from 'vue';
import { Head , useForm} from '@inertiajs/vue3';
import InputGroup from '@/Components/InputGroup.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import vueTailwindPaginationUmd from '@ocrv/vue-tailwind-pagination';

import Swal from 'sweetalert2';
const props= defineProps({
	membresia:{type:Object}
	
});
const form = useForm({nombre:'',duracion:'',precio:'',idMembresia:''});
const v = ref({	nombre:'',duracion:'',precio:'',idMembresia:''});
const showModalForm = ref(false);
const title = ref('');
let operation = ref(1);
const msj = ref('');
const classMsj = ref('hidden');

const openModalForm = (op,a) =>{


	showModalForm.value = true;
	operation = op;
	if (op===1){
		title.value='Crear una membresia';
	}else{
		title.value='Editar una membresia';
		form.duracion=a.duracion;
		form.nombre=a.nombre;
		form.precio=a.precio;
		form.idMembresia=a.idMembresia;

	}
     
}

const deletedMembresias= (idMembresia,nombre) =>{
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
    
	if(operation == 2 || operation ==1){
        closeModalForm();
	 }
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

<template>
	<Head title="MEMBRESIAS" />
	
	<AuthenticatedLayout>
		<template #header>
			GESTION DE PROMOCIONES Y MEMBRESIAS //

		</template>

		<DIV class="pb-2 flex justify-between items-center">

			
<DarkButton @click="openModalForm(1)"> <div class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg>
<P class="text-xl mx-2">NUEVO REGISTRO</P> 
	</div>
		</DarkButton>

		<vueTailwindPaginationUmd class="relative" 
       :current="membresia.currentPage" :total="membresia.total" 
       :per-page="membresia.perPage"
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
                    <th class="px-1 py-3 text-center">membresia</th>
                    <th class="px-1 py-3 text-center">Dias</th>
                    <th class="px-1 py-3 text-center">Precio</th>
                    <th class="px-1 py-3 text-center">Editar</th>
                    <th class="px-1 py-3 text-center">Eliminar</th>
                </tr>
            </thead>
            <tbody class="text-gray-900 font-bold divide-y dark:divide-gray-700 dark:bg-blue-50">
                <tr v-for="(a, i) in membresia.data" :key="a.idMembresia" class="text-gray-500">
                    <td class="px-1 py-3 text-sm text-center">{{ a.nombre }}</td>
                    <td class="px-1 py-3 text-sm text-center">{{ a.duracion }}</td>
                    <td class="px-1 py-3 text-sm text-center">{{ a.precio }}</td>
                    <td class="px-1 py-3 text-sm text-center">
                        <WarningButton @click="openModalForm(2, a)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                            </svg>
                        </WarningButton>
                    </td>
                    <td class="px-1 py-3 text-sm text-center">
                        <DeleteButton @click="$event => deletedMembresias(a.idMembresia, a.nombre)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                            </svg>
                        </DeleteButton>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

   
		<div class="bg-white grid v-screen place-items-center">



     </div>
		<Modal :show="showModalForm" @close="closeModalForm">
			<div class="p-6">
                 <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>
				 <div class="m-6 mb-6 space-y-6 max-w-xl">



					<InputGroup :text="'NOMBRE DE LA MEMBRESIA'" :require="'required'" v-model="form.nombre" :type="'text'">
						
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>


					</InputGroup>
					
					<InputError class="mt-1" :message="form.errors.nombre"></InputError>


					<InputGroup :text="'DIAS DE DURACIóN'" :require="'required'" v-model="form.duracion" :type="'text'">
						
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg>




					</InputGroup>
					
					<InputError class="mt-1" :message="form.errors.duracion"></InputError>

					<InputGroup :text="'PRECIO DE MEMBRESIA'" :require="'required'" v-model="form.precio" :type="'number'" step="0.01">

						
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  						<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
						</svg>



					</InputGroup>
					
					<InputError class="mt-1" :message="form.errors.precio"></InputError>

					<PrimaryButton @click="save">Guardar</PrimaryButton>
				 </div>
			</div>
			<div class="m-6 flex justify-end">
				<SecondaryButton @click="closeModalForm">Cancel</SecondaryButton>
			</div>
		</Modal>
		
	</AuthenticatedLayout>
</template>
