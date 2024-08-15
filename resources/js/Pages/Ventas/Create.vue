<script setup>
import Form from './Form.vue';
const props = defineProps({
    productos: { type: Object }
});
</script>


<template>
    <Form :productos="productos">
        
    </Form>
</template>    