<template>
    <div class="mb-5">
        <div class="col-md-8 mx-auto">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">
                    Enter Url Address
                </label>
                <input v-model="url" type="url" class="form-control" id="exampleFormControlInput1" placeholder="https://">
            </div>
            <div class="mb-3">
                <button @click="getContent" class="btn btn-primary">Get News</button>
            </div>
        </div>

        <div class="col-md-8 mx-auto">
            <div class="spinner-border " v-if="loading" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div v-else>
                <pre>{{ content }}</pre>
            </div>
        </div>

    </div>

</template>
<script>

export default {
    data() {
        return {
            url: 'https://www.bbc.co.uk/news/62261164',
            loading : false,
            content : '',
        }
    },
    methods: {
        getContent() {
            this.loading = true;
            const requestOptions = {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ url: this.url })
            };
            console.log(JSON.stringify(this.url));

            fetch('/api/v1/bot', requestOptions)
                .then(res => {
                    return res.json();
                }).then(res => {
                this.loading = false;
                this.content = res.result;
            }).catch(error => {
                this.loading = false;
            });

        },
    }
}
</script>
