<template>
    <div class="col-lg-12">
        <div>
            <h3>
                Related Articles
            </h3>
        </div>
    </div>


    <div class="col-lg-12">
        <div class="card-group">
            <div v-for="article in Articles" class="card">
            <img :src="article.image" class="card-img-top" alt="{{ article.title }}">
            <div class="card-body">
                <h5 class="card-title">
                    <a :href="article.url">
                        {{ article.title }}
                    </a>
                </h5>
            </div>
        </div>
        </div>
    </div>



</template>
<script>
console.log(window.articleID);
export default {
    name: 'Related',
    data() {
        return {
            articleID:  window.articleID,
            Articles: [],
        }
    },
    methods: {
        getArticles() {
            fetch('/api/v1/articles/related/' + this.articleID)
                .then(res => {
                    return res.json();
                }).then(res => {
                    this.Articles = res.result.data;
            })  .catch(error => {
                console.error('There was an error!', error);
            });

        },
    },
    mounted() {
        this.getArticles();
    },
}
</script>
