<template>
    <div class="py-2">
        <div v-for="(article, index) in Articles">
            <div v-if="index ===0">
                <div class="card mb-4">
                    <a href="#!">
                        <img alt="article.title" @change="selectedFile" class="card-img-top" :src="article.image"/>
                    </a>
                    <div class="card-body">
                        <div class="small text-muted">
                            <format class="text-muted" :value="article.published_at" fn="ago"/>
                        </div>
                        <h2 class="card-title">
                            <a :href="article.url">{{ article.title }}</a>
                        </h2>
                        <small>
                            <a class="badge bg-secondary text-decoration-none link-light"
                               :href="article.category.url">
                                #{{ article.category.name }}
                            </a>
                        </small>

                    </div>
                </div>
            </div>

            <div v-else>


                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img :src="article.image " class="card-img-top h-100"/>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h3 class="card-title">
                                    <a :href="article.url">{{ article.title }}</a>
                                </h3>
                                <p class="card-text">
                                    {{ article.excerpt }}
                                </p>
                                <p class="card-text">
                                    <span class="text-muted">
                                        <timeago :datetime="article.created_at"/>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <infinite-loading @distance="1" @infinite="handleLoadMore"></infinite-loading>
    </div>
</template>
<script>
console.log('HomePage');
import TimeAgo from "vue3-timeago";

export default {
    name: 'HomePage',
    components: {
        TimeAgo
    },
    data() {
        return {
            message: this.message,
            errored: false,
            Articles: [],
            Categories: [],
            page: 1,
            imageLoaded: false,
        }
    },
    methods: {
        handleLoadMore($state) {
            fetch('/api/v1/articles?page=' + this.page)
                .then(res => {
                    return res.json();
                }).then(res => {
                this.Categories = res.categories;

                $.each(res.result.data, (key, value) => {
                    this.Articles.push(value);
                });
                $state.loaded();
            });
            this.page = this.page + 1;
        },
        showArticle(article) {
            console.log(article)
        },
        imageLoadError() {
            console.log('imageLoadError')
            console.log('Image failed to load');
        },
    },
    mounted() {
        console.log("Welcome to the app!");
    }
}
</script>
<style>
.hearth:hover {
    color: red;
}
</style>
