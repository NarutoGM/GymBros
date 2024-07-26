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
const form = useForm({NombreCurso:'',CodCurso:''});
const v = ref({CodCurso:'',	NombreCurso:''});
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
		title.value='Editar curso';
		form.CodCurso=a.CodCurso;
		form.NombreCurso=a.NombreCurso;
	}
     
}

const deletedCursos= (CodCurso,NombreCurso) =>{
    const alerta=Swal.mixin({
       buttonsStyling:true
    });
    alerta.fire({

        title:'Desea eliminar el curso '+  NombreCurso +' - '+CodCurso+  ' ? ',
        icon:'question', showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Yes, delete',
        cancelButtonText:'<i class="fa-solid fa-ban"></i> Cancel',
    }).then((result) => {
        if(result.isConfirmed) {
		    
            form.delete(route('cursos.destroy',CodCurso),{
                onSuccess: () => {ok('Curso eliminado')}
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
        form.post(route('cursos.store'), {
            onSuccess: () => { ok('Curso creado') }
        });
    } else {
        form.put(route('cursos.update', form.CodCurso), {
            onSuccess: () => { ok('Curso editado') }
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
    formPage.get(route('cursos.index',{page:event}));
}
</script>

<template>
	<Head title="Cursos" />
	
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
						<tr class="text-xl font-semibold tracking-wide  text-gray-100 uppercase border-b   bg-blue-800 ">
						   <th class="px-4 py-3 text-left">#</th>
                           <th class="px-4 py-3 text-left" >Nombre</th>
						   <th class="px-4 py-3 text-left" >Días</th>
                           <th class="px-4 py-3 text-left" >Precio</th>

                           <th class="px-4 py-3 text-left" >Editar</th>
                           <th class="px-4 py-3 text-left" >Eliminar</th>

                        </tr>
					  </thead>
					  <tbody class="text-gray-900 font-bold divide-y dark:divide-gray-700 dark:bg-blue-50">
						<tr v-for="a,i in membresia.data" :key="a.idMembresia" class="text-gray-500 ">
                            <td class="px-4 py-3 text-sm ">
								   {{ a.idMembresia }}
							</td>
							<td class="px-4 py-3 text-sm">
                                   {{ a.nombre }}
							</td>
							<td class="px-4 py-3 text-sm">
                                   {{ a.duracion }}
							</td>
							<td class="px-4 py-3 text-sm">
                                   {{ a.precio }}
							</td>
							<td class="px-4 py-3 text-sm ">
                            <WarningButton @click="openModalForm(2,a)"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </WarningButton> 

							</td>				
							<td class="px-4 py-3 text-sm">

			

							<DeleteButton @click="$event => deletedCursos(a.idMembresia,a.Nombre)">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
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

					<InputGroup :text="'CodCurso'"  :require="'required'" v-model="form.CodCurso" :type="'text'" :readonly="operation !== 1">
						
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
</svg>
					</InputGroup>
					<InputError class="mt-1" :message="form.errors.CodCurso"></InputError>

					<InputGroup :text="'NombreCurso'" :require="'required'" v-model="form.NombreCurso" :type="'text'">
						
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>


					</InputGroup>
					<InputError class="mt-1" :message="form.errors.NombreCurso"></InputError>

					<PrimaryButton @click="save">Guardar</PrimaryButton>
				 </div>
			</div>
			<div class="m-6 flex justify-end">
				<SecondaryButton @click="closeModalForm">Cancel</SecondaryButton>
			</div>
		</Modal>
		
	</AuthenticatedLayout>
</template>
