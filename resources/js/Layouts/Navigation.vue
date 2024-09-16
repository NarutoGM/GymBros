<template>
  <aside class="z-20 hidden w-64 overflow-y-auto bg-blue-800 md:block flex-shrink-0">
    <div class="py-4 text-gray-100">
      <Link class="ml-6 text-lg font-bold text-gray-100" :href="route('dashboard')">
      Gym Bros
      </Link>

      <ul class="mt-6">
        <li class="relative px-6 py-3">
          <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
            <template #icon>
             <img src="/images/supervision.png" alt="" width="15%">
            </template>
            Dashboards
          </NavLink>
        </li>

        <li class="relative px-6 py-3">
          <NavLink :href="route('users.index')" :active="route().current('users.index')">
            <template #icon>
              <img src="/images/user-interface.png" alt="" width="15%">
            </template>
            Users
          </NavLink>
        </li>

        <li class="relative px-6 py-3">
          <button @click="showingTwoLevelMenu = !showingTwoLevelMenu"
            class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800"
            aria-haspopup="true">
            <span class="inline-flex items-center">
              <img src="/images/suplemento-proteico.png" alt="" width="15%">


              <span class="ml-4">SUPLEMENTOS</span>
              
            </span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="  width: 48px;
              height: 48px;">
             <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
              </svg>


          </button>
          <ul v-show="showingTwoLevelMenu"
            class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50"
            aria-label="submenu">
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800">
                <a class="w-full" :href="route('productos.index')" :active="route().current('productos.index')"
                  @click="saveTimeInLocalStorage">
                    <div class="flex"></div> INVENTARIOS
                </a>
            </li>
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800">
                <a class="w-full" :href="route('categorias.index')" :active="route().current('categorias.index')">CATEGORIAS</a>
            </li>
          </ul>
        </li>

       
        <li class="relative px-6 py-3">

          <NavLink :href="route('ventas.index')" :active="route().current('ventas.index')">
            <template #icon>
              <img src="/images/compras.png" alt="" width="15%">
            </template>

            <a @click="saveTimeInLocalStorage3">
                    <div class="flex"></div> VENTAS
                </a>
            
          </NavLink>
        </li>

        
         <li class="relative px-6 py-3">

          <NavLink :href="route('membresias.index')" :active="route().current('membresias.index')">
            <template #icon>
              <img src="/images/tarjeta-de-membresia.png" alt="" width="15%">
            </template>
            MEMBRESIAS  
          </NavLink>
        </li>   
        <li class="relative px-6 py-3">



          <NavLink :href="route('miembros.index')" :active="route().current('miembros.index')">
            <template #icon>
              <img src="/images/dar-dinero.png" alt="" width="15%">
            </template>
            MATRÍCULAS/MIEMBROS
          </NavLink>
        </li>       

        <li class="relative px-6 py-3">

          <NavLink :href="route('ventas.index')" :active="route().current('ventas.index')">
            <template #icon>
              <img src="/images/lista-de-verificacion.png" alt="" width="15%">
            </template>
            MARCAR ASISTENCIAS
          </NavLink>
        </li>       

        <li class="relative px-6 py-3">

<NavLink :href="route('movimientos.index')" :active="route().current('movimientos.index')">
  <template #icon>
    <img src="/images/reporte-de-negocios.png" alt="" width="15%">
  </template>

                <a @click="saveTimeInLocalStorage2">
                    <div class="flex"></div> MOVIMIENTOS
                </a>
</NavLink>
</li> 
      </ul>
    </div>
  </aside>
</template>

<script>
import NavLink from '@/Components/NavLink.vue'
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue'

export default {
  components: {
    NavLink,
    Link,
  },
  methods: {
    saveTimeInLocalStorage() {
      localStorage.setItem('startTime', Date.now());
    },
    saveTimeInLocalStorage2() {
      localStorage.setItem('startTime2', Date.now());
    },
    saveTimeInLocalStorage3() {
      localStorage.setItem('startTime3', Date.now());

    }
  },
  setup() {
    let showingTwoLevelMenu = ref(false)

    return {
      showingTwoLevelMenu
    }
  },
}
</script>
