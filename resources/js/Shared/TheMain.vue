<template>
    <main id="main" :class="cls">
        <slot></slot>
    </main>
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
main {
    font-size: 16px;
    line-height: 24px;
    font-weight: 400;
    padding: 120px 0px;
    color: $appBlack;
    min-height: 100vh;
    position: relative;

    :deep(hr) {
        border-top: solid 1px $appGrey2;
    }

    img.aligncenter {
        display: block;
        margin: auto;
    }

    p {
        font-size: 16px;
        line-height: 24px;
        font-weight: 400;
        color: $appGrey2;
    }

    :deep(a:not(.buttonRed):not(.buttonWhite):not(.buttonGold):not(.buttonArrow):not(.nav-link):not(.dropdown-item)) {
        color: $appRed;
        font-weight: 600;
        transition: color 0.4s;
        text-decoration: none;

        &:hover,
        &:focus {
            text-decoration: none;
            color: $appBlack;
            box-shadow: none;
            outline: none;
        }
    }

    ul:not(.nav-tabs):not(.dropdown-menu) {
        padding-left: 30px;
        li {
            display: block;
            text-indent: -30px;
            padding-bottom: 10px;
            font-size: 14px;
            line-height: 16px;
        }
        li:before {
            content: "\f0da";
            font-family: "Font Awesome 5 Pro";
            padding-right: 15px;
            font-weight: 700;
            font-size: 15px;
            color: $appLightBlue;
        }
    }

    ol:not(.nav-tabs):not(.dropdown-menu) {
        list-style: none;
        counter-reset: li;
        padding-left: 30px;

        li {
            counter-increment: li;
            font-size: 14px;
            line-height: 16px;
            padding-bottom: 10px;
            text-indent: -15px;
        }
        li::before {
            content: counter(li) ".";
            color: $appLightBlue;
            display: inline-block;
            font-weight: 500;
            padding-right: 5px;
        }
    }
}
</style>
