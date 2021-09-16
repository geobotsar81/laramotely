<template>
    <img :src="this.$page.props.publicUrl + '/img/logo.svg'" :class="cls" />
</template>
<script>
export default {
    props: {
        cls: {
            type: String,
            required: false,
        },
    },
};
</script>
<style lang="scss" scoped></style>
