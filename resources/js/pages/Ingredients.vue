<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { onMounted, ref, reactive, type Ref } from 'vue';
import { objectToUrl } from '@/lib/utils';
import { IngredientResource } from '@/types/resources';
import Vue3Datatable from '@bhplugin/vue3-datatable';
import debounce from 'lodash/debounce';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ingredient',
        href: '/ingredients',
    },
];

const loading: Ref<boolean> = ref(true);
const ingredients: Ref<IngredientResource[]>= ref([])
const params = reactive({
    page: 1,
    perPage: 10,
    search: null,
    sortBy: 'id',
    sortOrder: 'asc',
})

const total = ref(null);

const headers = [
    { field: 'id', title: 'ID', type: 'number', isUnique: true },
    { field: 'label', title: 'Label', type: 'string' },
    { field: 'actions', title: 'Actions', sort: false },
]

const handleSearch = debounce(() => {
    getIngredients()
}, 500)

onMounted(() => {
    getIngredients()
})

function getIngredients(): void {
    loading.value = true;
    const url = objectToUrl('api/ingredients', params)

    fetch(url)
        .then((response) => {
            if (response.ok) {
                return response.json();
            }
        })
        .then((response) => {
            ingredients.value = response.data;
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

    getIngredients();
}

function viewIngredients(ingredient: IngredientResource) {
    router.visit(`/ingredients/${ingredient.id}`);
}

</script>

<template>
    <Head title="Ingredients" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-5">
            <div class="mb-5">
                <input v-model="params.search" @input="handleSearch" type="text" class="max-w-xs rounded-md bg-white dark:bg-gray-900 dark:text-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 sm:text-sm/6" placeholder="Search Label..." />
            </div>

            <Vue3Datatable
                class="border border-gray-100 p-5 rounded-md"
                rowClass="dark:text-white dark:bg-gray-800"
                skin="bh-table-bordered"
                :loading="loading"
                :columns="headers"
                :rows="ingredients"
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
                        <button type="button" class="cursor-pointer py-1 px-2 bg-gray-100 dark:bg-gray-900 dark:text-white rounded-md hover:bg-gray-200 transition-colors" @click="viewIngredients(data.value)">View</button>
                    </div>
                </template>
            </Vue3Datatable>
        </div>
    </AppLayout>
</template>
