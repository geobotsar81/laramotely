<template>
    <div v-if="links.length > 3">
        <div class="row mt-4">
            <div class="col-12">
                <nav aria-label="navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item" :class="link.label == pageNumber ? 'active' : ''" v-for="(link, key) in links" :key="key">
                            <div v-if="link.url === null" class="page-link" v-html="printLabel(link.label)" />
                            <a href="#" v-else class="page-link" @click.prevent="selectPage(link.label)" v-html="printLabel(link.label)" preserve-scroll />
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
import { InertiaLink } from "@inertiajs/inertia-vue3";
export default {
    components: {
        InertiaLink,
    },
    props: {
        links: Array,
        currentPage: Number,
    },
    data() {
        return {
            pageNumber: this.currentPage,
        };
    },
    methods: {
        printLabel(label) {
            label = label.replace("Next", "");
            label = label.replace("Previous", "");
            return label;
        },
        selectPage(key) {
            //alert(key);
            if (key == "Next &raquo;") {
                key = this.pageNumber + 1;
            }
            if (key == "&laquo; Previous") {
                key = this.pageNumber - 1;
            }
            let currentPageNumber = parseInt(key);
            this.$emit("update:modelValue", currentPageNumber);
            this.pageNumber = currentPageNumber;
            //alert("Emiting Page:" + currentPageNumber);
        },
    },
};
</script>
<style lang="scss" scoped>
.pagination {
    display: block;
    text-align: center;

    .page-item {
        margin: 0px 2px;
        display: inline-block;

        &.active {
            .page-link {
                background-color: $appRed;
                border-color: $appRed;
                color: #fff !important;
            }
        }

        &:first-child,
        &:last-child {
            .page-link {
                color: $appRed;
                font-size: 12px;
                line-height: 14px;
                font-weight: 700;
            }
        }
    }
    .page-link {
        border-radius: 3px;
        font-size: 12px;
        line-height: 14px;
        font-weight: 700;
        width: 32px;
        height: 32px;
        text-align: center;
        padding-top: 8px;
        color: $appGrey2;
        border-color: #dfe3e8;

        &:hover,
        &:focus {
            box-shadow: none;
            outline: none;
        }
    }
}
</style>
