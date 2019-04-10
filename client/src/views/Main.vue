<template>
    <div class="main">
        <h1>Main</h1>
        <form @submit.prevent="submit">
            <input type="text" v-model="userAgent" :disabled="processingServerSide">
            <input type="submit" :disabled="processingServerSide">
        </form>
        <div v-if="gotData">
            <div v-if="!parsedData.clientInfo">
                Device Detecter couldn't detect any information about this user agent.
            </div>
            <div v-if="parsedData.isBot">
                <a :href="parsedData.botInfo.url">{{parsedData.botInfo.name}}</a>
                <span>{{parsedData.botInfo.category}}</span>
                <a :href="parsedData.botInfo.producer.url">{{parsedData.botInfo.producer.name}}</a>
            </div>
            <div v-else>
                <img v-if="parsedData.browserIcon" :src="'http://local.devicedetector.net'+parsedData.browserIcon" :title="parsedData.clientInfo.short_name" role="presentation">
            </div>
        </div>
        <pre style="text-align: left">{{prettyJSON}}</pre>
    </div>
</template>

<script lang="ts">
    import Vue from "vue";
    import {ParsedData} from "@/interfaces";

    const baseURL = "http://local.devicedetector.net/detect/";

    export default Vue.extend({
        name: "Main",
        props: {
            msg: String
        },
        data() {
            return {
                userAgent: navigator.userAgent,
                parsedData: {} as ParsedData,
                gotData: false,
                processingServerSide:false,
            };
        },
        computed: {
            prettyJSON(): string {
                return JSON.stringify(this.parsedData, null, 2);
            }
        },
        methods: {
            submit(): void {
                this.gotData = false;
                this.processingServerSide = true;
                const req = new XMLHttpRequest();
                req.onreadystatechange = (event: Event): void => {
                    if (req.readyState === XMLHttpRequest.DONE) {
                        if (req.status === 200) {
                            this.parsedData = JSON.parse(req.responseText);
                            this.gotData = true;
                            this.processingServerSide=false;
                        }
                    }
                };
                req.open("GET", baseURL + "?ua=" + this.userAgent, true);
                req.send(null);
            }
        }
    });
</script>
