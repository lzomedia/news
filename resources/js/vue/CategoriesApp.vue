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
                        <tr v-for="(category, index) in Categories">
                            <th scope="row">{{category.id}}</th>
                            <td>
                                <a v-bind:href="'/categories/show/' + category.id">
                                    {{category.name}}
                                </a>
                            </td>
                            <td>
                                {{category.count}}
                            </td>
                            <td>

                                <a href="#" v-on:click="deleteCategory(category.id)">
                                    <i class="fas fa-edit"></i>Delete
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
                    this.Categories = res.data;
                    this.loading = false;

            })  .catch(error => {
               this.loading = false;
               console.error('There was an error!', error);
           });
        },

        deleteCategory(category) {
            console.log('deleteCategory');
            this.loading = false;
            const requestOptions = {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    id: category,
                })
            };
            console.log(JSON.stringify(category));
            fetch("/api/v1/categories/delete", requestOptions)
                .then(
                    response => {
                        this.loading = false;
                        this.search();
                    }
                )
                .then(data => (this.postId = data.id));
        },
    },
    mounted()
    {
        this.search();
    }
}
</script>
<style>
.hearth:hover {
    color: red;
}
</style>
