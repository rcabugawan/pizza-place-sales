<script setup lang="ts">
    import AppLayout from '@/layouts/AppLayout.vue';
    import { type BreadcrumbItem } from '@/types';
    import { Head, router } from '@inertiajs/vue3';
    import { onMounted, ref, type Ref, type ComputedRef, computed } from 'vue';
    import { PizzaTypeResource, PizzaResource, OrderResource } from '@/types/resources';
    import Vue3Datatable from '@bhplugin/vue3-datatable';

    const props = defineProps({
        id: String,
    })

    const loading: Ref<boolean> = ref(true);
    const pizzaType: Ref<PizzaTypeResource>= ref({})
    const pizzas: Ref<PizzaResource[]> = ref([])

    const breadcrumbs: ComputedRef<BreadcrumbItem[]> = computed(() => {
        return [
            {
                title: 'Pizza Types',
                href: '/pizza-types',
            },
            {
                title: `${pizzaType.value.name ?? props.id} Details`,
                href: '/orders',
            },
        ]
    })

    const headers = [
        { field: 'pizza_id', title: 'ID', type: 'string', isUnique: true },
        { field: 'size', title: 'Size',},
        { field: 'price', title: 'Price'},
    ]

    onMounted(() => {
        getOrder()
    })

    function getOrder(): void {
        loading.value = true;
        fetch(`/api/pizza_types/${props.id}`)
            .then((response) => {
                if (response.ok) {
                    return response.json();
                }
            })
            .then((response) => {
                pizzaType.value = response;
                pizzas.value = response.pizzas;

            }).finally(() => {
                loading.value = false;
            })
    }

    function viewIngredient(id: String) {
        router.visit(`/ingredient/${id}`);
    }

</script>

<template>
    <Head title="Orders" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-5">
            <div class="flex items-center">
                <h4 class="m-3"><span class="font-bold mr-2">Ingredients:</span>
                    <span
                        class="rounded-full bg-gray-100 px-2 py-1 cursor-pointer text-sm border mr-3 dark:bg-gray-800 dark:text-white"
                        v-for="ingredient in pizzaType?.ingredients"
                        @click="viewIngredient(ingredient.id)"
                        :key="ingredient.id">
                        {{ingredient.label}}
                    </span>
                </h4>
            </div>
            <div class="flex">
                <h4 class="m-3">{{ 'Sizes and Price:' }}</h4>
            </div>
            <Vue3Datatable
                v-if="pizzas.length > 0"
                class="border border-gray-100 p-5 rounded-md"
                rowClass="dark:text-white dark:bg-gray-900"
                skin="bh-table-bordered"
                :loading="loading"
                :columns="headers"
                :rows="pizzas"
                :pagination="false"
            ></Vue3Datatable>
        </div>
    </AppLayout>
</template>
