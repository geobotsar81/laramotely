<template>
    <div class="job" :class="calculateClass()">
        <div class="row align-items-center">
            <div class="col-md-2 col-lg-1 job__logoContainer">
                <img v-if="job.company_logo && job.source == 'laramotely.com'" :src="storageUrl + job.company_logo" class="img-fluid job__logo" />
                <img
                    v-else-if="job.company_logo && job.company_logo != 'nologo.svg'"
                    :src="storageUrl + 'companies/' + job.company_logo"
                    class="img-fluid job__logo"
                    onerror="this.style.display = 'none'"
                />
                <div v-else-if="job.company" class="job__logoAlternative">{{ job.company }}</div>
                <div v-else class="job__logoAlternative">N/A</div>
            </div>
            <div class="col-md-7 col-lg-8 mb-2">
                <div class="row">
                    <div class="col-12 job__date">{{ job.formated_date }}</div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h3>{{ job.title }}</h3>
                    </div>
                </div>
                <div class="row" v-if="$page.props.title == 'Jobs - Laramotely'">
                    <div class="col-12 mb-1 job__website">
                        {{ job.source }}
                    </div>
                </div>
                <div class="row" v-if="$page.props.title == 'Jobs - Laramotely'">
                    <div class="col-12 job__date">{{ job.formated_created }}</div>
                </div>
                <div class="row" v-if="job.location">
                    <div class="col-12 job__source">
                        <span v-if="job.is_remote"><i class="far fa-globe-americas"></i> Remote/</span>
                        <span v-else><i class="far fa-map-marker-alt"></i></span>
                        {{ job.formated_location }}
                    </div>
                </div>
                <div class="row job__company" v-if="job.salary">
                    <div class="col-12">
                        {{ job.salary }}
                    </div>
                </div>
                <div class="row mt-1 mt-sm-2" v-if="job.company">
                    <div class="col-12 job__company">by {{ job.company }}</div>
                </div>
                <div class="row" v-if="job.formated_tags">
                    <div class="col-12 mt-sm-2" v-if="job.formated_tags != ''">
                        <span class="job__tag" v-for="(tag, index) in job.formated_tags" :key="index">{{ tag }}</span>
                    </div>
                </div>

                <!--<div class="row">
                    <div class="col-12 job__source">{{ job.source }}</div>
                </div>-->
            </div>
            <div class="col-md-3 text-center text-md-end">
                <app-button type="external" v-if="!job.description" class="buttonRed" :link="job.url"><i class="fas fa-external-link-square-alt"></i> VIEW</app-button>
                <app-button v-else class="buttonRed" :link="route('job.show', job.id)">READ MORE</app-button>
            </div>
        </div>
    </div>
</template>
<script>
import AppButton from "@/Shared/AppButton";

export default {
    components: {
        AppButton,
    },
    props: {
        job: {
            type: Object,
            required: true,
        },
        count: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            storageUrl: this.$page.props.storageUrl + "/",
        };
    },
    methods: {
        calculateClass() {
            return this.count % 2 == 0 ? "odd" : "even";
        },
    },
};
</script>
<style lang="scss" scoped>
.job__website {
    display: none;
}

@media (max-width: 767.98px) {
    :deep(.buttonRed) {
        padding: 5px 20px;
    }

    .job h3 {
        font-size: 20px;
    }
}

@media (max-width: 767.98px) {
    .job {
        position: relative;
        padding-right: 80px;
    }

    .job h3 {
        font-size: 18px;
        line-height: 20px;
    }

    .job__logoContainer {
        position: absolute;
        right: 10px;
        top: 10px;
        width: 70px;
        height: 70px;
        padding: 0px;
    }

    .job__logo {
        width: 70px;
        height: auto;
    }

    .job__logoAlternative {
        width: 70px;
        height: 70px;
    }
}
</style>
