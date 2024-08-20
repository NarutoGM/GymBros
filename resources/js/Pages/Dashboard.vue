<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useRouter } from 'vue-router'; // Asegúrate de importar useRouter
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const prod = ref([]);
const mov = ref([]);
const chartData1 = ref([]);
const chartOptions1 = ref([]);
const chartData2   = ref([]);
const chartOptions2 = ref([]);
const prod2 = ref([]);
const mov2 = ref([]);
const colors = ref([]);

const ramdom =() =>{
  return Math.floor(Math.random()*256);
}




const props = defineProps({
  movimientos: { type: Object },
  productos: { type: Object },
  entradaCount: { type: Number},
  salidaCount: { type: Number}
});

props.productos.forEach(row => {
  prod.value.push(row.producto),
  mov.value.push(row.movimientos),
  colors.value.push('rgb(' + ramdom()+ ',' + ramdom()+ ',' + ramdom() + ')')

});

chartOptions1.value = {Responsive:true};

chartData1.value = {
  labels:prod.value,
  datasets:[{
    label:'Productos', data:prod.value,backgroundColor:colors
  }]
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

const selectedYear = ref(currentYear);
const selectedMonth = ref(new Date().getMonth() + 1);
function updateDashboard() {
  router.push({ 
    path: `/dashboard/${selectedMonth.value}/${selectedYear.value}`,
    query: { ...router.currentRoute.value.query }
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
			<div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
              <!-- Card -->
              <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                  </svg>
                </div>
                <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-100">
                    Entradas
                  </p>
                  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{entradaCount}}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                  </svg>
                </div>
                <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-100">
                    Salidas
                  </p>
                  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{salidaCount}}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                  </svg>
                </div>
                <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-100">
                    MOVIMIENTOS
                  </p>
                  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ movimientos.length }}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                  </svg>
                </div>
                <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-100">
                    PRODUCTOS
                  </p>
                  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ productos.length }}
                  </p>
                </div>
              </div>

            <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
               <div class="min-w-0 p-4 rounded-lg shadow-xs">
                       <Span class="text-lg p-4">MOVIMIENTOS POR PRODUCTOS</Span>
                       <div class="flex items-center">
                        <Bar :data="chartData1" :options="chartOptions1">  </Bar>
                       </div>
               </div>
               <div class="min-w-0 p-4 rounded-lg shadow-xs">

                </div>

            </div>

            </div>
		</div>
	</AuthenticatedLayout>
</template>
