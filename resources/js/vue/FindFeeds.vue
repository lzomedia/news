<template>
    <section class="container">
        <div class="row">
            <div class="col-lg-12">

                <h5>
                    Welcome to the feeds finder.
                </h5>
                <p class="card-text">
                    This is a simple application that allows you to find the feeds that are most relevant to you.
                    Once you have found the feeds that are most relevant to you, you can then subscribe to them.
                </p>
                <form @submit.prevent="search">
                    <input type="text" v-model="topic">
                    <button type="submit" v-on:click="search">
                        Search Topic
                    </button>
                </form>
            </div>
            <div class="col-lg-12 py-2">
                <p class="mb-0">
                    Related topics
                </p>
                <div v-for="topic in Topics" style="margin-right: 5px" class="badge bg-secondary text-decoration-none link-light">
                    <a v-on:click="setTopic(topic.topic)">
                        {{topic.topic}}
                    </a>
                </div>&nbsp;
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="py-5">
                    <div class="spinner-border " v-if="loading" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>

                    <table v-else class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Subscribers</th>
                            <th scope="col">Score</th>
                            <th scope="col">Exists</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(feed, index) in Feeds">
                            <th scope="row">{{index}}</th>
                            <td>
                                <a :href="feed.website">{{ feed.title }}</a>
                            </td>
                            <td>{{ feed.subscribers }}</td>
                            <td>{{ feed.score }}</td>
                            <td>
                                <span class="badge bg-success" v-if="feed.exists">
                                    Imported
                                </span>
                                <span v-else class="badge bg-danger">
                                    Not Imported
                                </span>
                            </td>
                            <td>
                                <a v-if="!feed.exists" href="#" @click.prevent="saveFeed(feed)">
                                   Subscribe
                                </a>
                                <a class="badge bg-danger" v-else href="#" @click.prevent="deleteFeed(feed)">
                                    Unsubscribe
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</template>
<script>


console.log('findFeeds.vue');
export default {
    name: 'findFeeds',
    data() {
        return {
            message: this.message,
            errored: false,
            topic: "laravel",
            loading: true,
            Feeds: [],
            Topics: [],
        }
    },
    methods: {
        search() {
           this.loading = true;

           fetch('/api/v1/feeds/find/' + this.topic)
                .then(res => {
                    return res.json();
                }).then(res => {
                    this.Topics = res.result.topics;
                    this.Feeds = res.result.feeds;
                    this.loading = false;

            })  .catch(error => {
               this.loading = false;
               console.error('There was an error!', error);
           });
        },
        saveFeed(feed) {
            this.loading = true;
            const requestOptions = {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(feed)
            };
            console.log(JSON.stringify(feed));
            fetch("/api/v1/feeds/save", requestOptions)
                .then(
                    response => {
                        this.loading = false;
                        this.setTopic(feed.topic);
                        this.search(feed.topic);
                    }
                )
                .then(data => (this.postId = data.id));
        },

        deleteFeed(feed) {
            this.loading = true;
            const requestOptions = {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(feed)
            };
            console.log(JSON.stringify(feed));
            fetch("/api/v1/feeds/delete", requestOptions)
                .then(
                    response => {
                        this.loading = false;
                        this.setTopic(feed.topic);
                        this.search(feed.topic);
                    }
                )
                .then(data => (this.postId = data.id));
        },
        setTopic(topic) {
            this.topic = topic;
            this.search(topic);
            console.log(topic);
        }
    },
    mounted()
    {
        this.search("laravel");
    }
}
</script>
<style>
.hearth:hover {
    color: red;
}
</style>
