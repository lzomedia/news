<template xmlns="http://www.w3.org/1999/html">
    <!-- Page content-->
    <div class="container">

        <div class="row">

            <div class="col-lg-12">
                <form>
                    <div class="py-5">
                        <div class="spinner-border " v-if="loading" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>

                        <div v-else>

                            <div class="row">

                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="summary">
                                        <h3>Text to use when generating the video.</h3>
                                    </label>
                                    <textarea  v-html="article.content" name="" id="editor" cols="85" rows="10"></textarea>

                                    <br>
                                    <button class="btn btn-danger" @click="generateAudio(article)">Generate Audio</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="images col-lg-12">
                                    <label for="summary">
                                        <h3>Images</h3>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
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
            article: 1,
            video_text: '',

        }
    },
    methods: {
        getArticle(article) {
            this.loading = true;
            fetch('/api/v1/article/' + article)
                .then(response => response.json())
                .then(data => {
                    console.log(data.result);
                    this.loading = false;
                    this.article = data.result;
                    this.video_text = data.result.text;

                })
                .catch(error => {
                    this.loading = false;
                    console.log(error);
                });
        },
        generateAudio(article) {
            this.loading = true;
            fetch('/api/v1/generator/' + article.id + '/audio', {
                method: 'POST',
                body: JSON.stringify({
                    text: this.video_text
                })
            })
                .then(response => response.json())
                .then(data => {
                    this.loading = false;
                    console.log(data);
                })
                .catch(error => {
                    this.loading = false;
                    console.log(error);
                });
        },
    },
    mounted() {
        console.log('findFeeds.vue mounted');
        this.loading = false;
        let pathArray = window.location.pathname.split('/');
        this.article = pathArray[pathArray.length - 1];
        console.log(this.article);
        this.getArticle(this.article);

    },

}
</script>
