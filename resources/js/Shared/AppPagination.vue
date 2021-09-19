<template>
    <div v-if="links.length > 3">
        <div class="row mt-4">
            <div class="col-12">
                <nav aria-label="navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item" :class="{ active: link.active }" v-for="(link, key) in links" :key="key">
                            <div v-if="link.url === null" class="page-link" v-html="printLabel(link.label)" />
                            <inertia-link v-else class="page-link" :href="link.url" v-html="printLabel(link.label)" preserve-scroll />
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
    },
    methods: {
        printLabel(label) {
            label = label.replace("Next", "");
            label = label.replace("Previous", "");
            return label;
        },
    },
};
</script>
<style lang="scss" scoped>
.pagination {
    .page-item {
        margin: 0px 2px;

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
