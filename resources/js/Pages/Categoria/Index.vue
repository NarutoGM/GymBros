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
	categoria:{type:Object}
	
});
const form = useForm({categoria:''});
const v = ref({	categoria:''});
const showModalForm = ref(false);
const showModalView = ref(false);
const title = ref('');
let operation = ref(1);
const msj = ref('');
const classMsj = ref('hidden');

const openModalView = (a) =>{

    v.value.categoria=a.categoria;
    v.value.productos=a.productos;
	showModalView.value = true;
    title.value='Listado de productos';

}


const openModalForm = (op,a) =>{


	showModalForm.value = true;
	operation = op;
	if (op===1){
		title.value='Crear una nueva categoria';
	}else{
		title.value='Editar nombre de categoria';
		form.categoria=a.categoria;

		form.idCategoria=a.idCategoria;

	}
     
}

const deletedCategoria= (idCategoria,categoria) =>{
    const alerta=Swal.mixin({
       buttonsStyling:true
    });
    alerta.fire({

        title:'Desea eliminar la categoria? '+  categoria +' ? ',
        icon:'question', showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Si, eliminar',
        cancelButtonText:'<i class="fa-solid fa-ban"></i> Cancelar',
    }).then((result) => {
        if(result.isConfirmed) {
		    
            form.delete(route('categorias.destroy',idCategoria),{
                onSuccess: () => {ok('Categoria eliminada')}
            });
			
        }
    });
}




const closeModalForm = () =>{
	showModalForm.value = false;
	form.reset();

}

const closeModalView = (a) =>{
      showModalForm.value = false;

      showModalView.value=false;
}


const save = () => { 
    if (operation == 1) {
        form.post(route('categorias.store'), {
            onSuccess: () => { ok('Membresia creada') }
        });
    } else {
        form.put(route('categorias.update', form.idCategoria), {
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
    formPage.get(route('categorias.index',{page:event}));
}
</script>

<template>
	<Head title="CATEGORIAS" />
	
	<AuthenticatedLayout>
		<template #header>
			GESTION DE CATEGORIAS  //

		</template>

		<DIV class="pb-2 flex justify-between items-center">

			
<DarkButton @click="openModalForm(1)"> <div class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg>
<P class="text-xl mx-2">NUEVO REGISTRO</P> 
	</div>
		</DarkButton>

		<vueTailwindPaginationUmd class="relative" 
       :current="categoria.currentPage" :total="categoria.total" 
       :per-page="categoria.perPage"
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
                <tr class="text-sm font-semibold tracking-wide text-gray-100 uppercase border-b bg-blue-700">
                    <th class="px-1 py-3 text-center">CATEGORIA</th>
                    <th class="px-1 py-3 text-center"># PRODUCTOS</th>
                    <th class="px-1 py-3 text-center">VER LISTA</th>

                    <th class="px-1 py-3 text-center">EDITAR</th>
                    <th class="px-1 py-3 text-center">ELIMINAR</th>

                </tr>
            </thead>
            <tbody class="text-gray-900 font-bold divide-y dark:divide-gray-700 dark:bg-blue-50">
                <tr v-for="(a, i) in categoria.data" :key="a.idCategoria" class="text-gray-500">
                    <td class="px-1 py-3 text-sm text-center">{{ a.categoria }}</td>
                    <td class="px-1 py-3 text-sm text-center">{{ a.productos_count  }}</td>

                    <td class="px-1 py-3 text-sm text-center">
                        <SecondaryButton @click="openModalView(a)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>

                        </SecondaryButton>
                    </td>


                    <td class="px-1 py-3 text-sm text-center">
                        <WarningButton @click="openModalForm(2, a)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                            </svg>
                        </WarningButton>
                    </td>
                    <td class="px-1 py-3 text-sm text-center">
                        <DeleteButton @click="$event => deletedCategoria(a.idCategoria, a.categoria)">
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



					<InputGroup :text="'NOMBRE DE LA CATEGORIA'" :require="'required'" v-model="form.categoria" :type="'text'">
						
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                        </svg>

					</InputGroup>
					
					<InputError class="mt-1" :message="form.errors.categoria"></InputError>


					

					

					<PrimaryButton @click="save">Guardar</PrimaryButton>
				 </div>
			</div>
			<div class="m-6 flex justify-end">
				<SecondaryButton @click="closeModalForm">Cancel</SecondaryButton>
			</div>
		</Modal>
        <Modal :show="showModalView" @close="closeModalView">
			<div class="p-6">            
                 <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>

				 <div class="m-6 mb-6 space-y-6 max-w-xl">               
                
                 <p>Categoria: <span class="text-lg font-medium text-gray-900">{{v.categoria}}</span></p>

                 <p>Productos: </p>

                    <ol>
                        <li class="text-lg font-medium text-gray-900" v-for="(prod, i) in v.productos" :key="i">
                               {{ (i+1) + ') ' + prod.producto }}
                        </li>

                    </ol>

					
						
			</div>
			</div>
			<div class="m-6 flex justify-end">
				<SecondaryButton @click="closeModalView">Cancel</SecondaryButton>
			</div>
		</Modal>
	</AuthenticatedLayout>
</template>
