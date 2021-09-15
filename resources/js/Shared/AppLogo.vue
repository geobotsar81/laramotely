<template>
    <img :src="this.$page.props.publicUrl + '/img/aml_logo.png'" :class="cls" />
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
