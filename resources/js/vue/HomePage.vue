<template>
    <div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                        type="button" role="tab" aria-controls="nav-home" aria-selected="true">Latest
                </button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                        type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Top
                </button>

            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="py-2">
                    <div v-for="(article, index) in Articles">
                        <div v-if="index ===0">
                            <div class="card mb-4">
                                <a href="#!"><img class="card-img-top" :src="article.image"/></a>
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
                                        <img :src="article.image" class="card-img-top h-100"/>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h3 class="card-title">
                                                <a :href="article.url">{{ article.title }}</a>
                                            </h3>
                                            <p class="card-text">
                                                {{ article.excerpt }}
                                            </p>
                                            <p class="card-text"><small class="text-muted">
                                                <format class="text-muted" :value="article.published_at" fn="ago"/>
                                            </small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <infinite-loading @distance="1" @infinite="handleLoadMore"></infinite-loading>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                To add Top here
            </div>
        </div>

    </div>
</template>
<script>
console.log('HomePage');
export default {
    name: 'HomePage',
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
        }
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
