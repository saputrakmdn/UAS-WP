<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, useForm} from '@inertiajs/vue3';
import Table from "@/Components/Table.vue";
import Chart from "@/Components/Chart.vue"
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    transaction_date: '',
    return_date: ''
})
const props = defineProps({
    data: {
        type: Array
    },
    dataStatus: {
        type: Array
    }
});

const columns = [
    {
        name: "Book Name",
        real: "book"
    },
    {
        name: "User",
        real: 'user'
    },
    {
        name: "Transaction Date",
        real: 'transaction_date'
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
        name: 'Status',
        real: 'status'
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

const bookName = [];
const qty = [];
// const profit = [];
// const total = [];
//
for(let i = 0; i < props.data.length; i++) {
    if(props.data[i].book_name) {
        bookName.push(props.data[i].book_name)
    }

    if(props.data[i].qty) {
        qty.push(props.data[i].qty)
    }
    // if(props.data[i].profit) {
    //     profit.push(props.data[i].profit)
    // }
    // if(props.data[i].total) {
    //     total.push(props.data[i].total)
    // }
}

const formatPrice = (value) => {
    let val = (value/1).toFixed(2).replace('.', ',')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
}

const cellFormatter = (value, key) => {
    return value;
}

const labels = ['On Time', 'Late'];

const exceptColumns = ['id','deleted_at','created_at','updated_at', 'barang_id', 'user_id'];

const filter = () => {
    form.get(route('reporting.index'))
}
</script>

<template>
    <Head title="Reporting"></Head>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reporting</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-xl text-gray-800 leading-tight ml-3 mt-3">Filter:</h3>
                    <div class="flex">
                        <div class="flex flex-col ml-3 mt-3" style="width: 150px;">
                            <p class="text-base leading-none text-gray-800">Transaction Date</p>
                            <TextInput
                                id="name"
                                type="date"
                                v-model="form.transaction_date"
                                class="border border-gray-300 bg-gray-300 rounded-lg focus:ring-gray-300 focus:ring-gray-300"
                                autocomplete="name"
                            />
                        </div>
                        <div class="flex flex-col ml-3 mt-3" style="width: 150px;">
                            <p class="text-base leading-none text-gray-800">Return Date</p>
                            <TextInput
                                id="name"
                                type="date"
                                v-model="form.return_date"
                                class="border border-gray-300 bg-gray-300 rounded-lg focus:ring-gray-300 focus:ring-gray-300"
                                autocomplete="name"
                            />
                        </div>
                        <PrimaryButton class="ml-3 mt-7" @click="filter">Filter</PrimaryButton>
                    </div>
                    <Table :records="data" :processColumn="false" :columnNames="columns" :cellFormatter="cellFormatter" :createButton="false" :exceptColumns="exceptColumns"></Table>
                </div>
                <div class="bg-white mt-3 overflow-hidden shadow-sm sm:rounded-lg">
                    <h2 class="h2 text-center text-2xl">Grafik Peminjaman</h2>
                    <div class="flex flex-col justify-center items-center">
                        <div class="pl-20 pr-20 w-3/4">
                            <Chart :dataProps="qty" :labels="bookName" :chartType="'bar'" :title='"Buku Paling Banyak Dipinjam"' :canvasId="'bookMostLoan'"></Chart>
                        </div>
                        <div class="pl-20 pr-20 w-2/4">
                            <h2 class="mt-4 h2 text-center text-2xl">Persentase Pengembalian Buku</h2>
                            <Chart :dataProps="dataStatus" :labels="labels" :chartType="'pie'" :title='"Presentasi ketelambatan pengembalian"' :canvasId="'totalStatus'"></Chart>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
