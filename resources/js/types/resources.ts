export interface OrderResource {
    id?: number
    date?: string
    time?: string
    item_count?: number
}

export interface OrderDetailResource {
    id?: number
    pizza?: PizzaResource
    quantity?: number
}

export interface PizzaResource {
    pizza_id?: string
    pizza_type?: object
    size?: string
    price?: string
}

export interface PizzaTypeResource {
    pizza_type_id?: string
    name?: string
    category?: string
}

export interface IngredientResource {
    id?: number
    label?: string
}