<template>
    <footer class="footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-5 text-center text-md-start mb-4">
                    <div class="row">
                        <div class="col-12">
                            <h2>
                                lara<span>m<i class="far fa-globe-americas"></i>tely</span>
                            </h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 footer__text">
                            We bring to you a curated list of the best Laravel remote jobs, sourced from all over the web. If you are a Full Stack, Frontend or Backend Laravel developer, looking to
                            work remotely, this is the place for you.
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-7 text-center text-md-end">
                    <div class="row">
                        <div class="col-12 footer__count">{{ jobsCount }}</div>
                        <div class="col-12">remote laravel jobs added</div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 footer__social">
                            <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="copyrights">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">© laramotely.com {{ currentYear }}. All rights reserved</div>
            </div>
        </div>
    </div>
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
            currentYear: this.$page.props.currentYear,
            jobsCount: this.$page.props.jobsCount,
        };
    },
};
</script>
<style lang="scss" scoped>
.footer {
    padding: 40px 0px;
    color: #fff;
    background-color: $appBlack;

    h2 {
        color: #fff;
        font-size: 34px;
        font-weight: 700;

        span {
            color: $appRed;
        }

        i {
            font-size: 24px;
        }
    }
}

.footer__text {
    opacity: 0.8;
}

.footer__count {
    color: #ffffff;
    font-size: 26px;
    font-weight: 700;
}

.copyrights {
    color: #ffffff;
    padding: 10px 0px;
    font-size: 14px;
    background-color: #000000;
}

.footer__social {
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
@media (max-width: 767.98px) {
    .footer {
        text-align: center;
    }
    .footer__social {
        text-align: center;
    }
}
</style>
