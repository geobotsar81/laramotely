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
            <div class="row">
                <div class="col-12">
                    <input @change="searchJobs" type="text" v-model="search" class="form-control" placeholder="Search Laravel Jobs" />
                </div>
            </div>
            <div class="mt-4" v-if="jobs">
                <div v-for="(job, index) in jobs" :key="index">
                    <app-job :job="job"></app-job>
                </div>

                <pagination :currentPage="currentPage" :links="links" v-model="currentPage" />
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

export default {
    components: {
        AppLayout,
        TheHead,
        TheMain,
        AppButton,
        AppJob,
        Pagination,
    },
    mounted() {
        this.getJobs();
    },
    data() {
        return {
            jobs: null,
            links: null,
            currentPage: 1,
            search: null,
        };
    },
    layout: AppLayout,
    methods: {
        searchJobs() {
            this.currentPage = 1;
            this.getJobs();
        },
        getJobs() {
            axios({
                method: "post",
                url: "/get-jobs",
                data: {
                    page: this.currentPage,
                    search: this.search,
                },
            })
                .then((response) => {
                    //Show button after generating report
                    //console.log("Response:" + response.data);
                    this.jobs = response.data.data;
                    this.links = response.data.links;
                })
                .catch((error) => {});
        },
    },
    watch: {
        currentPage(newData, oldData) {
            this.getJobs();
        },
    },
};
</script>
<style lang="scss" scoped>
h2 {
    color: $appRed;
}
</style>
