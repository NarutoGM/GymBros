<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import Modal from '@/Components/Modal.vue';
import DarkButton from '@/Components/DarkButton.vue';
import DeleteButton from '@/Components/DeleteButton.vue';
import {ref,onMounted} from 'vue';
import { Head , useForm} from '@inertiajs/vue3';
import InputGroup from '@/Components/InputGroup.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import vueTailwindPaginationUmd from '@ocrv/vue-tailwind-pagination';
import Pagination from '@/Components/Pagination.vue';
import NavLink from '@/Components/NavLink.vue';
import axios from 'axios';

import Swal from 'sweetalert2';
const props= defineProps({
	ventas:{type:Object},flash:{type:Object},timeTakenInSeconds: { type: Number }
	
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
  const start_time = localStorage.getItem('startTime3');
  localStorage.removeItem('startTime3'); // Resetea el startTime en localStorage

  form2.year = selectedYear.value;
  form2.month = selectedMonth.value;
  form2.start_time = start_time;

  // Realizar la solicitud GET
  form2.get(route('ventas.index'), {
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
    
    async imprimir(idVentas) {
    try {
        const response = await axios({
            url: `/ventas/imprimir/${idVentas}`, // Interpolación de la variable idVentas
            method: 'GET',
            responseType: 'blob' // Importante para manejar archivos binarios
        });

        // Crea un enlace para descargar el archivo PDF
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'Hoja_Blanque.pdf'); // Nombre del archivo
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } catch (error) {
        console.error('Error al descargar el PDF:', error);
    }
}

    
  },
};
</script>
<template>
	<Head title="VENTAS" />
	
	<AuthenticatedLayout>
		<template #header>
			REPORTE DE VENTAS //

		</template>


            <div>
    <p
      v-if="props.timeTakenInSeconds !== null"
      class="bg-green-500 text-white p-4 rounded-md"
      ref="timeMessage"
    >
      Tiempo transcurrido: {{ props.timeTakenInSeconds }} segundos
    </p>
  </div>



		<DIV class="pb-2 flex justify-between items-center">
            <NavLink :href="route('ventas.create',id)">
  <div class="flex items-center bg-blue-800 text-white p-2 rounded hover:bg-blue-800 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
    </svg>
    <P class="text-xl mx-2">NUEVA VENTA</P> 
  </div>
</NavLink>

			
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


    
  </div>

 
        
        
	   

		</DIV>


    <div v-if="visible" class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md" :class="classMsj">
    <div class="flex justify-center items-center w-12 bg-green-500">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
      </svg>
    </div>
    <div class="px-4 py-2 -mx-3">
      <div class="mx-3">
        <span class="font-semibold text-green-500">Success</span>
        <p class="text-sm text-gray-600">{{ msj }}</p>
      </div>
    </div>
  </div>
			
			

			<div class="w-full overflow-hidden rounded-lg border shadow-md">
    <div class="w-full overflow-x-auto bg-white">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-sm font-semibold tracking-wide text-gray-100 uppercase border-b bg-blue-600">
                    <th class="px-1 py-3 text-center">NUMERO</th>

                    <th class="px-1 py-3 text-center">FECHA</th>
                    <th class="px-1 py-3 text-center">HORAS</th>
                    <th class="px-1 py-3 text-center">DOCUMENTO</th>

                    <th class="px-1 py-3 text-center">CLIENTE</th>

                    <th class="px-1 py-3 text-center">VENDEDOR</th>

                    <th class="px-1 py-3 text-center">TOTAL VENTA</th>
                    <th class="px-1 py-3 text-center">IMPRIMIR</th>



                </tr>
            </thead>
            <tbody class="text-gray-900 font-bold divide-y dark:divide-gray-700">
                <tr v-for="(b, i) in ventas.data" :key="b.idVentas" class="text-gray-500">
                    <td class="px-1 py-3 text-sm text-center">
    {{ new Date(b.fecha).getFullYear() + '-' + b.idVentas.toString().padStart(7, '0') }}
</td>
                    <td class="px-1 py-3 text-sm text-center">{{ new Date(b.fecha).toLocaleDateString() }}</td>

                    <td class="px-1 py-3 text-sm text-center">{{ new Date(b.fecha).toLocaleTimeString() }}</td>
                    <td class="px-1 py-3 text-sm text-center">{{ b.tipofacturacion }}</td>

                    <td class="px-1 py-3 text-sm text-center">{{ b.cliente }}</td>

           
                    <td class="px-1 py-3 text-sm text-center">{{ b.user.name  }}</td>



                    <td class="px-1 py-3 text-sm text-center">{{ b.montoneto }}</td>

                



                         
                   
                    <td class="px-1 py-3 text-sm text-center">
                        <WarningButton @click="$event => imprimir(b.idVentas)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m-6 3.75 3 3m0 0 3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
</svg>


                        </WarningButton>
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
