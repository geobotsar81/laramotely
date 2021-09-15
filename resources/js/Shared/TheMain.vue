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
    padding: 60px 45px;
    color: $projectBlack;
    min-height: 100vh;
    background-color: $projectGrey14;
    position: relative;

    :deep(hr) {
        border-top: solid 1px $projectGrey7;
    }

    img.aligncenter {
        display: block;
        margin: auto;
    }

    p {
        font-size: 16px;
        line-height: 24px;
        font-weight: 400;
        color: $projectDarkGrey1;
    }

    :deep(a:not(.buttonBlue):not(.buttonWhite):not(.buttonGold):not(.buttonArrow):not(.nav-link):not(.dropdown-item)) {
        color: $projectBlue;
        font-weight: 600;
        transition: color 0.4s;
        text-decoration: none;

        &:hover,
        &:focus {
            text-decoration: none;
            color: $projectBlue2;
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
            color: $projectRed;
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
            color: $projectRed;
            display: inline-block;
            font-weight: 500;
            padding-right: 5px;
        }
    }
}
</style>
