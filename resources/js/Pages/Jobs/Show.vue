<template>
    <the-head :title="job.title" :description="job.description" :url="route('job.show', job.url)"></the-head>
    <header></header>
    <the-main id="main">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <inertia-link :href="route('home.show')"><i class="far fa-chevron-square-left"></i> Back to jobs</inertia-link>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-12 col-lg-9">
                    <div class="row mb-4">
                        <div class="col-8 col-sm-3 col-md-3 col-lg-3 col-xl-2">
                            <div class="">
                                <div class="row">
                                    <div class="col-6 col-sm-12">
                                        <img
                                            v-if="job.company_logo && job.company_logo != 'nologo.svg' && job.source != 'linkedin.com'"
                                            :src="storageUrl + 'companies/' + job.company_logo"
                                            class="img-fluid job__logo"
                                        />
                                        <div v-else class="job__logoAlternative">{{ job.company }}</div>
                                    </div>
                                </div>
                                <div class="row mt-2 text-start text-sm-center">
                                    <div class="col-12 job__companyDetail">{{ job.company }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 job__date">{{ job.formated_date }}</div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h1>{{ job.title }}</h1>
                        </div>
                    </div>
                    <div class="row mb-2" v-if="job.location">
                        <div class="col-12 job__source"><i class="far fa-globe-americas"></i> {{ job.formated_location }}</div>
                    </div>

                    <div class="row mb-4" v-if="job.formated_tags && job.source != 'remotive.io'">
                        <div class="col-12">
                            <span class="job__tag" v-for="(tag, index) in job.formated_tags" :key="index">{{ tag }}</span>
                        </div>
                    </div>

                    <div class="row mb-5" v-if="job.description">
                        <div class="col-12 job__description">
                            <span v-html="job.description"></span>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <app-button type="external" class="buttonRed" :link="job.url">LEARN MORE & APPLY</app-button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 d-none d-lg-block" v-if="false">
                    <div class="job__companyCell">
                        <div class="row">
                            <div class="col-12">
                                <img
                                    v-if="job.company_logo && job.company_logo != 'nologo.svg' && job.source != 'linkedin.com'"
                                    :src="storageUrl + 'companies/' + job.company_logo"
                                    class="img-fluid job__logo"
                                />
                                <div v-else class="job__logoAlternative">{{ job.company }}</div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12 job__company">{{ job.company }}</div>
                        </div>
                    </div>
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
import { InertiaLink } from "@inertiajs/inertia-vue3";

export default {
    components: {
        AppLayout,
        TheHead,
        TheMain,
        AppButton,
        AppJob,
        InertiaLink,
    },
    layout: AppLayout,
    data() {
        return {
            storageUrl: this.$page.props.storageUrl + "/",
        };
    },
    computed: {
        job: function () {
            return this.$page.props.job;
        },
    },
};
</script>
<style lang="scss" scoped>
main {
    padding-top: 40px;
}
h1 {
    font-weight: 700;
}

header {
    background-image: url("/img/headerImage.jpg");
    background-size: cover;
    background-position: center;
    height: 450px;
    margin-top: 70px;
}
.job__description {
    :deep(h2) {
        padding-top: 10px;
        font-size: 26px;
    }
    :deep(.ai-baseline) {
        display: none;
    }
    :deep(.js-apply-container) {
        display: none;
    }
    :deep(.s-tag) {
        pointer-events: none;
        padding: 5px 10px;
        color: $appBlack !important;
        background-color: $appLightGrey;
        margin: 0px 5px;
    }

    :deep(p) {
        margin-bottom: 5px;
    }
    :deep(img) {
        display: none;
    }
    :deep(.title) {
        display: none;
    }
    :deep(.timestamp-wrapper) {
        display: none;
    }
}

@media (max-width: 1199.98px) {
    header {
        height: 400px;
    }
}

@media (max-width: 991.98px) {
    header {
        height: 300px;
    }
}
@media (max-width: 767.98px) {
    header {
        height: 200px;
    }
}
</style>
