<script setup lang="ts">
    import AppLayout from '@/layouts/AppLayout.vue';
    import { type BreadcrumbItem } from '@/types';
    import { Head, router } from '@inertiajs/vue3';
    import { computed, type ComputedRef, onMounted, ref, type Ref } from 'vue';
    import { IngredientResource, PizzaTypeResource } from '@/types/resources';
    import Vue3Datatable from '@bhplugin/vue3-datatable';

    const props = defineProps({
        id: [Number, String],
    })

    const loading: Ref<boolean> = ref(true);
    const ingredients: Ref<IngredientResource>= ref({})
    const pizzaTypes: Ref<PizzaTypeResource[]> = ref([])

    const breadcrumbs: ComputedRef<BreadcrumbItem[]> = computed(() => {
        return [
            {
                title: 'Ingredients',
                href: '/ingredients',
            },
            {
                title: `${ingredients.value.label ?? props.id} Details`,
                href: ''
            },
        ]
    })

    const headers = [
        { field: 'pizza_type_id', title: 'ID', type: 'number', isUnique: true },
        { field: 'name', title: 'Name', type: 'date' },
        { field: 'category', title: 'Category' },
        { field: 'actions', title: 'Actions', sort: false },
    ]

    onMounted(() => {
        getIngredient()
    })

    function getIngredient(): void {
        loading.value = true;
        fetch(`/api/ingredients/${props.id}`)
            .then((response) => {
                if (response.ok) {
                    return response.json();
                }
            })
            .then((response) => {
                ingredients.value = response;
                pizzaTypes.value = response.pizza_types;

            }).finally(() => {
                loading.value = false;
            })
    }

    function viewPizzaType(pizzaType: PizzaTypeResource) {
        router.visit(`/pizza-types/${pizzaType.pizza_type_id}`);
    }

</script>

<template>
    <Head title="Orders" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-5">
            <div class="flex">
                <h4 class="m-3">{{ 'Pizza Types that contain this ingredient:' }}</h4>
            </div>
            <Vue3Datatable
                v-if="pizzaTypes.length > 0"
                class="border border-gray-100 p-5 rounded-md"
                rowClass="dark:text-white dark:bg-gray-900"
                skin="bh-table-bordered"
                :loading="loading"
                :columns="headers"
                :rows="pizzaTypes"
                :pagination="false"
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
