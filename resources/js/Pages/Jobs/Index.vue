<template>
    <the-head :title="$page.props.title" :description="$page.props.description" :url="$page.props.url"></the-head>

    <the-main id="main">
        <div class="container">
            <div class="row text-start">
                <div class="col-12"><h1>All Laravel Jobs</h1></div>
            </div>

            <div class="mt-4" v-if="jobs && !searching">
                <div v-for="(job, index) in jobs" :key="index">
                    <app-job :job="job"></app-job>
                </div>
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
    setup() {
        const form = useForm({
            email: null,
            honeypot: null,
        });

        return { form };
    },

    data() {
        return {
            jobs: this.$page.props.jobs,
        };
    },
    layout: AppLayout,
    methods: {},
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

.form-check-input {
    &:hover,
    &:focus {
        box-shadow: none;
    }
}
.form-check-input:checked {
    background-color: $appRed;
    border-color: $appRed;
}

.newsletter {
    border-radius: 4px;
    background-color: $appBlack;
    padding: 15px 20px;
    color: #ffffff;

    :deep(.buttonRed) {
        width: 100%;
    }
}

.newsletter__social {
    text-align: right;
    a {
        display: inline-block;
        margin: 0px 10px;
        border-radius: 50%;
        width: 34px;
        height: 34px;
        background-color: $appRed;
        text-align: center;
        padding-top: 6px;
        transition: $appTransition;

        &:hover,
        &:focus {
            background-color: #fff;
            i {
                color: $appRed;
            }
        }

        i {
            font-size: 22px;
            color: #fff;
        }
    }
}
</style>
