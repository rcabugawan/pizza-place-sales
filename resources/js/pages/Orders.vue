<script setup lang="ts">
    import AppLayout from '@/layouts/AppLayout.vue';
    import { type BreadcrumbItem } from '@/types';
    import { Head, router } from '@inertiajs/vue3';
    import { onMounted, ref, reactive, type Ref } from 'vue';
    import { objectToUrl } from '@/lib/utils';
    import { OrderResource } from '@/types/resources';
    import Vue3Datatable from '@bhplugin/vue3-datatable';
    import debounce from 'lodash/debounce';

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Orders',
            href: '/orders',
        },
    ];

    const loading: Ref<boolean> = ref(true);
    const orders: Ref<OrderResource[]>= ref([])
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
        { field: 'date', title: 'Date', type: 'date' },
        { field: 'time', title: 'Time', sortable: true },
        { field: 'item_count', title: 'Item Count', type: 'number' },
        { field: 'actions', title: 'Actions', sort: false },
    ]

    const handleSearch = debounce(() => {
        getOrders()
    }, 500)

    onMounted(() => {
        getOrders()
    })

    function getOrders(): void {
        loading.value = true;
        const url = objectToUrl('api/orders', params)

        fetch(url)
            .then((response) => {
                if (response.ok) {
                    return response.json();
                }
            })
            .then((response) => {
                orders.value = response.data;
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

        getOrders();
    }

    function viewOrder(order: OrderResource) {
        router.visit(`/orders/${order.id}`);
    }

</script>

<template>
    <Head title="Orders" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-5">
            <div class="mb-5">
                <input v-model="params.search" @input="handleSearch" type="text" class="max-w-xs rounded-md bg-white dark:bg-gray-900 dark:text-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 sm:text-sm/6" placeholder="Search ID..." />
            </div>

            <Vue3Datatable
                class="border border-gray-100 p-5 rounded-md"
                rowClass="dark:text-white dark:bg-gray-800"
                skin="bh-table-bordered"
                :loading="loading"
                :columns="headers"
                :rows="orders"
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
                        <button type="button" class="cursor-pointer py-1 px-2 bg-gray-100 dark:bg-gray-900 dark:text-white rounded-md hover:bg-gray-200 transition-colors" @click="viewOrder(data.value)">View</button>
                    </div>
                </template>
            </Vue3Datatable>
        </div>
    </AppLayout>
</template>
