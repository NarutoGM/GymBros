<script setup>
import Form from './Form.vue';
const props = defineProps({

     miembros:{type:Object}
});
</script>


<template>
    <Form :miembros="miembros">
        
    </Form>
</template>    