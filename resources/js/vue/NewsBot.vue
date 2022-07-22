<template>
    <div>
       <p>
           Welcome to news bot
       </p>
    </div>
</template>
<script>
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';
console.error('Welcome to news bot');
export default {
    name: 'NewsBot',
    components: {},
    data() {
        return {

            articleId: 1,
            Articles: [],
        }
    },
    methods: {
        start() {
          console.log('start');
        },
    }
}
</script>
