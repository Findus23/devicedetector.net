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
        <div v-if="gotData">
            <div v-if="!dd.clientInfo && !dd.botInfo" class="box centered">
                Device Detecter couldn't detect any information about this user agent.
            </div>
            <div v-else-if="dd.isBot" class="box centered">
                <div><a :href="dd.botInfo.url">{{dd.botInfo.name}}</a></div>
                <div>{{dd.botInfo.category}}</div>
                <div><a :href="dd.botInfo.producer.url">{{dd.botInfo.producer.name}}</a></div>
            </div>
            <div v-else>
                <div class="box-row">
                    <div class="box centered">
                        <div v-if="dd.osInfo">
                            <icon :title="dd.osInfo.short_name" :icon="dd.icons.os"></icon>
                            <div>{{dd.osInfo.name}} {{dd.osInfo.version}}</div>
                            <div>{{dd.osInfo.platform}}</div>
                        </div>
                    </div>
                    <div class="box last centered">
                        <icon :title="dd.clientInfo.short_name" :icon="dd.icons.browser"></icon>
                        <div>{{dd.clientInfo.name}} {{dd.clientInfo.version}}</div>
                        <div v-if="dd.clientInfo.engine">{{dd.clientInfo.engine}} {{dd.clientInfo.engine_version}}</div>
                    </div>
                </div>
                <div class="box-row">
                    <div class="box centered" v-if="dd.deviceBrand">
                        <icon :title="dd.deviceBrand" :icon="dd.icons.brand"></icon>
                        <div>
                            {{dd.deviceBrand}}
                        </div>
                    </div>
                    <div :class="{box:true, centered:true, last:dd.deviceBrand}">
                        <icon :title="dd.deviceName" :icon="dd.icons.device"></icon>
                        <div>{{dd.deviceName}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="gotData">
            <b-button variant="primary" :aria-expanded="showJSON ? true : false"
                      @click="showJSON=!showJSON">
                Show Device Detector response
            </b-button>
            <b-collapse id="collapse-1" class="mt-2 box" v-model="showJSON">
                <pre><code style="text-align: left" v-html="prettyJSON"></code></pre>
            </b-collapse>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import {ParsedData} from "@/interfaces";
import Icon from "../components/Icon.vue";
import {syntaxHighlight} from "../../utils";
// @ts-ignore
import InputGroup from "bootstrap-vue/es/components/input-group";
// @ts-ignore
import FormInput from "bootstrap-vue/es/components/form-input";
// @ts-ignore
import Button from "bootstrap-vue/es/components/button";
Vue.use(InputGroup);
Vue.use(FormInput);
Vue.use(Button);
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
            showJSON: false
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
            this.processingServerSide = true;
            const req = new XMLHttpRequest();
            req.onreadystatechange = (event: Event): void => {
                if (req.readyState === XMLHttpRequest.DONE) {
                    if (req.status === 200) {
                        this.dd = JSON.parse(req.responseText);
                        this.gotData = true;
                        this.processingServerSide = false;
                    }
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
</style>
