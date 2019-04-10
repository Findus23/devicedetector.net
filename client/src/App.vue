<template>
  <div id="app">
    <div id="nav">
      <router-link to="/">Home</router-link> |
      <router-link to="/about">About</router-link> |
      <router-link to="/main">Main</router-link>
    </div>
    <router-view/>
    <footer>
      <div>
        using Device Detector <a :href="'https://github.com/matomo-org/device-detector/tree/'+commitHash" target="_blank">{{shortHash}}</a>
      </div>
      <div>
        last updated on {{lastUpdated.toLocaleString()}}
      </div>
    </footer>
  </div>
</template>

<script lang="ts">
  import Vue from 'vue';

  const versionJSON = 'http://local.devicedetector.net/version.json';

  export default Vue.extend({
    name: 'Main',
    data() {
      return {
        commitHash: "",
        lastUpdated: new Date()
      };
    },
    computed:{
      shortHash():string {
        return this.commitHash.substring(0,7);
      }
    },
    mounted(): void {
      const req = new XMLHttpRequest();
      req.onreadystatechange = (event: Event): void => {
        if (req.readyState === XMLHttpRequest.DONE) {
          if (req.status === 200) {
            const data = JSON.parse(req.responseText);
            console.log(data);
            this.commitHash = data.commitHash;
            this.lastUpdated = new Date(data.date);
          }
        }
      };

      req.open('GET', versionJSON , true);
      req.send(null);
    }
  });
</script>

<style lang="scss">
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
#nav {
  padding: 30px;
  a {
    font-weight: bold;
    color: #2c3e50;
    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
