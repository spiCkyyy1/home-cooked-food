<template>

<!--    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">-->
<!--        <div v-for="menu in menus">-->
<!--            <div>-->
<!--                <img class="h-auto max-w-full rounded-lg" :src="getImage(menu.background_image)" alt="">-->
<!--            </div>-->
<!--            <div v-for="category in menu.categories">-->
<!--                <div v-if="category.products.length > 0">-->
<!--                    <span>Categories: </span>-->
<!--                    <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{category.name}}</span>-->
<!--                    <span>Products: </span>-->
<!--                    <span v-for="product in category.products">{{product.name}}</span>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Shop by Vendors</h2>

            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                <div class="group relative" v-for="menu in menus">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                        <img :src="getImage(menu.background_image)" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                    </div>
                    <div class="mt-4 flex justify-between">
                        <div>
                            <h3 class="text-sm text-gray-700">
                                <a :href="$route('show.menu', {id: menu.id})">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    {{ menu.name}}
                                </a>
                            </h3>
<!--                            <p class="mt-1 text-sm text-gray-500">Black</p>-->
                        </div>
                        <p class="text-sm font-medium text-gray-900" v-if="menu.description">{{menu.description}}</p>
<!--                         <p class="text-sm font-medium text-gray-900">{{getProductQuantity(menu.product_sizes)}} : {{getProductPrices(menu.product_prices)}}</p>-->
                    </div>
                    <div class="mt-4 justify-between">
                        <p class="text-sm font-medium text-gray-900" v-if="menu.vendor.name">Store By: {{menu.vendor.name}}</p>
                    </div>
                    <div class="mt-4 justify-between">
                          <p class="text-sm font-medium text-gray-900" v-if="menu.vendor.store">Store Address: {{menu.vendor.store.address}}</p>
                    </div>
                </div>

                <!-- More products... -->
            </div>
        </div>
    </div>

</template>
<script>
export default {
    props: {menus: Object},
    mounted() {
        console.log(this.menus);
    },
    methods: {
        getImage(imagePath){
            return this.$page.props.storageLink+'/'+imagePath.replace("public", "");
        },
        getProductNames(names){
            return names.split(",");
        },
        getProductPrices(prices){
            return prices.split(",");
        },
        getProductQuantity(quantities){
            return quantities.split(",");
        }
    }
};
</script>
