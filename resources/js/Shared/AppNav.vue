<template>
    <nav class="nav">
        <div v-for="(menuItem, index) in menu" :key="index">
            <app-dropdown v-if="menuItem.children" :item="menuItem"></app-dropdown>

            <inertia-link v-else class="nav-link" :class="isUrl(menuItem.url) ? 'active' : ''" :href="menuItem.url">
                <i v-if="menuItem.icon_class" :class="menuItem.icon_class"></i>{{ menuItem.title }}
            </inertia-link>
        </div>
    </nav>
</template>

<script>
import AppDropdown from "@/Shared/AppDropdown";
import { InertiaLink } from "@inertiajs/inertia-vue3";

export default {
    components: {
        AppDropdown,
        InertiaLink,
    },
    props: {
        menu: Object,
    },
    methods: {
        isUrl(...urls) {
            let currentUrl = this.$page.url.substr(1);
            if (urls[0] === "") {
                return currentUrl === "";
            }
            return urls.filter((url) => currentUrl.startsWith(url)).length;
        },
    },
};
</script>
<style lang="scss" scoped>
.nav {
    display: inline-block;
    padding-top: 15px;

    > div {
        display: inline-block;
    }

    :deep(.nav-link) {
        font-size: 14px;
        line-height: 22px;
        padding: 0px;
        margin: 0px 20px;
        color: $appBlack;
        font-weight: 600;
        transition: $appTransition;
        display: inline-block;

        i {
            padding-right: 5px;
            font-size: 12px;
        }

        &:hover,
        &:focus,
        &.active {
            color: $appBlue !important;
        }

        &.dropdown-toggle {
            padding-right: 15px;
        }
    }
}

.sticky {
    .nav-link {
        color: $appBlack;
    }
}

@media (max-width: 1199.98px) {
    .nav {
        :deep(.nav-link) {
            margin: 0px 15px;
        }
    }
}
</style>
