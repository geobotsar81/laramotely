<template>
    <button
        v-if="text"
        type="button"
        class="pageTool__question__popover"
        data-bs-container="body"
        data-bs-toggle="popover"
        data-bs-placement="top"
        data-bs-trigger="focus"
        data-bs-html="true"
        :data-bs-content="text"
    >
        <i class="fas fa-question-circle"></i>
    </button>
</template>
<script>
import { Popover } from "bootstrap/dist/js/bootstrap.esm.min.js";
export default {
    mounted() {
        //inti Popover
        Array.from(document.querySelectorAll('button[data-bs-toggle="popover"]')).forEach((popoverNode) => new Popover(popoverNode));
    },
    props: {
        text: {
            type: String,
            required: false,
        },
    },
};
</script>
<style lang="scss" scoped></style>
