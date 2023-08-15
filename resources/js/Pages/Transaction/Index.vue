<template>
    <Head title="Book" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Transaction</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Table :cellFormatter="cellFormatter" :action="true" @seeDetail="seeDetail($event)" :actionItems="menu" :exceptColumns="['id', 'transaction_user_id']" :createButton="false" :records="records" :processColumn="false" :columnNames="columns"></Table>
                </div>
            </div>
        </div>
        <Modal :show="showModal" @close="closeModal">
            <Detail :data="data"></Detail>
        </Modal>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import Modal from '@/Components/Modal.vue';
import {ref} from 'vue';
import Detail from './Partials/Detail.vue';
import axios from "axios";

const formatPrice = (value) => {
    let val = (value/1).toFixed(2).replace('.', ',')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
}

const cellFormatter = (value, key) => {
    // console.log(key)
    if(key === 'user')
        return value.name;

    if(key === 'transaction_status' && value === 1)
        return 'Loan';
    else if(key === 'transaction_status' && value === 2)
        return 'Partially Returned';
    else if(key === 'transaction_status' && value === 3)
        return 'Done'
    else if(key === 'transaction_fine_total')
        return formatPrice(value);

    return value;
}

defineProps({
    records: {
        type: Array
    }
});

const showModal = ref(false);
const data = ref([]);

const columns = [
    {
        name: "Transaction Code",
        real: "transaction_code"
    },
    {
        name: "Transaction Date",
        real: "transaction_date"
    },
    {
        name: "Transaction Status",
        real: "transaction_status"
    },
    {
        name: "Fine Total",
        real: "transaction_fine_total"
    },
    {
        name: "User",
        real: "book_publisher"
    }
];

const menu = [
    {
        name: "Detail",
        emitName: "seeDetail",
        classes: "inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150",
        icon: "fas fa-eye"
    }
];

const seeDetail = (event) =>{
    axios.get(route('transaction.detail', {id: event.id})).then((result) => {
        console.log(result.data);
        data.value = result.data;
        showModal.value = true;
    });
}

const closeModal = () =>{
    showModal.value = false;
}
</script>
