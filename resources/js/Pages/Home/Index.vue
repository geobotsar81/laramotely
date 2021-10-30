<template>
    <the-head :title="$page.props.title" :description="$page.props.description" :url="$page.props.url"></the-head>

    <the-main id="main">
        <div class="container">
            <div class="row text-center">
                <div class="col-12"><h1>Remote & on-site Laravel Jobs</h1></div>
            </div>
            <div class="row text-center mb-sm-2">
                <div class="col-12"><h2>for the Laravel developer</h2></div>
            </div>
            <div class="row text-center mb-1 mb-sm-3">
                <div class="col-12"><p>We search the web for the best remote and on-site Laravel jobs, and bring to you a curated list of backend and full-stack Laravel jobs.</p></div>
            </div>
            <div class="row mb-3 mb-sm-5">
                <div class="col-12">
                    <div class="newsletter">
                        <form name="contacForm" @submit.prevent="submitForm">
                            <input type="hidden" name="honeypot" v-model="form.honeypot" />
                            <div v-if="form.errors.honeypot" class="formError">
                                {{ form.errors.honeypot }}
                            </div>

                            <div class="row">
                                <div class="col-lg-8 col-sm-8">
                                    Get email notifications for new jobs
                                    <input type="text" class="form-control mt-1" placeholder="Your email address" v-model="form.email" />
                                    <div v-if="form.errors.email" class="formError">
                                        {{ form.errors.email }}
                                    </div>
                                    <div class="row" v-if="formSuccess">
                                        <div class="col-sm-12">
                                            <div class="formSuccess">You have successfully subscribed</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-4 mt-1">
                                    <img src="img/LoaderIcon.gif" v-if="form.processing" class="mt-2 mt-md-4" />
                                    <app-button v-if="!form.processing" type="submit" class="buttonRed mt-2 mt-md-4">Subscribe</app-button>
                                </div>
                                <div class="col-lg-2 text-end d-none d-lg-block">
                                    Or follow us:
                                    <div class="row mt-2">
                                        <div class="col-12 newsletter__social">
                                            <a href="https://twitter.com/laramotely" target="_blank"><i class="fab fa-twitter"></i></a>
                                            <a href="https://www.facebook.com/laramotely" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
                    <app-job :job="job" :count="index"></app-job>
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
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

Inertia.on("navigate", (event) => {
    gtag("event", "page_view", {
        page_location: event.detail.page.url,
    });
    console.log(`Navigated to ${event.detail.page.url}`);
});

export default {
    components: {
        AppLayout,
        TheHead,
        TheMain,
        AppButton,
        AppJob,
        Pagination,
    },
    setup() {
        const form = useForm({
            email: null,
            honeypot: null,
        });

        return { form };
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
        submitForm() {
            this.formSuccess = false;
            this.form.submit("post", route("subscribe"), {
                preserveScroll: true,
                onSuccess: () => {
                    this.form.reset("email");
                    this.formSuccess = true;
                },
            });
        },
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

.formError {
    color: $appRed;
    padding-top: 5px;
}

.formSuccess {
    color: $appGreen;
    padding-top: 5px;
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

.newsletter {
    border-radius: 4px;
    background-color: $appBlack;
    padding: 15px 20px;
    color: #ffffff;

    :deep(.buttonRed) {
        width: 100%;
    }
}

.newsletter__social {
    text-align: right;
    a {
        display: inline-block;
        margin: 0px 10px;
        border-radius: 50%;
        width: 34px;
        height: 34px;
        background-color: $appRed;
        text-align: center;
        padding-top: 6px;
        transition: $appTransition;

        &:hover,
        &:focus {
            background-color: #fff;
            i {
                color: $appRed;
            }
        }

        i {
            font-size: 22px;
            color: #fff;
        }
    }
}
</style>
