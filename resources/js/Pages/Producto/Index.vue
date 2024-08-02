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
import SelectInput from '@/Components/SelectInput.vue';

import PrimaryButton from '@/Components/PrimaryButton.vue';
import vueTailwindPaginationUmd from '@ocrv/vue-tailwind-pagination';
import Pagination from '@/Components/Pagination.vue';
import NavLink from '@/Components/NavLink.vue';

import Swal from 'sweetalert2';
const props= defineProps({
	producto:{type:Object},flash:{type:Object},categoria:{type:Object}
	
});
const form = useForm({idProducto:'',producto:'',precio:'',stock:'',categoria:'',idCategoria:''});

const v = ref({	producto:'',idCategoria:'',precio:'',stock:''});


const showModalDel = ref(false);
const showModalForm = ref(false);
let operation = ref(1);



const title = ref('');




const msj = ref((props.flash.success != null) ? props.flash.success: '');
const classMsj = ref((props.flash.success != null) ? ' ' : 'hidden');

const openModalForm = (op,b) =>{


showModalForm.value = true;
operation = op;
if (op===1){
    title.value='Crear un nuevo producto';
}else{
    title.value='Editar un producto';
    form.idCategoria=b.idCategoria;
    form.categoria=b.categoria;
    form.producto=b.producto;
    form.precio=b.precio;
    form.stock=b.stock;


}
 
}

const openModalDel = (b) =>{
    form.idProducto = b.idProducto;
    form.producto = b.producto;
     
}

const closeModalDel = ()=>{
    showModalDel.value=false;
}


const deletedProductos= (idProducto,producto) =>{
    const alerta=Swal.mixin({
       buttonsStyling:true
    });
    alerta.fire({

        title:'Desea eliminar el producto? '+  producto +' ? ',
        icon:'question', showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Si, eliminar',
        cancelButtonText:'<i class="fa-solid fa-ban"></i> Cancelar',
    }).then((result) => {
        if(result.isConfirmed) {
		    
            form.delete(route('productos.destroy',idProducto),{
                onSuccess: () => {ok('Categoria eliminada')}
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
        form.post(route('productos.store'), {
            onSuccess: () => { ok('Producto creada') }
        });
    } else {
        form.put(route('productos.update', form.idProducto), {
            onSuccess: () => { ok('Producto editada') }
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
	<Head title="PRODUCTO"/>
	
	<AuthenticatedLayout>
		<template #header>
			GESTION STOCK Y PRODUCTOS //
		</template>

		<DIV class="pb-2 flex justify-between items-center">

			
<DarkButton @click="openModalForm(1) "> <div class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg>
<P class="text-xl mx-2">NUEVO REGISTRO</P> 
	</div>

    
		</DarkButton>
		<vueTailwindPaginationUmd class="relative" 
       :current="producto.currentPage" :total="producto.total" 
       :per-page="producto.perPage"
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
                    <th class="px-1 py-3 text-center">PRODUCTO</th>
                    <th class="px-1 py-3 text-center">CATEGORIA</th>
                    <th class="px-1 py-3 text-center">PRECIO S/.</th>
                    <th class="px-1 py-3 text-center">STOCK</th>
                    <th class="px-1 py-3 text-center">EDITAR</th>
                    <th class="px-1 py-3 text-center">BORRAR</th>

                </tr>
            </thead>
            <tbody class="text-gray-900 font-bold divide-y dark:divide-gray-700 dark:bg-blue-50">
                <tr v-for="(b, i) in producto.data" :key="b.idProducto" class="text-gray-500">
                    <td class="px-1 py-3 text-sm text-center">{{ b.producto }}</td>
                    <td class="px-1 py-3 text-sm text-center">{{ b.categoria.categoria }}</td>
                    <td class="px-1 py-3 text-sm text-center">{{ b.precio }}</td>

                    <td class="px-1 py-3 text-sm text-center text-gray-700" :class="{  'bg-red-400': b.stock < 20,  'bg-green-400': b.stock >= 20  }"> {{ b.stock }}</td>
                    <td class="px-1 py-3 text-sm text-center">
                        <WarningButton @click="openModalForm(2, b)" >

                    
    
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                            </svg>
                        </WarningButton>
                    </td>

                    <td class="px-1 py-3 text-sm text-center">
                        <DeleteButton @click="$event => deletedProductos(b.idProducto,b.producto)">
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
<Modal :show="showModalForm" @close="closeModalForm">
			<div class="p-6">
                 <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>
				 <div class="m-6 mb-6 space-y-6 max-w-xl ">


                    <span >NOMBRE DEL PRODUCTO: </span>
                    <InputGroup :text="'NOMBRE DEL PRODUCTO'" :require="'required'" v-model="form.producto" :type="'text'">
						
                    
                       -


					</InputGroup>   

					<br>
					<InputError class="mt-1" :message="form.errors.producto"></InputError>

                    <span >CATEGORIA: </span>

					<SelectInput :text="'CATEGORIA'" :require="'required'" v-model="form.idCategoria" :type="'text'" :options="categoria">
						
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                        </svg>



					</SelectInput>
                    <br>
					<InputError class="mt-1" :message="form.errors.idCategoria"></InputError>

                    <span>PRECIO: </span>

                    <InputGroup :text="'PRECIO'" :require="'required'" v-model="form.precio" :type="'text'">
						
                        -



					</InputGroup>
                    <br>
					<InputError class="mt-1" :message="form.errors.precio"></InputError>
                    <span>STOCK: </span>

                    <InputGroup :text="'STOCK'" :require="'required'" v-model="form.stock" :type="'text'">
						
                        -


					</InputGroup>
					
					<InputError class="mt-1" :message="form.errors.stock"></InputError>

					

					

					<PrimaryButton @click="save">Guardar</PrimaryButton>
				 </div>
			</div>
			<div class="m-6 flex justify-end">
				<SecondaryButton @click="closeModalForm">Cancel</SecondaryButton>
			</div>
		</Modal>

   

        <Modal :show="showModalDel" @close="closeModalDel">
            <div class="p-6">
                  <p class="text-2xl text-gray-500">
                    Estas seguro de que deseas elimnar a 
                    <span class="text-2xl font-medium text-gray-900"></span> ? 
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
