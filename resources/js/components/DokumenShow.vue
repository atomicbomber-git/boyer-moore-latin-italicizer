<template>
    <div
        class="card mb-3"
    >
        <div class="card-header">
            Daftar Revisi
        </div>
        
        <div
            class="card-body"
            style="max-height: 300px; overflow-y: scroll"
        >
            <table
                class="table table-sm table-striped"
            >
                <thead>
                <tr>
                    <th> #</th>
                    <th> Teks</th>
                    <th class="text-center"> Miringkan?</th>
                </tr>
                </thead>
                
                <tbody>
                
                <tr
                    v-for="(correction, key) in corrections"
                    :key="key"
                    @mouseenter="onCorrectionRowMouseEnter(correction)"
                >
                    <td> {{ key + 1 }}</td>
                    <td>
                        <button class="btn btn-info btn-sm"
                                type="button"
                                @click="onCorrectionClick(correction)"
                        >
                            {{ correction.node.textContent }}
                        </button>
                    </td>
                    <td class="text-center">
                        <div class="form-check d-inline-block">
                            <input
                                id="flexCheckChecked"
                                v-model="correction.applies"
                                class="form-check-input"
                                type="checkbox"
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
            <button
                class="btn me-2"
                :class="{ 'btn-primary': !isUpdatingDocument, 'btn-warning': isUpdatingDocument }"
                :disabled="isUpdatingDocument"
                @click="onSubmit"
            >
                <template v-if="!isUpdatingDocument">
                    Lakukan Revisi
                </template>
                
                <template v-if="isUpdatingDocument">
                    Melakukan Revisi, Harap Tunggu...
                </template>
                
                </button>
            <a
                class="btn btn-primary"
                :href="documentDownloadUrl"
            >
                Download
            </a>
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
import {computed, onMounted, ref} from "vue"

export default {
    name: "DokumenShow",
    
    props: {
        "dataSourceUrl": String,
        "reviseActionUrl": String,
        "documentDownloadUrl": String,
    },
    
    setup(props) {
        const isUpdatingDocument = ref(false)
        const document = ref(null)
        const documentFrame = ref(null)
        const corrections = ref([])
        const formData = computed(() => ({
            corrections: corrections.value.map(correction => ({
                id: correction.node.id,
                applies: correction.applies,
            }))
        }))
        
        const onSubmit = async () => {
            isUpdatingDocument.value = true
            
            try {
                let response = await axios.post(props.reviseActionUrl, formData.value)
                window.location.reload()
            } catch (e) {
                alert("Gagal memroses dokumen.")
            } finally {
                isUpdatingDocument.value = false
            }
        };
        
        const unhighlightEverything = () => {
            const contentDocument = documentFrame.value.contentDocument
            
            const nodes = contentDocument.querySelectorAll("span.highlighted")
            nodes.forEach(node => {
                node.classList.remove("highlighted")
            })
        }
        
        const onCorrectionClick = correction => {
            unhighlightEverything()
            
            correction.node.classList.add('highlighted')
            correction.node.scrollIntoView(true)
        }
        
        onMounted(async () => {
            let response = await axios.get(props.dataSourceUrl)
            document.value = response.data
        })
        
        const markDocumentParts = contentDocument => {
            let head = contentDocument.querySelector("head")
            let styleElement = contentDocument.createElement('style')
            styleElement.innerHTML = "span.marked, span.marked-done { text-decoration: underline; text-decoration-style: wavy } span.marked { text-decoration-color: darkred } span.marked-done { text-decoration-color: darkgreen } span.highlighted { background-color: yellow }"
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
        
        const onCorrectionRowMouseEnter = correction => {
            unhighlightEverything()
            correction.node.classList.add('highlighted')
        }
        
        return {
            ...props,
            isUpdatingDocument,
            document,
            documentFrame,
            onDocumentLoad,
            corrections,
            formData,
            onCorrectionClick,
            onSubmit,
            onCorrectionRowMouseEnter,
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