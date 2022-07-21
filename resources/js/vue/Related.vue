<template>
    <div>
        <carousel :items-to-show="2.5">
            <slide v-for="slide in 10" :key="slide">
                <div class="card mr-2 ml-2">
                    <div class="card-body">
                        <h5 class="card-title">
                           Title
                        </h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </slide>
        </carousel>
    </div>
</template>
<script>
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';
console.error('Welcome to related');
export default {
    name: 'Related',
    components: {
        Carousel,
        Slide,
        Pagination,
        Navigation,
    },
    data() {
        return {

            articleId: 1,
            Articles: [],
        }
    },
    methods: {
        getArticles() {
            fetch('/api/v1/articles/related/' + this.articleId)
                .then(res => {
                    return res.json();
                }).then(res => {
                    this.Articles = [];
                })  .catch(error => {
                    console.error('There was an error!', error);
                });
        },
    }
}
</script>
