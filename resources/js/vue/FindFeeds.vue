<template>
    <!-- Page content-->
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <p>
                    Welcome to feeds finder.
                    <small>Please press search</small>
                </p>

                <form @submit.prevent="search">
                    <input type="text" v-model="topic">
                    <button type="submit">
                        Search Topic
                    </button>
                </form>

            </div>
        </div>

        <div class="row">

            <div class="col-lg-12">
                <table class="table">
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
                    <tr v-for="feed in Feeds">
                        <th scope="row">1</th>
                        <td>
                            <a :href="feed.website">{{ feed.title }}</a>
                        </td>
                        <td>{{ feed.subscribers }}</td>
                        <td>{{ feed. relevanceScore }}</td>
                        <td>{{ feed.exists }}</td>
                        <td>
                            <a href="#" @click.prevent="saveFeed(feed)">
                                Save Feed
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
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
            Feeds: [],
            Topics: [],
        }
    },
    methods: {
        search($state) {
           fetch('/api/v1/feeds/find/' + this.topic)
                .then(res => {
                    return res.json();
                }).then(res => {
                    this.Topics = res.topics;
                    this.Feeds = res.feeds;

                    $state.loaded();
            });
        },
        saveFeed(feed) {
            const requestOptions = {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(feed)
            };
            console.log(JSON.stringify(feed));
            fetch("/api/v1/feeds/save", requestOptions)
                .then(response => response.json())
                .then(data => (this.postId = data.id));
        }
    },
    mounted()
    {
        this.handleLoadMore(this.$refs.infiniteLoading);
        console.log("Welcome to the app!");
        this.search(this.$refs.infiniteLoading);
    }
}
</script>
<style>
.hearth:hover {
    color: red;
}
</style>
