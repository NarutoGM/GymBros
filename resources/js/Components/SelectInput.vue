<template>
                  <select class="rounded block w-full pl-5 mt-1 text-sm text-black  dark:border-gray-600 dark:bg-white focus:border-purple-400 focus:outline-none 
                  focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" 
                  :class="{ 'opacity-50': readonly }"
                  :value="modelValue"  
                  @input="$emit('update:modelValue', $event.target.value)" 
                  ref="input" :placeholder="text"
                  :required="required" >

                          <option value="" selected>{{ text }}</option>
                          <option v-for="op in options" :key="op.idCategoria" :value="op.idCategoria">
                            {{ op.categoria }}
                          </option>

                  </select>
                  <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                    <slot>

                    </slot>
                  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';

defineProps(['modelValue','text','options','required','readonly']);

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});
</script>
