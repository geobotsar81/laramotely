<template>
    <the-head :title="meta_title" :description="meta_description" :url="route('news.show-detail', article.id)"></the-head>

    <the-main id="main">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <inertia-link :href="route('news.show')"><i class="far fa-chevron-square-left"></i> Back to articles</inertia-link>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-12 col-lg-8 mb-4">
                    <div class="row">
                        <div class="col-12 job__date">{{ article.formated_date }}</div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h1>{{ article.title }}</h1>
                        </div>
                    </div>
                    <div class="row mb-2" v-if="article.location">
                        <div class="col-12 job__source"><i class="far fa-globe-americas"></i> {{ article.formated_location }}</div>
                    </div>

                    <div class="row mb-4" v-if="article.formated_tags && article.source != 'remotive.io'">
                        <div class="col-12">
                            <span class="job__tag" v-for="(tag, index) in article.formated_tags" :key="index">{{ tag }}</span>
                        </div>
                    </div>

                    <!--<div class="row mb-5">
                        <div class="col-12">
                            <div class="commandpost">
                                <a href="https://commandpost.dev/" target="_blank">
                                    <div class="row">
                                        <div class="col-12"><img :src="publicUrl + '/img/commandpost2.jpg'" class="img-fluid" /></div>
                                    </div>
                                    <div class="commandpost__content">
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <h2><i class="far fa-code"></i> commadpost.dev</h2>
                                            </div>
                                        </div>
                                        <div class="row mt-2"><div class="col-12">A place for web devs to store their commands and organise them into collections</div></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>-->

                    <div class="row mb-5" v-if="article.description">
                        <div class="col-12 job__description">
                            <span v-html="article.description"></span>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <app-button type="external" class="buttonRed" :link="article.url">READ MORE</app-button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-12"><h3>Latest Laravel News</h3></div>
                    </div>
                    <div class="mt-4" v-if="otherArticles">
                        <div v-for="(article, index) in otherArticles" :key="index">
                            <app-article :article="article"></app-article>
                        </div>
                    </div>
                </div>
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
import { InertiaLink } from "@inertiajs/inertia-vue3";
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
        AppArticle,
        InertiaLink,
    },
    layout: AppLayout,
    mounted() {},

    methods: {},
    data() {
        return {
            storageUrl: this.$page.props.storageUrl + "/",
            publicUrl: this.$page.props.publicUrl + "/",
        };
    },
    computed: {
        article: function () {
            return this.$page.props.article;
        },
        otherArticles: function () {
            return this.$page.props.otherArticles;
        },
        meta_title: function () {
            return this.$page.props.meta_title;
        },
        meta_description: function () {
            return this.$page.props.meta_description;
        },
        getBackgroundImage() {
            let imageNumber = this.job.id % 5;
            return "background-image:url('" + this.publicUrl + "img/headerImage" + imageNumber + ".jpg')";
        },
    },
};
</script>
<style lang="scss" scoped>
main {
    padding-top: 40px;
}
h1 {
    font-weight: 700;
}

.hero {
    background-image: url("/img/headerImage.jpg");
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    height: 450px;
    margin-top: 70px;
    position: relative;
}

.hero__overlay {
    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
}

.commandpost,
.freeOnlineTools {
    border: solid 1px $appGrey;
    border-radius: $appBorderRadius;
    overflow: hidden;

    img {
        transition: $appTransition;
    }

    &:hover,
    &:focus {
        img {
            transform: scale(101%);
        }

        .commandpost__content {
            background-color: $appLightGrey;

            h2 {
                color: $appRed;
            }
        }
    }
}

.commandpost__content {
    padding: 10px;
    color: $appBlack;
    font-size: 18px;
    transition: $appTransition;

    h2 {
        margin: 0px;
        padding: 0px;
        font-size: 20px;
        font-weight: 700;
        transition: $appTransition;
    }
}

.hero__content {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    text-align: center;
    padding-top: 140px;
}

.hero__content__title {
    font-size: 80px;
    line-height: 80px;
    font-weight: 700;
    color: #fff;
    span {
        color: $appRed;
    }
}

.hero__content__text {
    font-size: 40px;
    line-height: 44px;
    font-weight: 400;
    color: #fff;
}
.job__description {
    :deep(h2) {
        padding-top: 10px;
        font-size: 26px;
    }
    :deep(.ai-baseline) {
        display: none;
    }
    :deep(.js-apply-container) {
        display: none;
    }
    :deep(.s-tag) {
        pointer-events: none;
        padding: 5px 10px;
        color: $appBlack !important;
        background-color: $appLightGrey;
        margin: 0px 5px;
    }

    :deep(p) {
        margin-bottom: 5px;
    }
    :deep(img) {
        display: none;
    }
    :deep(.title) {
        display: none;
    }
    :deep(.timestamp-wrapper) {
        display: none;
    }
}

@media (max-width: 1199.98px) {
    .hero {
        height: 400px;
    }
    .hero__content {
        padding-top: 110px;
    }
}

@media (max-width: 991.98px) {
    .hero {
        height: 350px;
    }
    .hero__content {
        padding-top: 90px;
    }
}
@media (max-width: 767.98px) {
    .hero {
        background-attachment: initial;
    }
    .hero {
        height: 250px;
    }
    .hero__content {
        padding-top: 70px;
    }

    .hero__content__title {
        font-size: 60px;
    }
    .hero__content__text {
        font-size: 30px;
        line-height: 34px;
    }
}

@media (max-width: 575.98px) {
    .hero__content {
        padding-top: 50px;
    }

    .hero__content__text {
        font-size: 24px;
        line-height: 28px;
    }

    .job__logoAlternative {
        width: 120px;
        height: 120px;
        display: table-cell;
        vertical-align: middle;
        padding-top: 0px;
    }
}
</style>
