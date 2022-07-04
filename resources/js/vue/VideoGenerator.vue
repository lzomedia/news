<template xmlns="http://www.w3.org/1999/html">
    <!-- Page content-->
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="py-5">
                    <div class="spinner-border " v-if="loading" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>

                    <div v-else>
                        Welcome to the Video Generator.
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<script>


console.log('findFeeds.vue');
export default {
    name: 'VideoGenerator',
    data() {
        return {
            loading: true,
            article: 1
        }
    },
    methods: {
        getArticle(article) {
            this.loading = true;
            fetch('/api/v1/article/' + article)
                .then(response => response.json())
                .then(data => {
                    this.loading = false;
                    this.article = data;
                })
                .catch(error => {
                    this.loading = false;
                    console.log(error);
                });
        }
    },
    mounted()
    {
        console.log('findFeeds.vue mounted');
        this.loading = false;
        let pathArray = window.location.pathname.split('/');
        this.article = pathArray[pathArray.length - 1];
        console.log(this.article);

        this.getArticle(this.article);


    },

}
</script>
