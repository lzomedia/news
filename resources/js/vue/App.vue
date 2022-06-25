<template>


    <!-- Page content-->
    <div class="container">
        <div class="row">
            <!-- Blog entries-->
            <div class="col-lg-8">


                <div v-for="(article, index) in articles">
                    <div v-if="index ===0">
                        <div class="card mb-4">
                            <a href="#!"><img class="card-img-top" :src="article.image" /></a>
                            <div class="card-body">
                                <div class="small text-muted">
                                    <format class="text-muted" :value="article.published_at" fn="ago" />
                                </div>
                                <h2 class="card-title">
                                    <a :href="article.url">{{ article.title }}</a>
                                </h2>

                            </div>
                        </div>
                    </div>

                    <div v-else class="row">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="small text-muted">
                                    <format class="text-muted" :value="article.published_at" fn="ago" />
                                </div>
                                <h3 class="card-title">
                                    <a :href="article.url">{{ article.title }}</a>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Side widgets-->
            <div class="col-lg-4 sticky-top">
                <!-- Search widget-->
                <div class="card mb-4">
                    <div class="card-header">Search</div>
                    <div class="card-body">
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                            <button class="btn btn-primary" id="button-search" type="button">Go!</button>
                        </div>
                    </div>
                </div>
                <!-- Categories widget-->
                <div class="card mb-4">
                    <div class="card-header">Categories</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="list-unstyled mb-0">
                                    <li  v-for="category in categories">
                                        <a class="text-left" v-on:click="setCategory(category.id)">{{ category.name }}</a>
                                        <span class="float-end">
                                   ({{ category.count }})
                                </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Side widget-->
                <div class="card mb-4">
                    <div class="card-header">Side Widget</div>
                    <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
                </div>
            </div>
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
                .get('api/v1/articles?page=' + this.page + '&category=' + this.filterCategories)
                .then(response => {

                    this.articles =this.articles.concat(response.data.data);
                    this.page++;
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
                .finally(() => {

                })


        },
        getCategories() {
            axios
                .get('api/v1/categories')
                .then(response => {
                    this.categories = this.categories.concat(response.data);
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
        this.getCategories();
    }
}
</script>
<style>
.hearth::hover{
    color: red;
}
</style>
