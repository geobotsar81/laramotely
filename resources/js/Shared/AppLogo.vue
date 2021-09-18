<template>
    <!--<img :src="this.$page.props.publicUrl + '/img/logo.png'" :class="cls" />-->
    <div class="logo">
        lara<span>m<i class="far fa-globe-americas"></i>tely</span>
    </div>
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
<style lang="scss" scoped>
.logo {
    font-size: 40px;
    font-weight: 700;
    color: $appBlack;
    span {
        color: $appRed;
    }

    i {
        font-size: 26px;
    }
}
</style>
