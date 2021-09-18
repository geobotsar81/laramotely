<template>
    <the-head :title="$page.props.title" :description="$page.props.description" :url="$page.props.url"></the-head>

    <the-main id="main">
        <div class="container">
            <div class="row text-center">
                <div class="col-12"><h1>Remote Laravel Jobs</h1></div>
            </div>
            <div class="row text-center mb-5">
                <div class="col-12"><h2>for the remote Laravel developer</h2></div>
            </div>
            <div v-for="(job, index) in jobs" :key="index">
                <app-job :job="job"></app-job>
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

export default {
    components: {
        AppLayout,
        TheHead,
        TheMain,
        AppButton,
        AppJob,
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
h2 {
    color: $appRed;
}
</style>
