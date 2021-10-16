<template>
    <the-head :title="$page.props.title" :description="$page.props.description" :url="$page.props.url"></the-head>

    <the-main id="main">
        <div class="container">
            <div class="row text-center">
                <div class="col-12"><h1>Unsubscribe from Newsletter</h1></div>
            </div>
            <div class="row text-center mb-sm-2">
                <div class="col-12">{{ $page.props.message }}</div>
            </div>
        </div>
    </the-main>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import TheHead from "@/Shared/TheHead";
import TheMain from "@/Shared/TheMain";
import AppButton from "@/Shared/AppButton";
import AppJob from "@/Shared/AppJob";
import Pagination from "@/Shared/AppPagination";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    components: {
        AppLayout,
        TheHead,
        TheMain,
        AppButton,
        AppJob,
        Pagination,
    },
    mounted() {},
    data() {
        return {};
    },
    layout: AppLayout,
    methods: {},
    watch: {},
};
</script>
<style lang="scss" scoped>
h2 {
    color: $appRed;
}

.formError {
    color: $appRed;
    padding-top: 5px;
}

.formSuccess {
    color: $appGreen;
    padding-top: 5px;
}
</style>
