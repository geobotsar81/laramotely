<template>
    <nav class="nav">
        <inertia-link class="nav-link" :class="isUrl('contact') ? 'active' : ''" :href="route('contact.show')"> Contact </inertia-link>
        <app-button :href="route('job.post')" type="link" class="buttonPostAJob">POST A FREE JOB</app-button>
    </nav>
</template>

<script>
import AppDropdown from "@/Shared/AppDropdown";
import AppButton from "@/Shared/AppButton";
import { InertiaLink } from "@inertiajs/inertia-vue3";

export default {
    components: {
        AppDropdown,
        InertiaLink,
        AppButton,
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
    padding-top: 5px;

    > div {
        display: inline-block;
    }

    :deep(.nav-link) {
        font-size: 16px;
        line-height: 22px;
        padding: 0px;
        margin: 0px 20px;
        color: $appBlack;
        font-weight: 700;
        transition: $appTransition;
        display: inline-block;

        i {
            padding-right: 5px;
            font-size: 12px;
        }

        &:hover,
        &:focus,
        &.active {
            color: $appRed !important;
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
