<template>
    <a v-if="type === 'external'" :href="link" :class="cls" class="button"><slot /></a>

    <button v-else-if="type === 'submit'" :class="cls" class="button">
        <slot />
    </button>

    <inertia-link v-else :href="link" :class="cls" class="button">
        <slot />
    </inertia-link>
</template>
<script>
export default {
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
.acurisCheck {
    display: block;
    padding: 15px;
    width: 100%;
    text-align: center;
    border: solid 1px $appBlue;
    border-radius: 3px;
    transition: $appTransition;
    background-color: #ffffff;

    &:hover,
    &:focus {
        background-color: #d0ddec;
    }

    &.disabled {
        pointer-events: none;
        background-color: #ccc;
    }
}

.buttonBlue,
.upload {
    display: inline-block;
    background-color: $appBlue;
    font-weight: 700;
    font-style: normal;
    font-size: 14px;
    color: #fff;
    border-radius: 3px;
    padding: 15px 40px;
    transition: all 0.4s ease-out;
    text-decoration: none;
    border: none;
    border: 0px solid $appBlue;

    &:hover,
    &:focus {
        color: #fff;
        border: 0px solid $appBlue;
        background-color: $appLightBlue;
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

.um input[type="submit"].um-button {
    display: inline-block !important;
    background-color: $appBlue !important;
    font-weight: 700 !important;
    font-style: normal !important;
    font-size: 15px !important;
    color: #fff !important;
    border-radius: 3px !important;
    padding: 15px 30px !important;
    transition: all 0.4s ease-out !important;
    text-decoration: none !important;
    border: none !important;

    &:hover,
    &:focus {
        color: #fff !important;
        border: 0px solid $appBlue !important;
        background-color: $appLightBlue !important;
        text-decoration: none !important;
        outline: none !important;
        box-shadow: none !important;
    }
}

// Button Arrow
$text-arrow-space: 12px;
$shaft-width: 1px;
$newshaft-width: 64px;
$shaft-thickness: 1px;
$arrow-head-width: 6px;
$arrow-head-thickness: $shaft-thickness;
</style>
