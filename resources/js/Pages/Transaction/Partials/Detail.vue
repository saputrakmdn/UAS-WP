<template>
    <Table :columnNames="columns" :createButton="false" :cellFormatter="cellFormatter" :records="data" :processColumn="false"></Table>
</template>
<script setup>
import Table from '@/Components/Table.vue';
import {onMounted, ref} from "vue";
const props = defineProps({
    data: {
        type: Array
    }
});

const columns = [
    {
        name: "Book Name",
        real: "book"
    },
    {
        name: "Quantity",
        real: "qty"
    },
    {
        name: "Return Date",
        real: "return_date"
    },
    {
        name: "Actual Return Date",
        real: "actual_return_date"
    },
    {
        name: "Fine Days",
        real: "fine_days"
    },
    {
        name: "Fine",
        real: 'fine'
    }
 ];

const cellFormatter = (value, key) => {
    // console.log(key)
    if(key === 'actual_return_date' && value === null)
        return '<p class="text-red-600">not return book</p>';
    return value;
}
</script>
