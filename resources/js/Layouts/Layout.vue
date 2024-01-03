<template>

    <section class="bg-gray-200">
        <Nav />
    </section>
    <section>
        <div class="max-u-3xl mx-auto">
            <slot />
        </div>
    </section>
    <section>
        <Footer />
    </section>
</template>
<script>
import Nav from "@/Layouts/Nav.vue";
import Footer from "@/Layouts/Footer.vue";

export default {
    components: { Nav, Footer },
};
</script>
