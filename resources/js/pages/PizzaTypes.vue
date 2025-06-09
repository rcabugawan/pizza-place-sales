<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { onMounted, ref, reactive, type Ref } from 'vue';
import { objectToUrl } from '@/lib/utils';
import { PizzaTypeResource } from '@/types/resources';
import Vue3Datatable from '@bhplugin/vue3-datatable';
import debounce from 'lodash/debounce';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Pizza Types',
        href: '/pizza-types',
    },
];

const loading: Ref<boolean> = ref(true);
const pizzaTypes: Ref<PizzaTypeResource[]>= ref([])
const params = reactive({
    page: 1,
    perPage: 10,
    search: null,
    sortBy: 'id',
    sortOrder: 'asc',
})

const total = ref(null);

const headers = [
    { field: 'pizza_type_id', title: 'ID', type: 'number', isUnique: true },
    { field: 'name', title: 'Name', type: 'date' },
    { field: 'category', title: 'Category' },
    { field: 'actions', title: 'Actions', sort: false },
]

const handleSearch = debounce(() => {
    getPizzaTypes()
}, 500)

onMounted(() => {
    getPizzaTypes()
})

function getPizzaTypes(): void {
    loading.value = true;
    const url = objectToUrl('api/pizza_types', params)

    fetch(url)
        .then((response) => {
            if (response.ok) {
                return response.json();
            }
        })
        .then((response) => {
            pizzaTypes.value = response.data;
            total.value = response.meta.total;

        }).finally(() => {
        loading.value = false;
    })
}

function handleChange(data: any) {
    params.page = data.current_page;
    params.perPage = data.pagesize;
    params.sortBy = data.sort_column;
    params.sortOrder = data.sort_direction;

    getPizzaTypes();
}

function viewPizzaType(pizzaType: PizzaTypeResource) {
    router.visit(`/pizza-types/${pizzaType.pizza_type_id}`);
}

</script>

<template>
    <Head title="Pizza type" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-5">
            <div class="mb-5">
                <input v-model="params.search" @input="handleSearch" type="text" class="max-w-xs rounded-md bg-white dark:bg-gray-900 dark:text-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 sm:text-sm/6" placeholder="Search ID or Name..." />
            </div>

            <Vue3Datatable
                class="border border-gray-100 p-5 rounded-md"
                rowClass="dark:text-white dark:bg-gray-800"
                skin="bh-table-bordered"
                :loading="loading"
                :columns="headers"
                :rows="pizzaTypes"
                :totalRows="total"
                isServerMode
                pagination
                :pageSize="params.perPage"
                :pageSizeOptions="[10, 20, 30, 40]"
                sortable
                cloneHeaderInFooter
                @change="handleChange"
            >
                <template #actions="data">
                    <div class="flex gap-4">
                        <button type="button" class="cursor-pointer py-1 px-2 bg-gray-100 dark:bg-gray-900 dark:text-white rounded-md hover:bg-gray-200 transition-colors" @click="viewPizzaType(data.value)">View</button>
                    </div>
                </template>
            </Vue3Datatable>
        </div>
    </AppLayout>
</template>
