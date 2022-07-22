
//
import {createApp} from 'vue';
import NewsBot from "./vue/NewsBot";
import InfiniteLoading from "v3-infinite-loading";
import "v3-infinite-loading/lib/style.css"; //required if you're not going to override default slots

const app = createApp(NewsBot);

app.component("infinite-loading", InfiniteLoading);
app.mount('#news-bot');


