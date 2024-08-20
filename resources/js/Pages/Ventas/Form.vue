<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import DarkButton from '@/Components/DarkButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputGroup from '@/Components/InputGroup.vue';
import InputError from '@/Components/InputError.vue';
import { ref, computed } from 'vue';
import SelectInput from '@/Components/SelectInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
const form = useForm({
    tipofacturacion: '',   // Tipo de facturación (Factura o Boleta)
    fecha: '',             // Fecha de la venta
    montobruto: 0,         // Monto bruto antes de IGV
    igv: 0,                // IGV calculado
    montoneto: 0,          // Monto neto (bruto + IGV)
    id: '',                // ID del vendedor (autenticado)
    cliente: '',           // Nombre del cliente
    productos: []          // Productos seleccionados
});

const cantidad = ref(1);

const props = defineProps({
    flash: { type: Object },
    productos: { type: Object },
});

// Lista de productos seleccionados
const selectedProduct = ref(null);
const selectedProducts = ref([]);

// Función para añadir producto
function addProduct() {
  if (selectedProduct.value) {
    // Verifica si el producto ya está en la lista utilizando el idProducto
    const productExists = selectedProducts.value.some(product => product.idProducto === selectedProduct.value.idProducto);

    if (!productExists) {
      const newProduct = {
        idProducto: selectedProduct.value.idProducto,
        nombre: selectedProduct.value.producto,
        cantidad: cantidad.value,
        precio: selectedProduct.value.precio,
        subtotal: cantidad.value * selectedProduct.value.precio
      };

      selectedProducts.value.push(newProduct);
      selectedProduct.value = null;
      cantidad.value = 1;

      // Actualizar los totales después de añadir un producto
      calculateTotals();
    } else {
      alert('Este producto ya ha sido añadido.');
    }
    
  }
}

// Calcular el total bruto de la venta
function calculateTotalVenta() {
  return selectedProducts.value.reduce((acc, product) => acc + product.subtotal, 0);
}

// Cálculo del IGV y monto neto
function calculateTotals() {
    form.montobruto = calculateTotalVenta();
    form.igv = form.montobruto * 0.18; // Asumiendo un IGV del 18%
    form.montoneto = form.montobruto + form.igv;
}

// Función para eliminar un producto de la lista
function removeProduct(index) {
    selectedProducts.value.splice(index, 1);
    calculateTotals(); // Actualizar los totales después de eliminar un producto
}

// Enviar formulario
const submitForm = () => {
    form.montobruto = calculateTotalVenta();
    form.igv = form.montobruto * 0.18;
    form.montoneto = form.montobruto + form.igv;
    form.productos = selectedProducts.value;

    form.post(route('ventas.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            selectedProducts.value = [];
        }
    });
};

// Establecer la fecha actual
form.fecha = new Date().toISOString().slice(0, 10);

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

        <div class="min-w-0 px-4">
            <form @submit.prevent="submitForm" class="mt-6 space-y-3 max-w-full">
                <div class="grid gap-6 mb-8 p-4 md:grid-cols-1 lg:grid-cols-5">
                    <!-- Columna 1: Selección de Productos e Información del Cliente -->
                    <div class="lg:col-span-2 space-y-4 border rounded-lg shadow-xs p-5">
                        <div class="flex space-x-4">
                            <div class="flex-1">
                                <label for="tipofacturacion" class="block text-sm font-medium text-gray-700">TIPO DE DOCUMENTO</label>
                                <select v-model="form.tipofacturacion" id="tipofacturacion" name="tipofacturacion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Seleccionar...</option>
                                    <option value="FACTURA">FACTURA</option>
                                    <option value="BOLETA">BOLETA</option>
                                </select>
                            </div>
                            <div class="flex-1">
                                <label for="cliente" class="block text-sm font-medium text-gray-700">Nombre del Cliente</label>
                                <input v-model="form.cliente" type="text" id="cliente" name="cliente" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                        </div>

                        <div class="flex space-x-4">
                            <div class="flex-1">
                                <label for="vendedor" class="block text-sm font-medium text-gray-800">Vendedor</label>
                                <input type="text" id="vendedor" name="vendedor" :value="$page.props.auth.user.name" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-md bg-gray-200 text-gray-800 sm:text-sm p-2" />
                            </div>
                            <div class="flex-1">
                                <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                                <input readonly v-model="form.fecha" type="text" id="fecha" name="fecha" class="mt-1 block w-full border-gray-300 rounded-md shadow-md bg-gray-200 text-gray-800 sm:text-sm p-2" />
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
                                <input v-model="cantidad" type="number" id="cantidad" name="cantidad" value="1" min="1" step="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                        </div>

                        <div class="flex justify-end mt-4">
                            <SecondaryButton @click="addProduct" type="button">Añadir producto</SecondaryButton>
                        </div>
                    </div>

                    <!-- Columna 2: Tabla de Productos Seleccionados -->
                    <div class="lg:col-span-3 space-y-0">
                        <div class="border shadow-xs rounded-t-lg p-4">
                            <h3 class="text-lg font-medium text-gray-900">Productos Seleccionados</h3>
                            <div class="overflow-x-auto relative rounded-t-lg shadow-xs mt-4">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 shadow-sm sm:rounded-lg">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-blue-700 dark:text-gray-100">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Producto</th>
                                            <th scope="col" class="px-6 py-3">Cantidad</th>
                                            <th scope="col" class="px-6 py-3">Precio</th>
                                            <th scope="col" class="px-6 py-3">Subtotal</th>
                                            <th scope="col" class="px-6 py-3"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="border">
                                        <tr v-for="(product, index) in selectedProducts" :key="product.id" class="bg-white border-b dark:bg-gray-50 dark:border-gray-700">
                                            <td class="px-6 py-4  text-gray-800 font-medium ">{{ product.nombre }}</td>
                                            <td class="px-6 py-4  text-gray-800">{{ product.cantidad }}</td>
                                            <td class="px-6 py-4  text-gray-800">{{ product.precio.toFixed(2) }}</td>
                                            <td class="px-6 py-4  text-gray-800">{{ product.subtotal.toFixed(2) }}</td>
                                            <td class="px-6 py-4  text-gray-800">
                                                <button @click="removeProduct(index)" type="button" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600">Quitar</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="p-4">
                            <div class="flex justify-between">
                                <div>
                                    <p class="text-gray-600">Monto Bruto:</p>
                                    <p class="text-gray-600">IGV (18%):</p>
                                    <p class="text-gray-900 font-semibold">Monto Neto:</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-600">{{ form.montobruto.toFixed(2) }}</p>
                                    <p class="text-gray-600">{{ form.igv.toFixed(2) }}</p>
                                    <p class="text-gray-900 font-semibold">{{ form.montoneto.toFixed(2) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <PrimaryButton type="submit">Registrar Venta</PrimaryButton>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
