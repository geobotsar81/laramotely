<template>
    <div class="job">
        <div class="row align-items-center">
            <div class="col-12 mb-2 text-center">
                <div class="row">
                    <div class="col-12 job__date">{{ job.formated_date }}</div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h3>{{ job.title }}</h3>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 job__company">{{ job.company }}</div>
                </div>
                <div class="row" v-if="job.location">
                    <div class="col-12 job__source">
                        <i v-if="job.location.includes('Remote') || job.location.includes('Anywhere')" class="far fa-globe-americas"></i>
                        <i v-else class="far fa-map-marker-alt"></i>
                        {{ job.formated_location }}
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center">
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
    },
    data() {
        return {
            storageUrl: this.$page.props.storageUrl + "/",
        };
    },
};
</script>
<style lang="scss" scoped>
:deep(.buttonRed) {
    padding: 8px 20px;
}

.job h3 {
    font-size: 20px;
}
</style>
