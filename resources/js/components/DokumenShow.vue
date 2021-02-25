<template>
  <div class="card mb-3">
    <div class="card-header">
      Daftar Revisi
    </div>

    <div class="card-body">


    </div>
  </div>


  <div class="card" v-if="document">
    <div class="card-header">
      {{ document.nama }}
    </div>

    <div class="card-body">
      <iframe
          id="iframe"
          :srcdoc="document.html"
          class="document"
      ></iframe>
    </div>
  </div>
</template>

<script>

import axios from "axios"

export default {
  name: "DokumenShow",

  props: {
    "dataSourceUrl": String,
    "reviseActionUrl": String,
  },

  data() {
    return {
      document: null,
      corrections: [],
    }
  },

  methods: {
    loadStyles: function () {
      window.setTimeout(() => {
        let iframe = document.getElementById("iframe")
        let head = iframe.contentDocument.getElementsByTagName("head")[0]

        let styleElement = iframe.contentDocument.createElement('style')
        styleElement.innerHTML = "span.marked { text-decoration: underline; text-decoration-color: red; text-decoration-style: wavy }"

        head.appendChild(styleElement)
      }, 500)
    },
  },

  watch: {
    "document.html": function (newDocumentHtml) {
        if (newDocumentHtml === null) {
          return
        }

        this.loadStyles();
    }
  },

  mounted() {
    axios.get(this.dataSourceUrl)
        .then(response => {
          this.document = response.data
        })
  }
}
</script>

<style scoped>
span.marked {
  text-decoration: underline;
  text-decoration-color: red;
  text-decoration-style: wavy;
}

iframe.document {
  width: 100%;
  height: 640px;
  overflow-y: scroll;
}
</style>