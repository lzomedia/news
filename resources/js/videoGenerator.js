require('./bootstrap');
//
require('alpinejs');

import {createApp} from 'vue';

import VideoGenerator from './vue/VideoGenerator.vue';
import moment from 'moment';

import InfiniteLoading from "v3-infinite-loading";

import "v3-infinite-loading/lib/style.css"; //required if you're not going to override default slots
import MasonryWall from '@yeger/vue-masonry-wall'


const app = createApp(VideoGenerator);


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


let formatter = {
    date: function (value, format) {
        if (value) {
            return moment(String(value)).format(format || 'MM/DD/YY')
        }
    },
    time: function (value, format) {
        if (value) {
            return moment(String(value)).format(format || 'h:mm A');
        }
    },
    ago: function (value, format) {
        if (value) {
            return moment(String(value)).fromNow();
        }
    }
};

app.component('format', {
    template: `<span>{{ formatter[fn](value, format) }}</span>`,
    props: ['value', 'fn', 'format'],
    computed: {
        formatter() {
            return formatter;
        }
    }
});

app.directive('demo', function (el, binding) {
    console.log(binding.value.color) // => "white"
    console.log(binding.value.text)  // => "hello!"
})
app.use(MasonryWall)

app.mount('#videoGenerator');

require("./bootstrap");
