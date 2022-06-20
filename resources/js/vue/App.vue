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

                <article class="card p-2" v-for="article in articles">

                    <img class="card-img-top"  :src="article.image" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{article.title}}
                        </h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>


                </article>

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
        handleLoadMore($state) {

            axios
                .get('v1/articles?page=' + this.page + '&category=' + this.filterCategories)
                .then(response => {

                    this.articles = this.articles.concat(response.data.articles);
                    this.categories = response.data.categories;
                    this.page++;
                    $state.loaded();
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
                .finally(() => {
                    $state.loaded()
                })

        },
        showArticle(article) {
            console.log(article)
        },
        setCategory(category) {
            this.filterCategories.push(category);
            console.log(category)
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
