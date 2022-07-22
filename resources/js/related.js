import {createApp} from 'vue';
import Related from './vue/Related.vue';
import InfiniteLoading from "v3-infinite-loading";
import "v3-infinite-loading/lib/style.css"; //required if you're not going to override default slots


const app = createApp(Related);

app.component("infinite-loading", InfiniteLoading);
app._props = {
   title: String,
}
app.mount('#related-articles');



