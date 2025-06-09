<script setup lang="ts">
    import AppLayout from '@/layouts/AppLayout.vue';
    import { type BreadcrumbItem } from '@/types';
    import { Head } from '@inertiajs/vue3';
    import { onMounted, ref, reactive, type Ref } from 'vue';
    import { OrderResource, OrderDetailResource } from '@/types/resources';
    import Vue3Datatable from '@bhplugin/vue3-datatable';

    const props = defineProps({
        id: [Number, String],
    })

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Orders',
            href: '/orders',
        },
        {
            title: `Order #${props.id} Details`,
            href: '/orders',
        },
    ];

    const loading: Ref<boolean> = ref(true);
    const order: Ref<OrderResource>= ref({})
    const orderDetails: Ref<OrderDetailResource[]> = ref([])

    const headers = [
        { field: 'id', title: 'ID', type: 'number', isUnique: true },
        { field: 'name', title: 'Name', type: 'date' },
        { field: 'size', title: 'Size',},
        { field: 'category', title: 'Category', type: 'number' },
        { field: 'price', title: 'Price'},
    ]

    onMounted(() => {
        getOrder()
    })

    function getOrder(): void {
        loading.value = true;
        fetch(`/api/orders/${props.id}`)
            .then((response) => {
                if (response.ok) {
                    return response.json();
                }
            })
            .then((response) => {
                order.value = response;
                orderDetails.value = response.order_details;

            }).finally(() => {
                loading.value = false;
            })
    }

</script>

<template>
    <Head title="Orders" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-5">
            <Vue3Datatable
                v-if="orderDetails.length > 0"
                class="border border-gray-100 p-5 rounded-md"
                rowClass="dark:text-white dark:bg-gray-900"
                skin="bh-table-bordered"
                :loading="loading"
                :columns="headers"
                :rows="orderDetails"
                :pagination="false"
            >
                <template #name="data">
                    <span>{{ data.value.pizza.pizza_type.name }}</span>
                </template>

                <template #size="data">
                    <span>{{ data.value.pizza.size }}</span>
                </template>

                <template #category="data">
                    <span>{{ data.value.pizza.pizza_type.category }}</span>
                </template>

                <template #price="data">
                    <span>{{ data.value.pizza.price }}</span>
                </template>
            </Vue3Datatable>
        </div>
    </AppLayout>
</template>
