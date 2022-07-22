<template>
    <div class="col-lg-12">
        <div>
            <h3>
                Related Articles
            </h3>
        </div>
    </div>

    <div class="col-lg-12 d-xs-none">
        <carousel :items-to-show="4">
            <slide v-for="slide in Articles" :key="slide">
                <div class="col-lg-10">
                    <div class="card-body">
                        <a :href="slide.url" class="card-text">
                            {{slide.title}}
                        </a>
                    </div>
                </div>
            </slide>
        </carousel>
    </div>



</template>
<script>
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';
console.log(window.articleID);
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
            articleID:  window.articleID,
            Articles: [],
        }
    },
    methods: {
        getArticles() {

            console.log('getArticles');

            fetch('/api/v1/articles/related/' + this.articleID)
                .then(res => {
                    return res.json();
                }).then(res => {
                    this.Articles = res.result.data;
                    console.log(res);
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
