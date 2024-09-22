<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const prod = ref([]);
const mov = ref([]);
const chartData1 = ref([]);
const chartOptions1 = ref([]);
const colors = ref([]);

const ramdom =() =>{
  return Math.floor(Math.random()*256);
}




const props = defineProps({
  movimientos: { type: Object },
  totalproductos: { type: Number },

  totalcategorias: { type: Number },
  producto: { type: Object },
  entradaCount: { type: Number},
  salidaCount: { type: Number},
  ultimosagregados: { type: Object },
  ultimosvendidos: { type: Object },

});






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

const selectedYear = ref(currentYear);
const selectedMonth = ref(new Date().getMonth() + 1);


const form2 = useForm({
  year: selectedYear.value,
  month: selectedMonth.value
});
function updateDashboard() {
  // Actualizar los valores del formulario antes de enviar la solicitud
  form2.year = selectedYear.value;
  form2.month = selectedMonth.value;

  // Realizar la solicitud GET
  form2.get(route('dashboard'), {
    onSuccess: (response) => {
      console.log('Datos recibidos:', response.data);
      // Manejar los datos de respuesta, actualizando el estado del componente o realizando otras acciones
    },
    onError: (error) => {
      console.error('Error al actualizar el dashboard:', error);
    }
  });
}
</script>

<template>
	<Head title="Dashboard" />
	
	<AuthenticatedLayout>
		<template #header>
			DASHBOARD DE ENTRADAS Y SALIDAS
		</template>

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
		
		<div class="p-4 bg-white rounded-lg shadow-xs">

      <div class="flex flex-row space-x-4">
  <!-- Card 1 -->
  <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
    <div class="p-4 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
  <path d="M3 3h12a1 1 0 011 1v12a1 1 0 01-1 1H3V3zm1 1v11h10V4H4zm6 4v1h2v-1h-2zM5 5v1h1V5H5z" />
</svg>


    </div>
    <div>
      <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-100">ENTRADAS</p>
      <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{entradaCount}}</p>
    </div>
  </div>

  <!-- Card 2 -->
  <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
    <div class="p-4 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
  <path d="M3 3h12a1 1 0 011 1v12a1 1 0 01-1 1H3V3zm1 1v11h10V4H4zm8 5h2l-3-3v2H8v2h3v2l3-3h-2z" />
</svg>


    </div>
    <div>
      <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-100">SALIDAS</p>
      <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{salidaCount}}</p>
    </div>
  </div>

  <!-- Card 3 -->
  <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
    <div class="p-4 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
  <path d="M7 10l-3 3 3 3v-2h6v2l3-3-3-3v2H7v-2zm2-8v2h6v6h2V2H9zM4 14v2H2v-6h2v6z" />
</svg>


    </div>
    <div>
      <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-100">MOVIMIENTOS</p>
      <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{movimientos.data.length}}</p>
    </div>
  </div>

  <!-- Card 4 -->
  <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
    <div class="p-4 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
  <path d="M7 2a2 2 0 012-2h2a2 2 0 012 2v2h-6V2zm6 2v2h-6V4h6zm-1 4v10a1 1 0 01-1 1H9a1 1 0 01-1-1V8h4zm-2 6v-2H9v2h2zm0-4v-2H9v2h2z" />
</svg>


    </div>
    <div>
      <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-100">PRODUCTOS</p>
      <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{totalproductos}}</p>
    </div>
  </div>

  <!-- Card 5 -->
  <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
    <div class="p-4 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
  <path fill-rule="evenodd" d="M4 2a1 1 0 00-1 1v1h14V3a1 1 0 00-1-1H4zm0 2v1h12V4H4zm-1 3a1 1 0 011-1h12a1 1 0 011 1v1H3V9zm0 2v5a1 1 0 001 1h12a1 1 0 001-1v-5H3zm5 3v-1H5v1h3z" clip-rule="evenodd"></path>
</svg>

    </div>
    <div>
      <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-100">CATEGORIAS</p>
      <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{totalcategorias}}</p>
    </div>
  </div>
</div>

<br>
<div class="w-full overflow-hidden rounded-lg border shadow-md">
    <div class="w-full overflow-x-auto bg-white">
      <h2 class="text-xl font-bold m-2">Productos bajos en stock </h2>

        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="text-sm font-semibold tracking-wide text-gray-100 uppercase border-b bg-blue-800">
                    <th class="px-1 py-3 text-center">PRODUCTO</th>

                    <th class="px-1 py-3 text-center">NOMBRE COMERCIAL</th>
                    <th class="px-1 py-3 text-center">CATEGORIA</th>
                    <th class="px-1 py-3 text-center">STOCK</th>

                </tr>
            </thead>
            <tbody class="text-gray-900 font-bold divide-y dark:divide-gray-700 dark:bg-blue-50">
                <tr v-for="(b, i) in producto.data" :key="b.idProducto" class="text-gray-500">
                    <td class="px-4 pyproducto-3 text-center">
    <div class="flex justify-center">
        <img v-if="b.imagen" :src="`/storage/${b.imagen}`" alt="Imagen del Producto" class="h-24 w-24 object-cover">
    </div>
</td>


                    <td class="px-1 py-3 text-sm text-center">{{ b.producto }}</td>
                    <td class="px-1 py-3 text-sm text-center">{{ b.categoria.categoria }}</td>

                    <td class="px-1 py-3 text-sm text-center text-gray-700" :class="{  'bg-red-400': b.stock < 5,  'bg-orange-300': b.stock >= 6  }"> {{ b.stock }}</td>
                    
                   

                    

                    
                </tr>
            </tbody>
        </table>
    </div>
</div>


<br>
<div class="flex justify-between space-x-4">
    <div class="w-1/2">
      <h2 class="text-xl font-bold mb-2">Últimos Agregados</h2>
      <table class="min-w-full bg-white border border-gray-300">
        <thead>
          <tr class="bg-gray-200">
            <th class="py-2 px-4 border">Fecha</th>
            <th class="py-2 px-4 border">Cantidad</th>
            <th class="py-2 px-4 border">Producto</th>
            <th class="py-2 px-4 border">Trabajador</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="movimiento in ultimosagregados" :key="movimiento.idMovimientos">
            <td class="py-2 px-4 border">{{ movimiento.fecha }}</td>
            <td class="py-2 px-4 border">{{ movimiento.cantidad }}</td>
            <td class="py-2 px-4 border">{{ movimiento.productos.producto }}</td>
            <td class="py-2 px-4 border">{{ movimiento.user.name }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="w-1/2">
      <h2 class="text-xl font-bold mb-2">Últimos Vendidos</h2>
      <table class="min-w-full bg-white border border-gray-300">
        <thead>
          <tr class="bg-gray-200">
            <th class="py-2 px-4 border">Fecha</th>
            <th class="py-2 px-4 border">Cantidad</th>
            <th class="py-2 px-4 border">Producto</th>
            <th class="py-2 px-4 border">Trabajador</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="movimiento in ultimosvendidos" :key="movimiento.idMovimientos">
            <td class="py-2 px-4 border">{{ movimiento.fecha }}</td>
            <td class="py-2 px-4 border">{{ movimiento.cantidad }}</td>
            <td class="py-2 px-4 border">{{ movimiento.productos.producto }}</td>
            <td class="py-2 px-4 border">{{ movimiento.user.name }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

		</div>
	</AuthenticatedLayout>
</template>
