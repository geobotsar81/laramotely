<template>
    <div class="article">
        <div class="row align-items-center">
            <div class="article__imageContainer">
                <a :href="article.url" target="_blank" v-if="article.formated_image"><img class="article__image" :src="'https://www.laramotely.com/storage/news/' + article.formated_image" /> </a>
            </div>

            <div v-if="article.category" class="article__category">{{ article.category }}</div>
            <div class="article__title">
                <a :href="article.url" target="_blank">{{ article.title }}</a>
            </div>

            <div class="article__description" v-if="article && article.description" v-html="article.description"></div>

            <div class="article__date">{{ article.formated_date }}</div>

            <div class="mt-2" v-if="article && article.url">
                <a :href="article.url"><i class="fas fa-external-link-square-alt"></i> Read more</a>
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
        article: {
            type: Object,
            required: true,
        },
        count: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            storageUrl: this.$page.props.storageUrl + "/",
        };
    },
    methods: {
        calculateClass() {
            return this.count % 2 == 0 ? "odd" : "even";
        },
    },
};
</script>
<style lang="scss" scoped>
.hidden-xs {
    display: none;
}

.article {
    padding-bottom: 40px;
}

.article__title {
    color: $appBlack;
    font-size: 20px;
    font-weight: 700;
    line-height: 22px;
    padding-top: 5px;

    a {
        color: $appBlack !important;
    }
}

.article__imageContainer {
    text-align: center;
}

.article__image {
    max-width: 100%;
    border-radius: 6px;
    margin: auto;
    vertical-align: bottom;
    padding-bottom: 10px;
}

.article__logo--detail {
    padding-top: 10px;
}

.article__date {
    color: $appGrey;
    font-size: 14px;
    font-weight: 400;
    line-height: 14px;
    padding-top: 5px;
}

.article__category {
    color: $appRed;
    font-size: 16px;
    font-weight: 700;
    line-height: 16px;
    padding-top: 5px;
}

.article__description {
    padding-top: 5px;
}

.article__source {
    font-size: 12px;
    font-style: italic;
}

.article__button {
    display: inline-block;
    padding-top: 10px;
    i {
        padding-right: 10px;
    }

    a {
        padding: 15px;
    }
}

@media (max-width: 767.98px) {
}

@media (max-width: 767.98px) {
}
</style>
