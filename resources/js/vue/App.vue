<template>


    <!-- Page content-->
    <div class="container">
        <div class="row">
            <!-- Articles Entries-->
            <div class="col-lg-8">

                <div v-for="(article, index) in Articles">
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

                <infinite-loading @distance="1" @infinite="handleLoadMore"></infinite-loading>
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
                                    <li>
                                        <a class="text-left">
                                            @todo implement category
                                        </a>
                                        <span class="float-end">
                                           (0)
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
            Articles: [],
            Categories: [],
            page: 1,
        }
    },
    methods: {
        handleLoadMore($state) {
           fetch('/api/v1/articles?page=' + this.page)
                .then(res => {
                    return res.json();
                }).then(res => {
                    $.each(res.data, (key, value) => {
                        this.Articles.push(value);
                    });
                    $state.loaded();
            });
            this.page = this.page + 1;
        },
        showArticle(article) {
            console.log(article)
        },
        imageLoadError () {
            console.log('imageLoadError')
            console.log('Image failed to load');
        }
    },
}
</script>
<style>
.hearth::hover{
    color: red;
}
</style>
