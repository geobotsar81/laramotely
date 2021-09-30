<template>
    <header class="header" :class="headerIsActive ? 'is-active' : ''">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-10 col-lg-4">
                    <inertia-link href="/" @click="closeMenu">
                        <app-logo class="header__logo img-fluid"></app-logo>
                    </inertia-link>
                </div>
                <div class="col-2 col-lg-8 text-end mt-2 mt-md-0">
                    <app-nav v-if="mainMenu" :menu="mainMenu" class="d-none d-lg-inline-block"> </app-nav>
                    <div class="hamburger hamburger--spring mt-2 mt-sm-0" :class="headerIsActive ? 'is-active' : ''" @click="toggleBurger">
                        <div class="hamburger-box">
                            <div class="hamburger-inner"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>
<script>
import AppButton from "@/Shared/AppButton";
import AppLogo from "@/Shared/AppLogo";
import AppNav from "@/Shared/AppNav";
import { InertiaLink } from "@inertiajs/inertia-vue3";

export default {
    components: {
        AppLogo,
        AppButton,
        AppNav,
        InertiaLink,
    },
    data() {
        return {
            mainMenu: this.$page.props.menus.main["items"],
            isActiveBurger: this.headerIsActive,
        };
    },
    emits: ["toggleMobileMenu"],
    methods: {
        toggleBurger() {
            this.isActiveBurger = !this.isActiveBurger;
            this.$emit("toggleMobileMenu", this.isActiveBurger);
        },
        closeMenu() {
            console.log("close menu");
            this.isActiveBurger = false;
            this.$emit("toggleMobileMenu", this.isActiveBurger);
        },
    },
    props: {
        headerIsActive: Boolean,
    },
};
</script>

<style lang="scss" scoped>
.header {
    padding: 5px 45px;
    position: fixed;
    width: 100%;
    left: 0;
    top: 0;
    transition: $appTransition;
    z-index: $zindexHeader;
    border-bottom: 1px solid $appLightGrey2;
    background-color: #fff;

    .header__login {
        color: $appBlack;
        text-decoration: none;
        display: inline-block;
        font-size: 12px;
        font-weight: 700;
        margin: 0px 20px;
        transition: $appTransition;

        &:hover,
        &:focus {
            color: $appBlue;
        }
    }

    &.sticky {
        background-color: #fff;
        padding: 10px 45px;
        box-shadow: 0px 10px 20px 0px rgba(40, 42, 57, 0.35);

        .header__logo {
            display: none;
        }
        .header__logoDark {
            display: block;
        }
    }

    .button {
        font-weight: 400;
    }
}

.hamburger {
    display: none;
    vertical-align: text-bottom;
}
.header.is-active {
    border-bottom: 0px;
    background-color: transparent;

    .header__logo {
        color: #ffffff;
    }

    .nav {
        :deep(.nav-link) {
            color: #ffffff;
        }
    }

    .sticky {
        padding: 10px 45px;
        .nav {
            :deep(.nav-link) {
                color: $appBlack;
            }
        }
        .header__login {
            color: $appBlack;
        }
        .button {
            &:hover,
            &:focus {
                color: #ffffff;

                :deep(strong) {
                    color: #ffffff;
                }
            }
        }
    }

    .hamburger {
        .hamburger-inner,
        .hamburger-inner::before,
        .hamburger-inner::after {
            background-color: #fff;
        }
    }

    .sticky {
        .hamburger {
            .hamburger-inner,
            .hamburger-inner::before,
            .hamburger-inner::after {
                background-color: $appBlack;
            }
        }
    }
}

@media (max-width: 1199.98px) {
    .header {
        &.sticky {
            padding: 10px 15px;
        }
    }
    .home,
    .is-active {
        .header {
            padding: 15px;
            &.sticky {
                padding: 10px 15px;
            }
        }
    }
}

@media (max-width: 991.98px) {
    .hamburger {
        display: inline-block;
    }

    .home {
    }

    .header {
        padding: 5px 0px;

        :deep(.button--large) {
            padding: 5px 10px;
            margin-top: 7px;
        }

        .header__login {
            vertical-align: top;
            padding-top: 22px;
        }
    }
}

@media (max-width: 575.98px) {
}
</style>
