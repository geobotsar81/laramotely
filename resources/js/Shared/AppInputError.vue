<template>
    <div class="formError"><slot></slot></div>
</template>

<script>
export default {
    props: {
        class: String,
    },
};
</script>
<style lang="scss" scoped>
.formError {
    color: red;
    font-size: 12px;
}
</style>
