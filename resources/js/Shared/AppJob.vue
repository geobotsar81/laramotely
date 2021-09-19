<template>
    <div class="job">
        <div class="row align-items-center">
            <div class="col-3 col-md-2 col-lg-1">
                <img v-if="job.company_logo && job.source != 'linkedin.com'" :src="storageUrl + 'companies/' + job.company_logo" class="img-fluid job__logo" />
                <div v-else class="job__logoAlternative">{{ job.company }}</div>
                <!--<div class="row mt-2">
                    <div class="col-12 job__company">{{ job.company }}</div>
                </div>-->
            </div>
            <div class="col-9 col-md-7 col-lg-8 mb-2">
                <div class="row">
                    <div class="col-12 job__date">{{ job.formated_date }}</div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h3>{{ job.title }}</h3>
                    </div>
                </div>
                <div class="row" v-if="job.location">
                    <div class="col-12 job__source"><i class="far fa-globe-americas"></i> {{ job.formated_location }}</div>
                </div>
                <div class="row mt-2" v-if="job.formated_tags">
                    <div class="col-12">
                        <span class="job__tag" v-for="(tag, index) in job.formated_tags" :key="index">{{ tag }}</span>
                    </div>
                </div>

                <!--<div class="row">
                    <div class="col-12 job__source">{{ job.source }}</div>
                </div>-->
            </div>
            <div class="col-md-3 text-center text-md-end">
                <app-button type="external" v-if="job.source == 'larajobs.com'" class="buttonRed" :link="job.url"><i class="fas fa-external-link-square-alt"></i> VIEW</app-button>
                <app-button v-else class="buttonRed" :link="route('job.show', job.id)">VIEW</app-button>
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
    },
    data() {
        return {
            storageUrl: this.$page.props.storageUrl + "/",
        };
    },
};
</script>
<style lang="scss" scoped>
@media (max-width: 767.98px) {
    :deep(.buttonRed) {
        padding: 5px 20px;
    }

    .job h3 {
        font-size: 20px;
    }
}
</style>
