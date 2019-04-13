<template>
    <div class="main">
        <h1>Main</h1>
        <form @submit.prevent="submit">
            <b-form-input type="text" v-model="userAgent" :disabled="processingServerSide"></b-form-input>
            <b-button type="submit" variant="primary" :disabled="processingServerSide">Detect!</b-button>
        </form>
        <div v-if="gotData">
            <div v-if="!dd.clientInfo && !dd.botInfo" class="box">
                Device Detecter couldn't detect any information about this user agent.
            </div>
            <div v-if="dd.isBot" class="box">
                <a :href="dd.botInfo.url">{{dd.botInfo.name}}</a>
                <span>{{dd.botInfo.category}}</span>
                <a :href="dd.botInfo.producer.url">{{dd.botInfo.producer.name}}</a>
            </div>
            <div v-else>
                <b-row>
                    <b-col class="box">
                        <div v-if="dd.osInfo">
                            <icon :title="dd.osInfo.short_name" :icon="dd.osIcon"></icon>
                            <div>{{dd.osInfo.name}} {{dd.osInfo.version}}</div>
                            <div>{{dd.osInfo.platform}}</div>
                        </div>
                    </b-col>
                    <b-col class="box last">
                        <icon :title="dd.clientInfo.short_name" :icon="dd.browserIcon"></icon>
                        <div>{{dd.clientInfo.name}} {{dd.clientInfo.version}}</div>
                        <div v-if="dd.clientInfo.engine">{{dd.clientInfo.engine}} {{dd.clientInfo.engine_version}}</div>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col class="box" v-if="dd.deviceBrand">
                        <icon :title="dd.deviceBrand" :icon="dd.brandIcon"></icon>
                        <div>
                            {{dd.deviceBrand}}
                        </div>
                    </b-col>
                    <b-col :class="{box:true, last:dd.deviceBrand}">
                        <icon :title="dd.deviceName" :icon="dd.deviceIcon"></icon>
                        <div>{{dd.deviceName}}</div>
                    </b-col>
                </b-row>
            </div>
        </div>
        <div v-if="gotData">
            <b-button v-b-toggle.collapse-1 variant="primary">Toggle Collapse</b-button>
            <b-collapse id="collapse-1" class="mt-2 box">
                <pre><code style="text-align: left">{{prettyJSON}}</code></pre>
            </b-collapse>
        </div>
    </div>
</template>

<script lang="ts">
    import Vue from "vue";
    import {ParsedData} from "@/interfaces";
    import Icon from "./Icon.vue";

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
                processingServerSide: false
            };
        },
        computed: {
            prettyJSON(): string {
                return JSON.stringify(this.dd, null, 2);
            }
        },
        methods: {
            submit(): void {
                this.$router.replace({name: "main", params: {"ua": this.userAgent}});
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
            }
        },
        mounted(): void {
            if (this.ua) {
                this.fetchData(this.ua);
            } else {
                this.submit();
            }
        }
    });
</script>


<style lang="scss">
    pre {
        margin: 0;
    }
</style>
