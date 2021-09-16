<template>
    <div class="preloader" :class="preloaderClass">
        <lottie-player
            src="https://assets4.lottiefiles.com/packages/lf20_mcoa7bt7.json"
            background="transparent"
            speed="1"
            style="width: 200px; height: 200px"
            loop
            autoplay
        ></lottie-player>
    </div>
</template>
<script>
export default {
    props: {
        preloaderClass: String,
    },
};
</script>
<style lang="scss" scoped>
.preloader {
    position: fixed;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    z-index: 100000;
    background-color: #ffffff;

    &.hidden {
        display: none;
    }

    lottie-player {
        position: absolute;
        top: calc(50% - 100px);
        left: calc(50% - 100px);
    }
}
</style>
