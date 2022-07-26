<template>
    <section class="container">
        <div class="row">
            <div class="col-lg-12">

                <h5>
                    Welcome to the categories manager.
                </h5>
                <p class="card-text">
                   This is a simple application to manage categories.
                </p>
            </div>
            <div class="col-lg-12 py-2">
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
                            <th scope="col">Name</th>
                            <th scope="col">Articles Count</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(feed, index) in Feeds">
                            <th scope="row">{{index}}</th>
                            <td>
                                Category
                            </td>
                            <td>
                              100
                            </td>
                            <td>
                                Actions
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
if (navigator.share) {
    console.log('Share is supported');
} else {
    console.log('Share is not supported');
}

console.log('CategoriesApp.vue');
export default {
    name: 'CategoriesApp',
    data() {
        return {
            message: this.message,
            errored: false,
            topic: "laravel",
            loading: true,
            Categories: [],
            Topics: [],
        }
    },
    methods: {
        search() {
           this.loading = true;

           fetch('/api/v1/categories/')
                .then(res => {
                    return res.json();
                }).then(res => {
                    this.Topics = res.topics;
                    this.Feeds = res.feeds;
                    this.loading = false;

            })  .catch(error => {
               this.loading = false;
               console.error('There was an error!', error);
           });
        },
        saveCategory(category) {
            this.loading = true;
            const requestOptions = {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(category)
            };
            console.log(JSON.stringify(category));
            fetch("/api/v1/categories/save", requestOptions)
                .then(
                    response => {
                        this.loading = false;
                    }
                )
                .then(data => (this.postId = data.id));
        },

        deleteCategory(feed) {
            this.loading = true;
            const requestOptions = {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(feed)
            };
            console.log(JSON.stringify(feed));
            fetch("/api/v1/categories/delete", requestOptions)
                .then(
                    response => {
                        this.loading = false;
                        this.setTopic(feed.topic);
                        this.search(feed.topic);
                    }
                )
                .then(data => (this.postId = data.id));
        },
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
