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
    width: 80px;
    height: 80px;
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
