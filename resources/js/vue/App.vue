<template>
    <div class="container">
        <div class="row">
            <aside class="col-lg-3">
                <h3>
                    Category
                </h3>
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" v-for="category in categories">
                            <a v-on:click="setCategory(category.id)">{{ category.name }}</a>
                        </li>
                    </ul>
                </div>
            </aside>

            <div class="col-lg-6 ">
                <h3>
                    Latest News.
                </h3>
                <article class="card mb-3" v-for="article in articles">

                    <img class="card-img-top"  :src="article.image" @error="imageLoadError" alt="Card image cap">

                    <div class="card-body">
                        <h5 class="card-title">
                            {{article.title}}
                        </h5>
                        <p class="card-text">
                            <format class="text-muted" :value="article.published_at" fn="ago" />
                        </p>
                    </div>

                </article>

                <InfiniteLoading @infinite="handleLoadMore" />

            </div>

            <aside class="col-lg-3">
                <h3>
                    Tags
                </h3>
                <div class="card">

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" v-for="category in categories">
                            <a v-on:click="setCategory(category.id)">{{ category.name }}</a>
                        </li>
                    </ul>
                </div>

            </aside>

        </div>
    </div>



</template>
<script>
console.log('App.vue');
export default {
    name: 'App',
    data() {
        return {
            message: this.message,
            errored: false,
            articles: [],
            categories: [],
            filterCategories: [],
            page: 1,
            query: {
                limit: 10,
                page: 1
            },
        }
    },
    methods: {
        handleLoadMore() {

            console.log('handleLoadMore');
            axios
                .get('/v1/articles?page=' + this.page + '&category=' + this.filterCategories)
                .then(response => {
                    this.page++;
                    this.articles = this.articles.concat(response.data.articles);
                    this.categories = response.data.categories;

                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
                .finally(() => {

                })


        },
        showArticle(article) {
            console.log(article)
        },
        setCategory(category) {
            this.filterCategories.push(category);
            console.log(category)
        },
        imageLoadError () {
            console.log('imageLoadError')
            console.log('Image failed to load');
        }
    },
    mounted() {
        console.log("Welcome to the Home Page");
        this.handleLoadMore(this.$refs.infiniteLoading);
    }
}
</script>
<style>
.hearth::hover{
    color: red;
}
</style>
