<template>
    <the-head :title="$page.props.title" :description="$page.props.description" :url="$page.props.url"></the-head>

    <the-main id="main">
        <div class="container">
            <div class="row" v-for="(job, index) in jobs" :key="index">
                <div class="col-12">
                    <div class="job">
                        <div class="row">
                            <div class="col-2 col-xl-1 text-center">
                                <img :src="job.company_logo" class="img-fluid job__logo" />
                            </div>
                            <div class="col-10 col-xl-11">
                                <div class="row">
                                    <div class="col-12">
                                        <h3>{{ job.title }}</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 job__date">{{ job.formated_date }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-12 job__company">{{ job.company }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-12 job__source">{{ job.source }}</div>
                                </div>
                            </div>
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

export default {
    components: {
        AppLayout,
        TheHead,
        TheMain,
    },
    layout: AppLayout,
    computed: {
        jobs: function () {
            return this.$page.props.jobs;
        },
    },
};
</script>
<style lang="scss" scoped>
.job {
    border: solid 1px $appLightGrey;
    border-radius: 2px;
    padding: 20px;
    margin-bottom: 10px;

    h3 {
        font-size: 24px;
        font-weight: 700;
    }
}

.job__logo {
    margin: auto;
    border: solid 1px $appLightGrey;
    border-radius: 50%;
}

.job__date {
    font-size: 14px;
}
.job__company {
    color: $appRed;
}

.job__source {
    font-style: italic;
}
</style>
