<template>
    <div class="about box">
        <h1>Contributing</h1>
        <h2>Hacking the library</h2>

        <p>This is a free/libre library under license LGPL v3 or later.</p>

        <p>Your pull requests and/or feedback is very welcome!</p>

        <h2>Improvements</h2>

        <p>You have a User Agent that is not detected or detected incorrectly? Then please <a href="https://github.com/matomo-org/device-detector">open an issue on the Device Detector repostiory.</a></p>

        <p>You have seen an incorrect/missing/ugly icon? Then please report it <a href="https://github.com/matomo-org/matomo-icons">on the matomo-icons repository</a>.</p>

        <h2>Listing all user agents from your logs</h2>

        <p>
            Sometimes it may be useful to generate the list of most used user agents on your website, extracting this
            list from your access logs using the following command:
        </p>

        <pre><code><span class="keyword">zcat</span> <span class="path">~/path/to/access/logs*</span> | <span
                class="keyword">awk</span> -F'<span class="string">"</span>' '<span class="string">{print $6}</span>' | <span
                class="keyword">sort</span> | <span class="keyword">uniq</span> -c | <span class="keyword">sort</span> -rn | <span
                class="keyword">head</span> -n20000 > top-user-agents.txt</code></pre>

        <h2>Contributors</h2>

        <p>Created by the <a href="https://matomo.org/team/">Matomo team</a>, Stefan Giehl, Matthieu Aubry, Michał
            Gaździk, Tomasz Majczak, Grzegorz Kaszuba, Piotr Banaszczyk and
            <a href="https://github.com/matomo-org/device-detector/graphs/contributors">contributors</a>.
        </p>

        <p>Together we can build the best Device Detection library.</p>

        <p>We are looking forward to your contributions and pull requests!</p>
    </div>
</template>
<script lang="ts">
import Vue from "vue";

export default Vue.extend({
    name: "contribute"
});
</script>


<style lang="scss" scoped>
    pre {
        background: #31363b;
        color: #eff0f1;
        padding: 10px;

        code {
            &::before {
                content: "➜ ";
                color: #1cdc9a;
            }

            .keyword {
                color: #1cdc9a;
            }

            .path {
                color: #3daee9;
            }

            .string {
                color: #f67400;
            }
        }
    }

</style>
