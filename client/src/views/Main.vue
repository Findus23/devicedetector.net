<template>
    <div class="main">
        <h1>Main</h1>
        <form @submit.prevent="submit">
            <input type="text" v-model="userAgent">
            <input type="submit">
        </form>
        <pre style="text-align: left">{{prettyJSON}}</pre>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';

    const baseURL = 'http://localhost/devicedetector.net/api.php';

    export default Vue.extend({
        name: 'Main',
        props: {
            msg: String
        },
        data() {
            return {
                userAgent: navigator.userAgent,
                parsedData: {}
            };
        },
        computed: {
            // need annotation
            prettyJSON(): string {
                return JSON.stringify(this.parsedData, null, 2);
            }
        },
        methods: {
            submit(): void {
                const req = new XMLHttpRequest();
                req.onreadystatechange = (event: Event): void => {
                    if (req.readyState === XMLHttpRequest.DONE) {
                        if (req.status === 200) {
                            this.parsedData = JSON.parse(req.responseText);
                        }
                    }
                };

                req.open('GET', baseURL + '?ua=' + this.userAgent, true);
                req.send(null);
            }
        }
    });
</script>
