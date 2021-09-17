<template>
    <header class="header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-3 col-xl-2">
                    <inertia-link :href="route('home.show')">
                        <app-logo class="header__logo img-fluid"></app-logo>
                    </inertia-link>
                </div>
                <div class="col-9 col-xl-10 text-end">
                    <app-nav v-if="mainMenu" :menu="mainMenu" class="d-none d-lg-inline-block"> </app-nav>
                    <div class="hamburger hamburger--spring mt-2 mt-sm-0" :class="isActiveBurger ? 'is-active' : ''" @click="toggleBurger">
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

export default {
    components: {
        AppLogo,
        AppButton,
        AppNav,
    },
    data() {
        return {
            mainMenu: this.$page.props.menus.main["items"],
            isActiveBurger: false,
        };
    },
    emits: ["toggleMobileMenu"],
    methods: {
        toggleBurger() {
            this.isActiveBurger = !this.isActiveBurger;
            this.$emit("toggleMobileMenu", this.isActiveBurger);
        },
    },
};
</script>

<style lang="scss" scoped>
.header {
    padding: 10px 45px;
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
.header__logo {
}

.hamburger {
    display: none;
    vertical-align: text-bottom;
}

.home,
.is-active {
    .header {
        padding: 35px 45px;
        border-bottom: 0px;
    }
    .header__logo {
        display: block;
    }
    .header__logoDark {
        display: none;
    }
    .header__login {
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
        padding: 15px;
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
    .header__logo,
    .header__logoDark {
        width: 157px;
    }
}
</style>
