<template>
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
                <div class="row" v-if="job.location">
                    <div class="col-12 job__source"><i class="far fa-globe-americas"></i> {{ job.formated_location }}</div>
                </div>
                <!--<div class="row">
                    <div class="col-12 job__source">{{ job.source }}</div>
                </div>-->
            </div>
            <div class="col-2">
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
<style lang="scss" scoped></style>
