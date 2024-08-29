<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import Modal from '@/Components/Modal.vue';
import DarkButton from '@/Components/DarkButton.vue';
import DeleteButton from '@/Components/DeleteButton.vue';
import {ref,onMounted } from 'vue';
import { Head , useForm} from '@inertiajs/vue3';
import InputGroup from '@/Components/InputGroup.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { useRouter } from 'vue-router';

import PrimaryButton from '@/Components/PrimaryButton.vue';
import vueTailwindPaginationUmd from '@ocrv/vue-tailwind-pagination';
import Pagination from '@/Components/Pagination.vue';
import NavLink from '@/Components/NavLink.vue';

import Swal from 'sweetalert2';
const props= defineProps({
	movimientos:{type:Object},flash:{type:Object},  timeTakenInSeconds: { type: Number }
	
});
const form = useForm({producto:'',precio:'',stock:'',categoria:'',idCategoria:''});

const v = ref({	producto:'',idCategoria:'',precio:'',stock:''});


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
    form.idProducto=b.idProducto;


}
 
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
            onSuccess: () => { ok('Producto creado') }
        });
    } else {
        form.put(route('productos.update', form.idProducto), {
            onSuccess: () => { ok('Producto editado') }
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
    formPage.get(route('productos.index',{page:event}));
}

const currentYear = new Date().getFullYear();
const years = Array.from({ length: 10 }, (v, i) => currentYear - i);
const months = [
  { name: 'Enero', value: 1 },
  { name: 'Febrero', value: 2 },
  { name: 'Marzo', value: 3 },
  { name: 'Abril', value: 4 },
  { name: 'Mayo', value: 5 },
  { name: 'Junio', value: 6 },
  { name: 'Julio', value: 7 },
  { name: 'Agosto', value: 8 },
  { name: 'Septiembre', value: 9 },
  { name: 'Octubre', value: 10 },
  { name: 'Noviembre', value: 11 },
  { name: 'Diciembre', value: 12 },
];

// Definir el estado de los valores seleccionados
const selectedYear = ref(currentYear);
const selectedMonth = ref(new Date().getMonth() + 1);

// Utilizar useForm para gestionar la solicitud
const form2 = useForm({
  year: selectedYear.value,
  month: selectedMonth.value,
  start_time: ''

});

// Función para actualizar el dashboard
function updateDashboard() {
  // Actualizar los valores del formulario antes de enviar la solicitud
  const start_time = localStorage.getItem('startTime2');
  localStorage.removeItem('startTime2'); // Resetea el startTime en localStorage

  form2.year = selectedYear.value;
  form2.month = selectedMonth.value;
  form2.start_time = start_time;

  // Realizar la solicitud GET
  form2.get(route('movimientos.index'), {
    onSuccess: (response) => {
      console.log('Datos recibidos:', response.data);
      // Manejar los datos de respuesta, actualizando el estado del componente o realizando otras acciones
    },
    onError: (error) => {
      console.error('Error al actualizar el dashboard:', error);
    }
  });
}
const timeMessage = ref(null);

onMounted(() => {
  if (props.timeTakenInSeconds !== null) {
    setTimeout(() => {
      if (timeMessage.value) {
        timeMessage.value.style.display = 'none';
      }
    }, 3000); // Ocultar después de 3 segundos
  }
});
</script>

<template>
	<Head title="PRODUCTO"/>
	
	<AuthenticatedLayout>
		<template #header>
			REPORTE DE ENTRADAS Y SALIDAS //
		</template>


        <div>


            <div>
    <p
      v-if="props.timeTakenInSeconds !== null"
      class="bg-green-500 text-white p-4 rounded-md"
      ref="timeMessage"
    >
      Tiempo transcurrido: {{ props.timeTakenInSeconds }} segundos
    </p>
  </div>
  
  <!-- Resto de tu código -->
  </div>

        <div class="pb-2 flex justify-between items-center">
    <div class="flex space-x-4 mt-4">
      <div>
        <label for="year" class="block text-sm font-medium text-gray-700">Año</label>
        <select v-model="selectedYear" id="year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
        </select>
      </div>

      <div>
        <label for="month" class="block text-sm font-medium text-gray-700">Mes</label>
        <select v-model="selectedMonth" id="month" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          <option v-for="month in months" :key="month.value" :value="month.value">{{ month.name }}</option>
        </select>
      </div>

      <button @click="updateDashboard" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded-md">Actualizar</button>
    </div>

    <vue-tailwind-pagination-umd 
      class="relative" 
      :current="movimientos.currentPage" 
      :total="movimientos.total" 
      :per-page="movimientos.perPage"
      @page-changed="onPageClick"
    ></vue-tailwind-pagination-umd>
  </div>


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
                    <th class="px-1 py-3 text-center">NRO MOVIMIENTO</th>

                    <th class="px-1 py-3 text-center">FECHA</th>
                    <th class="px-1 py-3 text-center">HORA</th>

                    <th class="px-1 py-3 text-center">TIPO</th>

                    <th class="px-1 py-3 text-center">PRODUCTO</th>
                    <th class="px-1 py-3 text-center">CANTIDAD</th>
                    <th class="px-1 py-3 text-center">STOCK FINAL</th>

                    <th class="px-1 py-3 text-center">TRABAJADOR</th>

                </tr>
            </thead>
            <tbody class="text-gray-900 font-bold divide-y dark:divide-gray-700 dark:bg-blue-50">
                <tr v-for="(b, i) in movimientos.data" :key="b.idMovimientos" class="text-gray-500">
                    <td class="px-1 py-3 text-sm text-center">
                            {{ b.idMovimientos.toString().padStart(5, '0') }}
                    </td> 

                    <td class="px-1 py-3 text-sm text-center">{{ new Date(b.fecha).toLocaleDateString() }}</td>
                    <td class="px-1 py-3 text-sm text-center">{{ new Date(b.fecha).toLocaleTimeString() }}</td>

                    <td :class="{'bg-green-500': b.tipo === 'E', 'bg-red-500': b.tipo === 'S'}" class="px-1 py-3 text-sm text-center text-white">
                          {{ b.tipo === 'E' ? 'ENTRADA' : (b.tipo === 'S' ? 'SALIDA' : b.tipo) }}
                    </td>
                    <td class="px-1 py-3 text-sm text-center">{{ b.productos?.producto || 'N/A' }}</td>

                    <td class="px-1 py-3 text-sm text-center">{{ b.cantidad }}</td>
                    <td class="px-1 py-3 text-sm text-center">{{ b.stock }}</td>
                    <td class="px-1 py-3 text-sm text-center">{{ b.user?.name || 'N/A' }}</td>

                   


                    
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

   

   
		
	</AuthenticatedLayout>
</template>
