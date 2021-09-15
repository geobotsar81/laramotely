<template>
    <img :src="this.$page.props.publicUrl + '/img/logoSmall.png'" :class="cls" />
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
