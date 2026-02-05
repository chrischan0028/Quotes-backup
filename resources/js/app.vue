<template>
  <div>
    <h1>Single Quote By ID (Please remember to clear the cache before searching.)</h1>

    <input v-model="quoteId" placeholder="Enter ID" />
    <button @click="fetchQuote">Get Quote</button>
    <p v-if="singleQuote">{{ singleQuote.id }}: {{ singleQuote.quote }}</p>
  </div>
  <div>
    <h1>Quotes List</h1>

    <ul>
      <li v-for="quote in quotes" :key="quote.id">
        {{ quote.id }}: {{ quote.quote }} - {{ quote.author }}
      </li>
    </ul>

    <button @click="prevPage" :disabled="page <= 1">Prev</button>
    <button @click="nextPage" :disabled="page >= totalPages">Next</button>
    <p>Page {{ page }} of {{ totalPages }}</p>
  </div>
</template>

<script lang="ts" setup>
import { ref, watch } from 'vue'

const quotes = ref([])
const page = ref(1)
const perPage = 5
const total = ref(0)
const totalPages = ref(1)

const fetchQuotes = async () => {
    const res = await fetch(`/api/quotes?page=${page.value}&per_page=${perPage}`)
    const data = await res.json()
    quotes.value = data.data
    total.value = data.total
    totalPages.value = Math.ceil(total.value / perPage)
}

watch(page, fetchQuotes)
fetchQuotes()

const nextPage = () => {
    if (page.value < totalPages.value) page.value++
}

const prevPage = () => {
    if (page.value > 1) page.value--
}

const quoteId = ref('')
const singleQuote = ref(null)

const fetchQuote = async () => {
    if (!quoteId.value) return
    const res = await fetch(`/api/quotes/${quoteId.value}`)
    if (res.status === 404) {
        singleQuote.value = null
        alert('Quote not found')
    } else {
        singleQuote.value = await res.json()
        fetchQuotes()
    }
}
</script>