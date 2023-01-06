<template>
  <div>
    <div v-if="tooManyRequests" class="box centered">
      There were too many requests. Please wait a minute before reloading the website.
    </div>
    <div class="about box" v-if="supported.operatingSystems">
      <h1>What Device Detector is able to detect</h1>

      <em>Last update: {{lastUpdated.toLocaleString()}}</em>
      <h3>List of {{supported.operatingSystems.length}} detected operating systems:</h3>
      <p>{{ supported.operatingSystems.join(", ") }}</p>
      <h3>List of {{supported.browsers.length}} detected browsers:</h3>
      <p>{{supported.browsers.join(", ")}}</p>
      <h3>List of {{supported.engines.length}} detected browser engines:</h3>
      <p>{{supported.engines.join(", ")}}</p>
      <h3>List of {{supported.libraries.length}} detected libraries:</h3>
      <p>{{supported.libraries.join(", ")}}</p>
      <h3>List of {{supported.mediaPlayer.length}} detected media players:</h3>
      <p>{{supported.mediaPlayer.join(", ")}}</p>
      <h3>List of {{supported.mobileApps.length}} detected mobile apps:</h3>
      <p>{{supported.mobileApps.join(", ")}}</p>
      <h3>List of {{supported.PIM.length}} detected PIMs (personal information manager):</h3>
      <p>{{supported.PIM.join(", ")}}</p>
      <h3>List of {{supported.feedReaders.length}} detected feed readers:</h3>
      <p>{{supported.feedReaders.join(", ")}}</p>
      <h3>List of the {{supported.brands.length}} brands with detected devices:</h3>
      <p>{{supported.brands.join(", ")}}</p>
      <h3>List of {{supported.bots.length}} detected bots:</h3>
      <p>{{supported.bots.join(", ")}}</p>
    </div>
  </div>
</template>

<script lang="ts">
import Vue, {defineComponent} from "vue";
import {SupportedList} from "../interfaces";

const supportedURL = "/supported/";

export default defineComponent({
  name: "about",
  props: ["lastUpdated"],
  data() {
    return {
      supported: {} as SupportedList,
      tooManyRequests: false
    };
  },
  mounted(): void {
    document.title = "Detected Devices | Device Detector";
    const req = new XMLHttpRequest();
    req.onreadystatechange = (event: Event): void => {
      if (req.readyState === XMLHttpRequest.DONE) {
        if (req.status === 200) {
          this.supported = JSON.parse(req.responseText);
        } else if (req.status === 429) {
          this.tooManyRequests = true;
        }
      }
    };

    req.open("GET", supportedURL, true);
    req.send(null);
  }

});
</script>
