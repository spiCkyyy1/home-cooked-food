<template>
    <Link
    :class="{'bg-gray-900 text-white': active}">
        <slot>

        </slot>
    </Link>
</template>
<script>
export default {
    props: { active: Boolean }
}
</script>
