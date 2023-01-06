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

                <p>Add this line to your application's <code>Gemfile</code>:</p>

                <pre><code class="line"><span class="keyword">gem</span> <span class="string">'device_detector'</span></code></pre>

                <p>And then execute:</p>

                <pre><code>bundle</code></pre>

                <p>Or install it yourself as:</p>

                <pre><code><span class="keyword">gem</span> install device_detector</code></pre>
            </div>
            <div class="box">
                <h2>TypeScript/Javascript</h2>
                <a class="source" href="https://github.com/etienne-martin/device-detector-js">Source</a>
                <pre><code><span class="keyword">npm</span> install device-detector-js</code></pre>
            </div>
            <div class="box">
                <h2>Python 3</h2>
                <a href="https://github.com/thinkwelltwd/device_detector" class="source">Source</a>

                <pre><code><span class="keyword">pip</span> install device_detector</code></pre>
            </div>
            <div class="box">
                <h2>Crystal</h2>
                <a href="https://github.com/creadone/device_detector" class="source">Source</a>

                <p>Add this to your application's <code>shard.yml</code>:</p>
                <pre><code class="line"><span class="keyword">dependencies</span>:
        <span class="keyword">device_detector</span>:
            <span class="keyword">github</span>: creadone/device_detector</code></pre>
                <p>Then run</p>
                <pre><code><span class="keyword">shards</span> install</code></pre>
            </div>
            <div class="box">
                <h2>Elixir</h2>
                <a href="https://github.com/elixir-inspector/ua_inspector" class="source">Source</a>

                <p>Add the required dependencies to your <code>mix.exs</code>:</p>
                <pre><code class="line"><span class="keyword">defp</span> <span class="command">deps</span> <span class="keyword">do</span>
  [
    <span class="comment"># ...</span>
    {<span class="command">:ua_inspector</span>, <span class="string">"~> 1.0"</span>},
    <span class="comment"># ...</span>
  ]
<span class="keyword">end</span></code></pre>
            </div>
            <div class="box">
                <h2>Go</h2>
                <a href="https://github.com/gamebtc/devicedetector" class="source">Source</a>
                <pre><code><span class="keyword">go</span> get github.com/gamebtc/devicedetector</code></pre>
            </div>
            <div class="box">
                <h2>Java</h2>
                <a href="https://github.com/mngsk/device-detector" class="source">Source</a>
                <p>Add the following dependency in your project's pom.xml:</p>
                <pre><code class="line">&lt;<span class="keyword">dependency</span>&gt;
	&lt;<span class="keyword">groupId</span>&gt;io.github.mngsk&lt;/<span class="keyword">groupId</span>&gt;
	&lt;<span class="keyword">artifactId</span>&gt;device-detector&lt;/<span class="keyword">artifactId</span>&gt;
	&lt;<span class="keyword">version</span>&gt;0.1.0&lt;/<span class="keyword">version</span>&gt;
&lt;/<span class="keyword">dependency</span>&gt;</code></pre>
            </div>
        </div>
    </div>
</template>
<script lang="ts">
import Vue, {defineComponent} from "vue";

    export default defineComponent({
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
