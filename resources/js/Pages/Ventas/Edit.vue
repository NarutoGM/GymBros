<script setup>
import Form from './Form.vue';
const props = defineProps({

     miembros:{type:Object},
     membresias:{type:Object},
     membresiasOfMiembros:{type:Object}
});
</script>


<template>
    <Form :miembros="miembros" :membresias="membresias" :membresiasOfMiembros="membresiasOfMiembros">
        
    </Form>
</template>    