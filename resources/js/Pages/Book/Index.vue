<template>
    <Head title="Book" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Book</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Table @onCreate="onNewRecord" :exceptColumns="['id', 'book_type_id', 'created_at', 'updated_at']" @onDelete="onDeleteData($event)" @onEdit="onEditData($event)" :menuItems="menu" :records="records" :processColumn="true" :columnNames="columns"></Table>
                </div>
            </div>
        </div>
        <Modal :show="createModal" @close="closeCreateModal">
            <CreateForm @close="closeCreateModal" :bookType="bookType"></CreateForm>
        </Modal>

        <Modal :show="deleteModal" @close="closeDeleteModal">
            <DeleteForm :data="data" @close="closeDeleteModal"></DeleteForm>
        </Modal>
        <Modal :show="editModal" @close="closeEditModal">
            <EditForm :data="data" @close="closeEditModal" :bookType="bookType"></EditForm>
        </Modal>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import Modal from '@/Components/Modal.vue';
import CreateForm from './Partials/CreateForm.vue';
import DeleteForm from './Partials/DeleteForm.vue';
import EditForm from './Partials/EditForm.vue';
import {ref} from 'vue';

defineProps({
    records: {
        type: Array
    },
    bookType: {
        type: Array
    }
});

const createModal = ref(false);
const deleteModal = ref(false);
const editModal = ref(false);
const data = ref([]);

const columns = [
    {
        name: "No",
        real: "number"
    },
    {
        name: "Book Type",
        real: "book_type"
    },
    {
        name: "Name",
        real: "book_name"
    },
    {
        name: "Description",
        real: "book_description"
    },
    {
        name: "Publisher",
        real: "book_publisher"
    },
    {
        name: "Year",
        real: "book_year"
    },
    {
        name: "Stock",
        real: "book_stock"
    }
];

const menu = [
    {
        name: "Edit",
        emitName: "onEdit",
        classes: "text-sky-500 hover:text-sky-600 inline-block p-2 w-full hover:bg-gray-100 rounded",
        icon: "fas fa-edit mr-2"
    },
    {
        name: "Delete",
        emitName: "onDelete",
        classes: "text-red-500 hover:text-red-600 inline-block p-2 w-full hover:bg-gray-100 rounded",
        icon: "fas fa-trash mr-2"
    }
];

const onNewRecord = () =>{
    createModal.value = true;
};

const onDeleteData = (event) => {
    deleteModal.value = true;
    data.value = event;
}

const onEditData = (event) => {
    editModal.value = true;
    data.value = event;
}

const closeDeleteModal = () => {
    deleteModal.value = false;
}

const closeCreateModal = () =>{
    createModal.value = false;
}

const closeEditModal = () =>{
    editModal.value = false;
}
</script>
