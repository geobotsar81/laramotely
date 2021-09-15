<template>
    <a v-if="type === 'external'" :href="link" :class="cls" class="button"><slot /></a>

    <button v-else-if="type === 'submit'" :class="cls" class="button">
        <slot />
    </button>

    <inertia-link v-else :href="link" :class="cls" class="button">
        <slot />
    </inertia-link>
</template>
<script>
export default {
    props: {
        cls: {
            type: String,
            required: false,
        },
        link: {
            type: String,
            required: false,
        },
        type: {
            type: String,
            required: false,
        },
    },
};
</script>
<style lang="scss" scoped>
.acurisCheck {
    display: block;
    padding: 15px;
    width: 100%;
    text-align: center;
    border: solid 1px $projectBlue;
    border-radius: 3px;
    transition: $primaryTransition;
    background-color: #ffffff;

    &:hover,
    &:focus {
        background-color: #d0ddec;
    }

    &.disabled {
        pointer-events: none;
        background-color: #ccc;
    }
}

.buttonBlue,
.upload {
    display: inline-block;
    background-color: $projectBlue;
    font-weight: 700;
    font-style: normal;
    font-size: 14px;
    color: #fff;
    border-radius: 3px;
    padding: 15px 40px;
    transition: all 0.4s ease-out;
    text-decoration: none;
    border: none;
    border: 0px solid $projectBlue;

    &:hover,
    &:focus {
        color: #fff;
        border: 0px solid $projectBlue;
        background-color: $projectBlue2;
        text-decoration: none;
        outline: none;
        box-shadow: none;
    }

    :deep(i) {
        font-size: 12px;
        padding: 0px 5px;
    }

    &.disabled {
        background-color: $projectGrey10;
        cursor: not-allowed;
        pointer-events: none;
    }
}

.buttonWhite {
    display: inline-block;
    font-weight: 700;
    font-style: normal;
    font-size: 14px;
    color: $projectBlue;
    border-radius: 3px;
    padding: 15px 40px;
    transition: all 0.4s ease-out;
    background-color: #fff;
    text-decoration: none;
    border: none;
    border: 1px solid $projectBlue;

    &:hover,
    &:focus {
        color: $projectBlue;
        background-color: #d0ddec;
        text-decoration: none;
        outline: none;
        box-shadow: none;
    }

    i {
        font-size: 12px;
        padding: 0px 5px;
    }
}

.buttonTransparent {
    display: inline-block;
    font-weight: 700;
    font-style: normal;
    font-size: 14px;
    color: $projectBlue;
    border-radius: 3px;
    padding: 15px 40px;
    transition: all 0.4s ease-out;
    background-color: transparent;
    text-decoration: none;
    border: none;
    border: 1px solid $projectGrey3;

    &:hover,
    &:focus {
        color: $projectBlue;
        border: 1px solid $projectBlue;
        background-color: transparent;
        text-decoration: none;
        outline: none;
        box-shadow: none;
    }

    i {
        font-size: 12px;
        padding: 0px 5px;
    }
}

.buttonGold {
    display: inline-block;
    font-weight: 700;
    font-style: normal;
    font-size: 14px;
    color: #fff;
    border-radius: 3px;
    padding: 15px 40px;
    transition: all 0.4s ease-out;
    background-color: $projectYellow;
    text-decoration: none;
    border: none;
    border: 1px solid $projectYellow;

    &:hover,
    &:focus {
        color: #fff;
        border: 1px solid $projectYellow;
        text-decoration: none;
        outline: none;
        box-shadow: none;
    }
}

.um input[type="submit"].um-button {
    display: inline-block !important;
    background-color: $projectBlue !important;
    font-weight: 700 !important;
    font-style: normal !important;
    font-size: 15px !important;
    color: #fff !important;
    border-radius: 3px !important;
    padding: 15px 30px !important;
    transition: all 0.4s ease-out !important;
    text-decoration: none !important;
    border: none !important;

    &:hover,
    &:focus {
        color: #fff !important;
        border: 0px solid $projectBlue !important;
        background-color: $projectBlue2 !important;
        text-decoration: none !important;
        outline: none !important;
        box-shadow: none !important;
    }
}

// Button Arrow
$text-arrow-space: 12px;
$shaft-width: 1px;
$newshaft-width: 64px;
$shaft-thickness: 1px;
$arrow-head-width: 6px;
$arrow-head-thickness: $shaft-thickness;

// Animated Arrow Button
.buttonArrow {
    display: inline-block;
    color: $projectRed;
    font-size: 12px;
    font-weight: 500;
    padding: 4px 0px;
    text-decoration: none;
    position: relative;
    transition: all 0.2s;

    &:focus {
        outline: none;
    }

    &:hover {
        color: $projectRed;
        text-decoration: none;

        > .the-arrow.-left {
            > .shaft {
                width: $newshaft-width;
                transition-delay: 0.1s;
                background-color: $projectRed;

                &:before,
                &:after {
                    width: $arrow-head-width;
                    transition-delay: 0.1s;
                    background-color: $projectRed;
                }

                &:before {
                    transform: rotate(40deg);
                }

                &:after {
                    transform: rotate(-40deg);
                }
            }
        }

        > .main {
            transform: translateX($shaft-width + $text-arrow-space);
            transform: translateX($newshaft-width + $text-arrow-space);

            > .the-arrow.-right {
                > .shaft {
                    width: 0;
                    transform: translateX(200%);
                    transition-delay: 0;

                    &:before,
                    &:after {
                        width: 0;
                        transition-delay: 0;
                        transition: all 0.1s;
                    }

                    &:before {
                        transform: rotate(0);
                    }

                    &:after {
                        transform: rotate(0);
                    }
                }
            }
        }
    }

    > .main {
        display: flex;
        align-items: center;
        transition: all 0.2s;

        > .text {
            margin: 0 $text-arrow-space 0 0;
            line-height: 1;
            font-weight: 500;
        }

        > .the-arrow {
            position: relative;
        }
    }

    .the-arrow {
        width: $shaft-width;
        transition: all 0.2s;

        &.-left {
            position: absolute;
            top: 40%;
            left: 0;

            > .shaft {
                width: 0;
                background-color: $projectRed;

                &:before,
                &:after {
                    width: 0;
                    background-color: $projectRed;
                }

                &:before {
                    transform: rotate(0);
                }

                &:after {
                    transform: rotate(0);
                }
            }
        }

        &.-right {
            top: 0px;

            > .shaft {
                width: $shaft-width;
                transition-delay: 0.2s;

                &:before,
                &:after {
                    width: $arrow-head-width;
                    transition-delay: 0.3s;
                    transition: all 0.5s;
                }

                &:before {
                    transform: rotate(40deg);
                }

                &:after {
                    transform: rotate(-40deg);
                }
            }
        }

        > .shaft {
            background-color: $projectRed;
            display: block;
            height: $shaft-thickness;
            position: relative;
            transition: all 0.2s;
            transition-delay: 0;
            will-change: transform;

            &:before,
            &:after {
                background-color: $projectRed;
                content: "";
                display: block;
                height: $arrow-head-thickness;
                position: absolute;
                top: 0;
                right: 0;
                transition: all 0.2s;
                transition-delay: 0;
            }

            &:before {
                transform-origin: top right;
            }

            &:after {
                transform-origin: bottom right;
            }
        }
    }
}
</style>
