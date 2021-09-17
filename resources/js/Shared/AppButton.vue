<template>
    <a v-if="type === 'external'" :href="link" :class="cls" target="blank"><slot /></a>

    <button v-else-if="type === 'submit'" :class="cls">
        <slot />
    </button>

    <inertia-link v-else :href="link" :class="cls">
        <slot />
    </inertia-link>
</template>
<script>
import { InertiaLink } from "@inertiajs/inertia-vue3";

export default {
    components: {
        InertiaLink,
    },
    props: {
        cls: {
            type: String,
            required: false,
        },
        link: {
            type: String,
            required: false,
        },
        type: {
            type: String,
            required: false,
        },
    },
};
</script>
<style lang="scss" scoped>
.buttonRed {
    display: inline-block;
    background-color: $appRed;
    font-weight: 700;
    font-style: normal;
    font-size: 14px;
    color: #fff;
    border-radius: 4px;
    padding: 12px 40px;
    transition: all 0.4s ease-out;
    text-decoration: none;
    border: none;
    border: 0px solid $appRed;

    &:hover,
    &:focus {
        color: #fff;
        border: 0px solid $appBlack;
        background-color: $appBlack;
        text-decoration: none;
        outline: none;
        box-shadow: none;
    }

    :deep(i) {
        font-size: 12px;
        padding: 0px 5px;
    }

    &.disabled {
        background-color: $appGrey;
        cursor: not-allowed;
        pointer-events: none;
    }
}

.buttonWhite {
    display: inline-block;
    font-weight: 700;
    font-style: normal;
    font-size: 14px;
    color: $appBlue;
    border-radius: 3px;
    padding: 15px 40px;
    transition: all 0.4s ease-out;
    background-color: #fff;
    text-decoration: none;
    border: none;
    border: 1px solid $appBlue;

    &:hover,
    &:focus {
        color: $appBlue;
        background-color: #d0ddec;
        text-decoration: none;
        outline: none;
        box-shadow: none;
    }

    i {
        font-size: 12px;
        padding: 0px 5px;
    }
}

.buttonTransparent {
    display: inline-block;
    font-weight: 700;
    font-style: normal;
    font-size: 14px;
    color: $appBlue;
    border-radius: 3px;
    padding: 15px 40px;
    transition: all 0.4s ease-out;
    background-color: transparent;
    text-decoration: none;
    border: none;
    border: 1px solid $appGrey;

    &:hover,
    &:focus {
        color: $appBlue;
        border: 1px solid $appBlue;
        background-color: transparent;
        text-decoration: none;
        outline: none;
        box-shadow: none;
    }

    i {
        font-size: 12px;
        padding: 0px 5px;
    }
}
</style>
