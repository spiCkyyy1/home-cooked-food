<template>
    <header class="flex justify-between">
        <div class="flex items-center">
            <h1 class="font-bold text-lg">Home Cooked Foods</h1>

            <p class="text-sm ml-4">
                Welcome Back, {{username}}
                <!--                        $page.props.auth.user.-->
            </p>
        </div>
    </header>
    <h1 class="text-3xl">Hello {{ name }}</h1>
</template>
<script>

export default {
    props: {name: String},
    computed: {
        username() {
            return this.$page.props.auth.user.username;
        }
    }

};
</script>
<style lang="scss" scoped>

</style>
