<template>
    <the-head :title="$page.props.title" :description="$page.props.description" :url="$page.props.url"></the-head>

    <the-main id="main">
        <div class="container">
            <div class="row text-center">
                <div class="col-12"><h1>Remote Laravel Jobs</h1></div>
            </div>
            <div class="row text-center mb-2">
                <div class="col-12"><h2>for the remote Laravel developer</h2></div>
            </div>
            <div class="row text-center mb-5">
                <div class="col-12"><p>We search the web for the best remote Laravel jobs, and bring to you a curated list of backend and frontend Laravel jobs.</p></div>
            </div>
            <div class="row">
                <div class="col-xl-8 col-lg-7 col-md-5 mb-4">
                    <input @change="searchJobs" type="text" v-model="search" class="form-control" placeholder="Search Laravel Jobs" />
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                    <div class="form-check form-switch mt-2">
                        <input @change="searchJobs" type="checkbox" class="form-check-input" id="onlyRemote" v-model="onlyRemote" />
                        <label class="form-check-label" for="onlyRemote">only remote jobs</label>
                    </div>
                </div>
                <div class="col-6 col-md-3 col-lg-2 text-end"><app-button class="buttonBlack" type="submit" @click.prevent="searchJobs">SEARCH</app-button></div>
            </div>

            <img src="img/LoaderIcon.gif" v-if="searching" />

            <div class="mt-4" v-if="jobs && !searching">
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
            onlyRemote: false,
            searching: false,
        };
    },
    layout: AppLayout,
    methods: {
        searchJobs() {
            this.currentPage = 1;
            this.getJobs();
        },
        getJobs() {
            this.searching = true;
            axios({
                method: "post",
                url: "/get-jobs",
                data: {
                    page: this.currentPage,
                    search: this.search,
                    onlyRemote: this.onlyRemote,
                },
            })
                .then((response) => {
                    //Show button after generating report
                    //console.log("Response:" + response.data);
                    this.jobs = response.data.data;
                    this.links = response.data.links;
                    this.searching = false;
                })
                .catch((error) => {
                    this.searching = false;
                });
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

.form-check-input {
    &:hover,
    &:focus {
        box-shadow: none;
    }
}
.form-check-input:checked {
    background-color: $appRed;
    border-color: $appRed;
}
</style>
