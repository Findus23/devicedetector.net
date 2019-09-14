<template>
    <div>
        <h1>Ports</h1>
        <div class="box text-center">There are already a few ports of this tool to other languages:</div>
        <div class="box-row">

            <div class="box">
                <h2>.NET</h2>
                <a href="https://github.com/totpero/DeviceDetector.NET" class="source">Source</a>
                <p>Just add DeviceDetector.NET to your projects requirements.</p>
            </div>
            <div class="box">
                <h2>Ruby</h2>
                <a href="https://github.com/podigee/device_detector" class="source">Source</a>

                <p>Add this line to your application's Gemfile:</p>

                <pre><code class="line"><span class="keyword">gem</span> <span class="string">'device_detector'</span></code></pre>

                <p>And then execute:</p>

                <pre><code>bundle</code></pre>

                <p>Or install it yourself as:</p>

                <pre><code>gem install device_detector</code></pre>
            </div>
            <div class="box">
                <h2>TypeScript/Javascript</h2>
                <a class="source" href="https://github.com/etienne-martin/device-detector-js">Source</a>
                <pre><code>npm install device-detector-js</code></pre>
            </div>
            <div class="box">
                <h2>Python 3</h2>
                <a href="https://github.com/thinkwelltwd/device_detector" class="source">Source</a>

                <pre><code>pip install device_detector</code></pre>
            </div>
            <div class="box">
                <h2>Crystal</h2>
                <a href="https://github.com/creadone/device_detector" class="source">Source</a>

                <p>Add this to your application's shard.yml:</p>
                <pre><code class="line"><span class="keyword">dependencies</span>:
        <span class="keyword">device_detector</span>:
            <span class="keyword">github</span>: creadone/device_detector</code></pre>
                <p>Then run</p>
                <pre><code>shards install</code></pre>
            </div>
        </div>
    </div>
</template>
<script lang="ts">
    import Vue from "vue";

    export default Vue.extend({
        name: "ports",
        mounted(): void {
            document.title = "Ports | Device Detector";
        }
    });
</script>


<style lang="scss" scoped>
    .box-row {
        flex-wrap: wrap;

        .box {
            min-width: 31%;
            position: relative;

            .source {
                position: absolute;
                top: 10px;
                right: 10px;
            }
        }
    }
    .text-center {
        text-align: center;
    }
</style>
