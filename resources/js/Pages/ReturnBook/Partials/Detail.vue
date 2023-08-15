<template>
    <Table :columnNames="columns" :createButton="false" @returnBook="returnBook($event)" :cellFormatter="cellFormatter" :conditionAction="conditionAction" :records="data" :actionItems="menu" :action="true" :processColumn="false"></Table>
</template>
<script setup>
import Table from '@/Components/Table.vue';
import {onMounted, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import {useToast} from "vue-toastification";

const form = useForm({
    id: ''
});

const emit = defineEmits(['close']);

const props = defineProps({
    data: {
        type: Array
    }
});

const conditionAction = {
    object: 'actual_return_date',
    condition: null
}

const menu = [
    {
        name: "Return Book",
        emitName: "returnBook",
        classes: "inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150",
        icon: "fas fa-undo"
    }
];

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

const toast = useToast();

const cellFormatter = (value, key) => {
    // console.log(key)
    if(key === 'actual_return_date' && value === null)
        return '<p class="text-red-600">not return book</p>';
    return value;
}

const returnBook = (event) => {
    form.id = event.id;
    form.post(route('returnbook.process', {detailTransaction: form.id}),{
        preserveScroll: true,
        onSuccess: () =>{
            form.reset();
            toast.success("Success return book!", {
                timeout: 5000
            });

            emit('close');
        }
    });
}
</script>
