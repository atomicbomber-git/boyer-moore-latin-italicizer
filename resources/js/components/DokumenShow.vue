<template>
  <div class="card mb-3">
    <div class="card-header">
      Daftar Revisi
    </div>

    <div class="card-body">
      <table class="table table-sm table-striped">
        <thead>
        <tr>
          <th> # </th>
          <th> Teks </th>
          <th class="text-center"> Miringkan? </th>
        </tr>
        </thead>

        <tbody>

        <tr
            v-for="(correction, key) in corrections"
            :key="key"
        >
          <td> {{ key + 1 }}</td>
          <td> {{ correction.node.textContent }}</td>
          <td class="d-flex justify-content-center">
            <div class="form-check">
              <input
                  id="flexCheckChecked"
                  class="form-check-input"
                  type="checkbox"
                  v-model="correction.applies"
              >
              <label class="form-check-label sr-only"
                     for="flexCheckChecked"
              >
                Lakukan Koreksi Untuk {{ correction.node.textContent }}, item ke {{ key + 1 }}
              </label>
            </div>

          </td>
        </tr>
        </tbody>
      </table>
    </div>

    <div class="card-footer d-flex justify-content-end">
      <button @click="onSubmit" class="btn btn-primary">
        Lakukan Revisi
      </button>
    </div>
  </div>


  <div v-if="document"
       class="card"
  >
    <div class="card-header">
      {{ document.nama }}
    </div>

    <div class="card-body">
      <iframe
          id="documentFrame"
          ref="documentFrame"
          :srcdoc="document.html"
          class="document"
          @load="onDocumentLoad"
      ></iframe>
    </div>
  </div>
</template>

<script>

import axios from "axios"
import {onMounted, ref, computed} from "vue"

export default {
  name: "DokumenShow",

  props: {
    "dataSourceUrl": String,
    "reviseActionUrl": String,
  },

  setup(props) {
    const document = ref(null)
    const documentFrame = ref(null)
    const corrections = ref([])
    const formData = computed(() => corrections.value.map(correction => ({
      id: correction.node.id,
    })))

    const onSubmit = () => {
      // TODO Implement this thing
    };

    onMounted(async () => {
      let response = await axios.get(props.dataSourceUrl)
      document.value = response.data
    })

    const markDocumentParts = contentDocument => {
      let head = contentDocument.querySelector("head")
      let styleElement = contentDocument.createElement('style')
      styleElement.innerHTML = "span.marked, span.marked-done { text-decoration: underline; text-decoration-color: red; text-decoration-style: wavy }"
      head.appendChild(styleElement)
    }

    const onDocumentLoad = e => {
      markDocumentParts(e.target.contentDocument)

      let contentDocument = e.target.contentDocument
      contentDocument.querySelectorAll("span.marked-done, span.marked").forEach(elem => {
        corrections.value.push({
          node: elem,
          applies: true,
        })
      })
    }

    return {
      document,
      documentFrame,
      onDocumentLoad,
      corrections,
      formData,
      onSubmit,
    }
  }
}
</script>

<style scoped>

iframe.document {
  width: 100%;
  height: 640px;
  overflow-y: scroll;
}

</style>