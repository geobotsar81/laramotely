<template>
    <the-head :title="$page.props.title" :description="$page.props.description" :url="$page.props.url"></the-head>

    <the-main id="main">
        <div class="container">
            <div class="row text-center">
                <div class="col-12"><h1>Remote Laravel Jobs</h1></div>
            </div>
            <div class="row text-center mb-5">
                <div class="col-12"><h2>sourced from all over the web</h2></div>
            </div>
            <div class="row" v-for="(job, index) in jobs" :key="index">
                <div class="col-12">
                    <div class="job">
                        <div class="row align-items-center">
                            <div class="col-2 col-xl-1 text-center">
                                <img v-if="job.company_logo" :src="storageUrl + 'companies/' + job.company_logo" class="img-fluid job__logo" />
                                <div v-else class="job__logoAlternative">{{ job.company }}</div>
                            </div>
                            <div class="col-8 col-xl-9">
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
                                    <div class="col-12 job__source">{{ job.formated_location }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-12 job__source">{{ job.source }}</div>
                                </div>
                            </div>
                            <div class="col-2">
                                <app-button type="external" class="buttonRed" :link="job.url">VIEW</app-button>
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
import AppButton from "@/Shared/AppButton";

export default {
    components: {
        AppLayout,
        TheHead,
        TheMain,
        AppButton,
    },
    layout: AppLayout,
    data() {
        return {
            storageUrl: this.$page.props.storageUrl + "/",
        };
    },
    computed: {
        jobs: function () {
            return this.$page.props.jobs;
        },
    },
};
</script>
<style lang="scss" scoped>
h2 {
    color: $appRed;
}
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

.job__logoAlternative {
    width: 120px;
    height: 120px;
    background-color: $appBlack;
    color: #ffffff;
    border-radius: 50%;
    text-align: center;
    font-size: 24px;
    font-weight: 700;
    padding-top: 20px;
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
