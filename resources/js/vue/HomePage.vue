<template>
    <div>
        <div v-for="(article, index) in Articles">
            <div v-if="index ===0">
                <div style="border-top:0;" class="card mb-4">
                    <a :href="article.url">
                        <img alt="article.title" class="card-img-top" :src="article.image"/>
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
                                <a  v-for="(tag, index) in article.tags" class="badge me-2 bg-secondary text-decoration-none link-light" title="articles about" :href="'articles/'+ tag.name "> #{{ tag.name }}</a>

                                <h5 class="card-text mt-2">
                                    <small>
                                        <i>
                                            Time to read -  {{ article.reactions.timeToRead }} minutes
                                        </i>
                                    </small>
                                </h5>

                                <h6 class="card-text mt-2 h6">
                                  <i style="font-size: 3rem" :class="getReactionSentimentCssClass(article.reactions.vader)"></i>
                                </h6>
                                <p class="card-text">
                                    <small class="text-muted">
                                        <format class="text-muted" :value="article.published_at" fn="ago"/>
                                    </small>
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
            Tags: [],
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
                console.log(this.tags);

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
        getReactionSentimentCssClass(reaction) {

            try {
                let jsonCompound = JSON.parse(reaction);
                console.log(jsonCompound);
                if(jsonCompound.compound > "0.50") {
                    return 'ri-emotion-happy-line';
                } else {
                    return 'ri-emotion-unhappy-line';
                }
            }
            catch(err) {
                return "Negative"
            }

        },
    },
    mounted() {
        console.log("Welcome to the app!");
    },
    filters: {
    },
}
</script>
<style>
.hearth:hover {
    color: red;
}
.ri-emotion-happy-line {
    font-size: 3rem;
    color: green;
}
.ri-emotion-unhappy-line {
    font-size: 3rem;
    color: red;
}
</style>
