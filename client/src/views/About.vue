<template>
  <div class="about box" v-if="supported.operatingSystems">
    <h2>What Device Detector is able to detect</h2>

    <em>Last update: {{lastUpdated.toLocaleString()}}</em>
    <h3>List of detected operating systems:</h3>
    <p>{{ supported.operatingSystems.join(", ") }}</p>
    <h3>List of detected browsers:</h3>
    <p>{{supported.browsers.join(", ")}}</p>
    <h3>List of detected browser engines:</h3>
    <p>{{supported.engines.join(", ")}}</p>
    <h3>List of detected libraries:</h3>
    <p>{{supported.libraries.join(", ")}}</p>
    <h3>List of detected media players:</h3>
    <p>{{supported.mediaPlayer.join(", ")}}</p>
    <h3>List of detected mobile apps:</h3>
    <p>{{supported.mobileApps.join(", ")}}</p>
    <h3>List of detected PIMs (personal information manager):</h3>
    <p>{{supported.PIM.join(", ")}}</p>
    <h3>List of detected feed readers:</h3>
    <p>{{supported.feedReaders.join(", ")}}</p>
    <h3>List of brands with detected devices:</h3>
    <p>{{supported.brands.join(", ")}}</p>
    <h3>List of detected bots:</h3>
    <p>{{supported.bots.join(", ")}}</p>
  </div>
</template>

<script lang="ts">
import Vue from "vue";
import {SupportedList} from "@/interfaces";

const supportedURL = "/supported/";

export default Vue.extend({
  name: "about",
  props: ["lastUpdated"],
  data() {
    return {
      supported: {} as SupportedList
    };
  },
  mounted(): void {
    const req = new XMLHttpRequest();
    req.onreadystatechange = (event: Event): void => {
      if (req.readyState === XMLHttpRequest.DONE) {
        if (req.status === 200) {
          this.supported = JSON.parse(req.responseText);
        }
      }
    };

    req.open("GET", supportedURL, true);
    req.send(null);
  }

});
</script>
