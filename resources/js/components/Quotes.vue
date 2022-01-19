<template>
    <div
        class="p-5 bg-white border shadow"
        style="position:fixed; width: 250px; right:40px"
    >
        <h4 class="mb-2">Quote's Today</h4>
        <hr />

        <div class="p-2" v-for="quote in quotes.data" :key="quote.id">
            <p>
                <strong>{{ quote.quoteAuthor }}</strong>
            </p>
            <small>
                <blockquote>
                    <i class="fas fa-quote-left mr-2"></i> {{ quote.quoteText }}
                </blockquote>
            </small>

        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            quotes: []
        };
    },

    mounted() {
        this.quotes_api();
    },

    methods: {
        quotes_api() {
            axios
                .get("https://quote-garden.herokuapp.com/api/v3/quotes?limit=1")
                .then(response => {
                    this.quotes = response.data;
                });
        }
    }
};
</script>
