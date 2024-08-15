<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import DarkButton from '@/Components/DarkButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputGroup from '@/Components/InputGroup.vue';
import InputError from '@/Components/InputError.vue';
import { ref } from 'vue';
import SelectInput from '@/Components/SelectInput.vue';

import SecondaryButton from '@/Components/SecondaryButton.vue';


const form = useForm({
 dni:'', nombre: '', direccion: '', telefono: '', edad: '', nombreContacto: '', enfermedad: '', institucion: '', fechaRegistro: '', fechaInicio: '', fechaFin: '',membresias:[]

})
const cantidad = ref(1);

const props= defineProps({
	flash:{type:Object},
  productos:{type:Object},

});

const req = ref('required');
const msj = ref('');
const classMsj = ref('hidden');

// Lista de productos disponibles y seleccionados
const selectedProduct = ref(null);
const selectedProducts = ref([]);
function addProduct() {
  if (selectedProduct.value) {
    // Verificar si el producto ya existe en la lista
    const productExists = selectedProducts.value.some(product => product.id === selectedProduct.value.idProducto);

    if (!productExists) {
      const newProduct = {
        id: selectedProduct.value.idProducto,
        nombre: selectedProduct.value.producto,
        cantidad: cantidad.value,
        precio: selectedProduct.value.precio,
        subtotal: cantidad.value * selectedProduct.value.precio
      };

      selectedProducts.value.push(newProduct);

      // Limpiar el producto seleccionado y resetear la cantidad a 1
      selectedProduct.value = null;
      cantidad.value = 1;
    } else {
      alert('Este producto ya ha sido añadido.');
    }
  }
}


function calculateTotalVenta() {
  return selectedProducts.value.reduce((acc, product) => acc + product.subtotal, 0);
}

function removeProduct(index) {
    selectedProducts.value.splice(index, 1);
  }



</script>



<script>
export default {
  data() {
    return {
      currentDate: this.getCurrentDate()
    };
  },
  methods: {
    getCurrentDate() {
      const now = new Date();
      const year = now.getFullYear();
      const month = String(now.getMonth() + 1).padStart(2, '0');
      const day = String(now.getDate()).padStart(2, '0');
      return `${year}-${month}-${day}`;
    }
  }
};
</script>




<template>

	<Head title="REGISTRAR VENTAS" />
	
	<AuthenticatedLayout>
		<template #header>

            <div class="inline-flex overflow-hidden mb-4 w-full items-center justify-between">
                REGISTRAR NUEVA VENTA 

                <NavLink :href="route('ventas.index')">
                    <DarkButton>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
</svg>

                    </DarkButton>
                  </NavLink>
            </div>


		</template>

        <div class="min-w-0 px-4  ">
            <form class="mt-6 space-y-3 max-w-full">
              <div class="grid gap-6 mb-8 p-4 md:grid-cols-1 lg:grid-cols-5">
                <!-- Columna 1: Selección de Productos e Información del Cliente -->
                    <div class="lg:col-span-2 space-y-4  border rounded-lg shadow-xs p-5" >

                        <div class="flex space-x-4">
                         <div class="flex-1">
                          <label for="producto" class="block text-sm font-medium text-gray-700">TIPO DE DOCUMENTO</label>
                          <select id="producto" name="producto" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <!-- Opciones de productos -->
                            <option value="">Seleccionar...</option>
                            <!-- Reemplaza con opciones dinámicas si es necesario -->
                            <option value="1">FACTURA</option>
                            <option value="2">BOLETA</option>
                          </select>
       </div>
  <div class="flex-1">
    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Cliente</label>
    <input type="text" id="nombre" name="nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
  </div>
</div>

<div class="flex space-x-4">

<div class="flex-1">
  <label for="vendedor" class="block text-sm font-medium text-gray-800">Vendedor</label>
  <input 
    
    type="text" 
    id="vendedor" 
    name="vendedor" 
    :value="$page.props.auth.user.name" 
    readonly 
    class="mt-1 block w-full border-gray-300 rounded-md shadow-md bg-gray-200 text-gray-800 sm:text-sm p-2" 
  />
</div>



  <div class="flex-1">
    <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
    <input readonly :value="currentDate" type="text" id="fecha" name="fecha" class="mt-1 block w-full border-gray-300 rounded-md shadow-md bg-gray-200 text-gray-800 sm:text-sm p-2" />
  </div>
</div>


<div class="flex space-x-4">
  <div class="flex-1">
    <label for="productos" class="block text-sm font-medium text-gray-700">PRODUCTO</label>
    
    
    <select v-model="selectedProduct" id="producto" name="producto" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
  <option value="">Seleccionar...</option>
  <option v-for="producto in productos" :key="producto.idProducto" :value="producto">
    {{ producto.producto }}
  </option>
</select>
  
  
  
  </div>
  <div class="flex-1">
  <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad</label>
  <input 
    v-model="cantidad"
    type="number" 
    id="cantidad" 
    name="cantidad" 
    value="1" 
    min="1" 
    step="1" 
    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
  />
</div>

</div>



                        <div>






  
                        </div>
                        <div class="flex justify-end mt-4">
                          <SecondaryButton @click="addProduct" type="button">Añadir producto</SecondaryButton>
                        </div>
                        <!-- Agrega más campos si es necesario -->
                    </div>

                    <!-- Columna 2: Tabla de Productos Seleccionados -->
                    <div class="lg:col-span-3 space-y-0">
    <div class="border shadow-xs rounded-t-lg p-4">
        <h3 class="text-lg font-medium text-gray-900">Productos Seleccionados</h3>
        <div class="overflow-x-auto mt-4">
            <table class="min-w-full divide-y divide-gray-200 w-full">
                <thead class="bg-blue-700">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">PRODUCTO</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">CANTIDAD</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">PRECIO</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">SUBTOTAL</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">BORRAR</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Aquí se agregarán las filas dinámicamente -->
                    <tr v-for="item in selectedProducts" :key="item.id">
                        <td class="px-4 py-4 whitespace-nowrap">{{ item.id }}</td>
                        <td class="px-4 py-4 whitespace-nowrap">{{ item.nombre }}</td>
                        <td class="px-4 py-4 whitespace-nowrap">{{ item.cantidad }}</td>
                        <td class="px-4 py-4 whitespace-nowrap">{{ item.precio }}</td>
                        <td class="px-4 py-4 whitespace-nowrap">{{ item.subtotal }}</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <button @click="removeProduct(index)" class="text-red-500 hover:text-red-700">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="flex border shadow-xs rounded-b-lg rounded-t-none justify-between p-2 bg-gray-100">
    <SecondaryButton type="submit" class="ml-2">Registrar Venta</SecondaryButton>
    <div class="flex items-center">
        <label for="totalVenta" class="mr-2 text-gray-700 font-medium">Total a Pagar:</label>
        <input 
            type="text" 
            id="totalVenta" 
            name="totalVenta" 
            placeholder="S/. 0" 
            class="w-32 border-gray-300 rounded-md shadow-md bg-gray-200 text-gray-700 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2"
            :value="calculateTotalVenta()" 
            readonly
        />
    </div>
</div>

</div>

                </div>

            </form>
</div>

    



    </AuthenticatedLayout>

</template>