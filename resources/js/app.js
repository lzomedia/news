require('./bootstrap');
//
require('alpinejs');

import {createApp} from 'vue';
import App from './vue/App.vue';


import InfiniteLoading from "v3-infinite-loading";
import "v3-infinite-loading/lib/style.css"; //required if you're not going to override default slots

const app = createApp(App);


app.config.globalProperties.$filters = {
    str_limit(value, size) {
        if (!value) return '';
        value = value.toString();

        if (value.length <= size) {
            return value;
        }
        return value.substr(0, size) + '...';
    }
}

console.log(app.config.globalProperties.$filters);

app.component("infinite-loading", InfiniteLoading);
app.mount('#home');

require("./bootstrap");
