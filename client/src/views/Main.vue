<template>
    <div class="main">
        <h1>Device Detector Demo</h1>
        <form @submit.prevent="submit">
            <b-input-group class="mt-3">
                <b-form-input type="text" v-model="userAgent" :disabled="processingServerSide"></b-form-input>
                <b-input-group-append>
                    <b-button type="submit" variant="primary" :disabled="processingServerSide">Detect!</b-button>
                </b-input-group-append>
            </b-input-group>
        </form>
        <div v-if="tooManyRequests" class="box centered">
            There were too many requests. Please wait a minute before reloading the website.
        </div>
      <div v-if="serverError" class="box centered">
        There was an error on the server: <code>{{serverError}}</code>
      </div>
        <div v-if="gotData">
            <div v-if="!dd.clientInfo && !dd.botInfo" class="box centered">
                Device Detecter couldn't detect any information about this user agent.
            </div>
            <div v-else-if="dd.isBot" class="box centered">
                <div><a :href="dd.botInfo.url" target="_blank" rel="noopener">{{dd.botInfo.name}}</a></div>
                <div>{{dd.botInfo.category}}</div>
                <div v-if="dd.botInfo.producer">
                    <a v-if="dd.botInfo.producer.url" :href="dd.botInfo.producer.url"
                       target="_blank" rel="noopener">
                        {{dd.botInfo.producer.name}}
                    </a>
                    <template v-else>{{dd.botInfo.producer.name}}</template>
                </div>
            </div>
            <div v-else>
                <div class="box-row">
                    <div class="box centered" v-if="dd.osInfo && (Object.keys(dd.osInfo).length !== 0)">
                        <icon :title="dd.osInfo.short_name" :icon="dd.icons.os"></icon>
                        <div>{{dd.osInfo.name}} {{dd.osInfo.version}}</div>
                        <div>{{dd.osInfo.platform}}</div>
                    </div>
                    <div class="box last centered">
                        <icon :title="dd.clientInfo.short_name" :icon="dd.icons.browser"></icon>
                        <div>{{dd.clientInfo.name}} {{dd.clientInfo.version}}</div>
                        <div v-if="dd.clientInfo.engine">{{dd.clientInfo.engine}} {{dd.clientInfo.engine_version}}</div>
                        <div v-if="dd.clientInfo.type!=='browser'">
                            {{dd.clientInfo.type}}
                        </div>
                        <img v-if="dd.isMobileOnlyBrowser" src="/icons/devices/smartphone.png" class="mobileonly" title="Mobile only browser">
                    </div>
                </div>
                <div class="box-row">
                    <div class="box centered" v-if="dd.deviceBrand">
                        <icon :title="dd.deviceBrand" :icon="dd.icons.brand"></icon>
                        <div>
                            {{dd.deviceBrand}} {{dd.model}}
                        </div>
                    </div>
                    <div v-if="dd.deviceName" :class="{box:true, centered:true, last:dd.deviceBrand}">
                        <icon :title="dd.deviceName" :icon="dd.icons.device"></icon>
                        <div>{{dd.deviceName}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="gotData" id="detailsBox" class="mt-2 box">
            <div :class="{collapseButton:true,open:showJSON}" :aria-expanded="showJSON"
                 @click="showJSON=!showJSON" tabindex="0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                    <path d="M6.7 15.7l5.3-5.3 5.3 5.3 1.4-1.4L12 7.6l-6.7 6.7z"/>
                </svg>
                <h3>raw data</h3>
            </div>
            <b-collapse id="collapse-1" class="collapseContent" v-model="showJSON">
                <pre class="json"><code style="text-align: left" v-html="prettyJSON"></code></pre>
            </b-collapse>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import {ParsedData} from "@/interfaces";
import Icon from "../components/Icon.vue";
import {syntaxHighlight} from "@/utils";
import {InputGroupPlugin, FormInputPlugin, ButtonPlugin} from "bootstrap-vue";

Vue.use(InputGroupPlugin);
Vue.use(FormInputPlugin);
Vue.use(ButtonPlugin);
const baseURL = "/detect/";

export default Vue.extend({
    name: "Main",
    props: {
        ua: String
    },
    components: {
        Icon
    },
    data() {
        return {
            userAgent: this.ua ? this.ua : navigator.userAgent,
            dd: {} as ParsedData,
            gotData: false,
            processingServerSide: false,
            showJSON: false,
            tooManyRequests: false,
            serverError: ""
        };
    },
    computed: {
        prettyJSON(): string {
            return syntaxHighlight(JSON.stringify(this.dd, null, 2));
        }
    },
    methods: {
        submit(): void {
            this.$router.replace({name: "main", params: {ua: this.userAgent}});
        },
        fetchData(ua: string): void {
            this.gotData = false;
            this.serverError = "";
            this.tooManyRequests = false;
            this.processingServerSide = true;
            const req = new XMLHttpRequest();
            req.onreadystatechange = (event: Event): void => {
                if (req.readyState === XMLHttpRequest.DONE) {
                    if (req.status === 200) {
                        this.dd = JSON.parse(req.responseText);
                        this.gotData = true;
                    } else if (req.status === 429) {
                        this.tooManyRequests = true;
                    } else {
                        this.serverError = req.responseText;
                    }
                    this.processingServerSide = false;

                }
            };
            req.open("GET", baseURL + "?ua=" + ua, true);
            req.send(null);
        }
    },
    watch: {
        ua(val: string): void {
            if (!val) {
                this.submit();
            } else {
                this.fetchData(val);
            }
        },
        showJSON(newValue: boolean): void {
            localStorage.showJSON = newValue;
        }
    },
    mounted(): void {
        if (this.ua) {
            this.fetchData(this.ua);
        } else {
            this.submit();
        }
        if (localStorage.showJSON) {
            this.showJSON = !!localStorage.showJSON;
        }
        document.title = "Device Detector Demo";
    }
});
</script>


<style lang="scss">
    pre {
        margin: 0;

        .string {
            color: #880000;
        }

        .number {
            color: darkorange;
        }

        .boolean {
            color: #78A960;
            font-weight: bold
        }

        .null {
            color: #999;
            font-weight: bold
        }

        .key {
            color: black;
        }
    }
    .mobileonly {
        position: absolute;
        right: 10px;
        top: 10px;
        width: 20px;
    }

    #detailsBox {
        padding: 0;

        .collapseButton {
            padding: 20px;
            cursor: pointer;
            svg {
                position: absolute;
                transform: rotate(90deg);
                transition: transform .3s;
            }

            &:hover, &:focus, &.open {
                svg {
                    transform: rotate(180deg);
                }
            }
        }

        h3 {
            text-align: center;
            margin: 0;
            font-weight: 400;
        }

    }

    .collapseContent {
        border-top: 1px solid #ddd;
        pre {
            padding: 20px;
        }
    }
</style>
