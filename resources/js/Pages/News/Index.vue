<template>
    <the-head :title="$page.props.title" :description="$page.props.description" :url="$page.props.url"></the-head>

    <the-main id="main">
        <div class="container">
            <div class="row text-center">
                <div class="col-12"><h1>Laravel Digest</h1></div>
            </div>
            <div class="row text-center mb-sm-2">
                <div class="col-12"><h2>All the latest Laravel News</h2></div>
            </div>

            <div class="row">
                <div class="col-xl-6 col-lg-5 col-md-4 mb-4 mt-2">
                    <input @change="searchNews" type="text" v-model="search" class="form-control" placeholder="Search Laravel News" />
                </div>
                <div class="col-xl-4 col-lg-5 col-md-4 col-6">
                    <div class="form-check form-switch mt-2">
                        <div class="row">
                            <div class="col-12">
                                <select @change="searchNews" v-model="category" id="newsCategory" class="form-control">
                                    <option value="all">All Categories</option>
                                    <option value="news">News</option>
                                    <option value="packages">Packages</option>
                                    <option value="videos">Videos</option>
                                    <option value="tips">Tips</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 col-lg-2 text-end mt-1"><app-button class="buttonBlack" type="submit" @click.prevent="searchNews">SEARCH</app-button></div>
            </div>

            <img src="img/LoaderIcon.gif" v-if="searching" />

            <div class="row mt-4" v-if="news && !searching">
                <div class="col-md-4" v-for="(article, index) in news" :key="index">
                    <app-article :article="article" :count="index"></app-article>
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
import AppArticle from "@/Shared/AppArticle";
import Pagination from "@/Shared/AppPagination";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { watch } from "vue";

Inertia.on("navigate", (event) => {
    gtag("event", "page_view", {
        page_location: event.detail.page.url,
    });
});

export default {
    components: {
        AppLayout,
        TheHead,
        TheMain,
        AppButton,
        AppArticle,
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
        this.search = localStorage.getItem("search");
        this.category = localStorage.getItem("category") ?? "all";

        this.getNews();
    },
    data() {
        return {
            news: null,
            links: null,
            currentPage: 1,
            search: null,
            category: true,
            searching: false,
        };
    },
    layout: AppLayout,
    computed: {},
    methods: {
        searchNews() {
            this.currentPage = 1;
            this.getNews();
        },
        getNews() {
            this.searching = true;
            axios({
                method: "post",
                url: "/get-news",
                data: {
                    page: this.currentPage,
                    search: this.search,
                    category: this.category,
                },
            })
                .then((response) => {
                    this.news = response.data.data;
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
            this.getNews();
        },
        search(currentValue, oldValue) {
            localStorage.setItem("search", currentValue);
        },
    },
};
</script>
<style lang="scss" scoped>
h2 {
    color: $appRed;
}
</style>
