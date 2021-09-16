<template>
    <footer class="footer">
        <div class="container">
            <!-- Footer Menus -->
            <div class="row">
                <div class="col-sm-12 col-md-3 mb-4 footerAnimate1">
                    <div class="row">
                        <div class="col-sm-6 col-md-12 mb-4 mb-sm-0">
                            <inertia-link :href="route('page')">
                                <app-logo-footer class="img-fluid" :alt="imageTag"></app-logo-footer>
                            </inertia-link>
                        </div>

                        <div class="col-sm-6 col-md-12">
                            <!--<div class="row mt-md-5">
                                <div class="col-12">Powered by</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <img
                                        :src="
                                            publicUrl + '/images/finclude.png'
                                        "
                                        class="img-fluid"
                                        :alt="imageTag"
                                    />
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="col-md-8 offset-md-1">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-lg-3 footer__menu footerAnimate1">
                            <h3 v-if="menuTitle1">{{ menuTitle1 }}</h3>
                            <ul v-if="menuItems1">
                                <li v-for="(item, index) in menuItems1" :key="index">
                                    <inertia-link v-if="item.target == '_self'" :href="route('page', item.url)">{{ item.title }}</inertia-link>
                                    <a v-else target="_blank" :href="item.url">{{ item.title }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3 footer__menu footerAnimate1">
                            <h3 v-if="menuTitle2">{{ menuTitle2 }}</h3>
                            <ul v-if="menuItems2">
                                <li v-for="(item, index) in menuItems2" :key="index">
                                    <inertia-link v-if="item.target == '_self'" :target="item.target" :href="route('page', item.url)">{{ item.title }}</inertia-link>
                                    <a v-else target="_blank" :href="item.url">{{ item.title }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3 footer__menu footerAnimate1">
                            <h3 v-if="menuTitle3">{{ menuTitle3 }}</h3>
                            <ul v-if="menuItems3">
                                <li v-for="(item, index) in menuItems3" :key="index">
                                    <inertia-link v-if="item.target == '_self'" :target="item.target" :href="route('page', item.url)">{{ item.title }}</inertia-link>
                                    <a v-else target="_blank" :href="item.url">{{ item.title }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3 footer__menu footerAnimate1">
                            <h3 v-if="menuTitle4">{{ menuTitle4 }}</h3>
                            <ul v-if="menuItems4">
                                <li v-for="(item, index) in menuItems4" :key="index">
                                    <inertia-link v-if="item.target == '_self'" :target="item.target" :href="route('page', item.url)">{{ item.title }}</inertia-link>
                                    <a v-else target="_blank" :href="item.url">{{ item.title }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Drawing -->
            <div class="row mt-4">
                <div class="col-12 footer__drawing footerAnimate2">
                    <img :src="publicUrl + '/images/footerIcon.png'" :alt="imageTag" />
                    <hr />
                </div>
            </div>
            <!-- Copyright & Social -->
            <div class="row mt-3 mt-sm-0">
                <div class="col-md-6 text-center offset-md-3 footer__copyrights mb-2 mb-md-0 footerAnimate2">
                    {{ copyrights }}
                </div>
                <div class="col-md-3 footer__social text-center text-md-end footerAnimate2" v-if="socialItems">
                    <a target="_blank" v-for="(social, index) in socialItems" :href="social.url" :key="index">
                        <i :class="social.icon_class"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>
<script>
import AppLogoFooter from "@/Shared/AppLogoFooter";

export default {
    emits: ["initialised"],
    components: {
        AppLogoFooter,
    },
    data() {
        return {
            menuItems1: this.$page.props.menus.footerMenu1["items"],
            menuTitle1: this.$page.props.menus.footerMenu1["title"],
            menuItems2: this.$page.props.menus.footerMenu2["items"],
            menuTitle2: this.$page.props.menus.footerMenu2["title"],
            menuTitle3: this.$page.props.menus.footerMenu3["title"],
            menuItems3: this.$page.props.menus.footerMenu3["items"],
            menuTitle4: this.$page.props.menus.footerMenu4["title"],
            menuItems4: this.$page.props.menus.footerMenu4["items"],
            socialItems: this.$page.props.menus.socialMenu["items"],
            imageTag: this.$page.props.meta.title,
            copyrights: this.$page.props.generic.copyrights,
            publicUrl: this.$page.props.generic.publicUrl,
        };
    },
};
</script>
<style lang="scss" scoped>
.footer {
    padding: 40px 0px 20px 0px;
    color: $appGrey2;
    background-color: $appLightGrey;
}
.footer__menu {
    h3 {
        color: $appGrey;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        padding-bottom: 0px;
    }
    ul {
        padding-left: 0px;
    }
    li {
        list-style: none;
        padding-bottom: 10px;
        a {
            color: $appBlack;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: $appTransition;

            &:hover,
            &:focus {
                color: $appBlue;
            }
        }
    }
}

.footer__drawing {
    hr {
        height: 1px;
        background: linear-gradient(293.41deg, #00b4cc 30.22%, #80c342 100%);
    }
    img {
        margin-bottom: -50px;
        position: relative;
        z-index: 1;
    }
}

.footer__copyrights {
    color: $appGreyDark;
    font-size: 12px;
    padding-top: 5px;
}

.footer__social {
    a {
        display: inline-block;
        margin: 0px 10px;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        background-color: $appBlue;
        text-align: center;
        padding-top: 2px;
        transition: $appTransition;

        &:hover,
        &:focus {
            background-color: $appDarkBlue;
        }

        i {
            font-size: 15px;
            color: #ffffff;
        }
    }
}
@media (max-width: 575.98px) {
    .footer {
        text-align: center;
    }

    .footer__menu {
        h3 {
            margin-top: 20px;
        }
    }
}
</style>
