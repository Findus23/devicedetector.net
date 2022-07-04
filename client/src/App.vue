<template>
    <div id="app">
        <div class="content">
            <div>
                <b-navbar toggleable="lg" type="dark">
                    <b-navbar-brand :to="{name:'main'}">Device Detector</b-navbar-brand>

                    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

                    <b-collapse id="nav-collapse" is-nav>
                        <b-navbar-nav>
                            <b-nav-item :to="{name:'main'}" :linkClasses="{active:$route.name==='main'}">
                                Home
                            </b-nav-item>
                            <b-nav-item :to="{name:'detectedDevices'}" :linkClasses="{active:$route.name==='detectedDevices'}">
                                Detected Devices
                            </b-nav-item>
                            <b-nav-item :to="{name:'contribute'}" :linkClasses="{active:$route.name==='contribute'}">
                                Contribute
                            </b-nav-item>
                            <a href="https://github.com/matomo-org/device-detector#usage" class="nav-link" target="_blank" rel="noopener">
                              Usage
                            </a>
                            <b-nav-item :to="{name:'ports'}" :linkClasses="{active:$route.name==='ports'}">
                                Ports
                            </b-nav-item>
                        </b-navbar-nav>

                        <!-- Right aligned nav items -->
                        <b-navbar-nav class="ml-auto">
                            <a href="https://github.com/matomo-org/device-detector">
                                <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="24"
                                     height="24">
                                    <title>GitHub icon</title>
                                    <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"></path>
                                </svg>
                            </a>
                        </b-navbar-nav>
                    </b-collapse>
                </b-navbar>
            </div>
            <div class="container">
                <router-view :lastUpdated="lastUpdated"/>
            </div>
        </div>
        <footer>
            <div>
                using Device Detector <a :href="'https://github.com/matomo-org/device-detector/tree/'+commitHash"
                                         target="_blank">{{shortHash}}</a>
            </div>
            <div>
                &copy; Matomo team & Stefan Giehl
            </div>
            <div>
                last updated on {{lastUpdated.toLocaleString()}}
            </div>
        </footer>
    </div>
</template>

<script lang="ts">
    import Vue from "vue";
    import {Version} from "./interfaces";
    // @ts-ignore
    import {NavbarPlugin} from "bootstrap-vue";
    Vue.use(NavbarPlugin);

    const versionJSON = "/version.json";

    export default Vue.extend({
        name: "Main",
        data() {
            return {
                commitHash: "",
                lastUpdated: new Date()
            };
        },
        computed: {
            shortHash(): string {
                return this.commitHash.substring(0, 7);
            }
        },
        mounted(): void {
            const req = new XMLHttpRequest();
            req.onreadystatechange = (event: Event): void => {
                if (req.readyState === XMLHttpRequest.DONE) {
                    if (req.status === 200) {
                        const data: Version = JSON.parse(req.responseText);
                        this.commitHash = data.commitHash;
                        this.lastUpdated = new Date(data.date);
                    }
                }
            };

            req.open("GET", versionJSON, true);
            req.send(null);
        }
    });
</script>

<style lang="scss">
    @import "scss/style";

    body {
        background: $bg-color;
    }

    nav.navbar {
        background: $navbar-background;

        svg {
            fill: white;
            transition: fill .2s
        }

        a {
            &:focus, &:hover {
                svg {
                    fill: #bbb;
                }
            }
        }
    }

    html, body, #app {
        height: 100%;
    }

    #app {
        display: flex;
        flex-direction: column;
    }

    .content {
        flex: 1 0 auto;
    }

    .container {
        margin-top: 2rem
    }

    footer {
        background: $navbar-background;
        padding: 10px;
        display: flex;
        justify-content: space-between;
        color: white;
        flex-shrink: 0;

        a {
            color: white;
            text-decoration: underline;

            &:hover, &:active, &:focus {
                color: #bbb;
            }
        }

        @include media-breakpoint-down(sm) {
            flex-wrap: wrap;
            div {
                flex-basis: 100%;
                text-align: center;
            }
        }
    }

    #app {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        color: #212121;
    }

</style>
