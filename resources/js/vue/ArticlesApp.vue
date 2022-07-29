<template>
    <section class="container">
        <div class="row">
            <div class="col-lg-12">

                <h5>
                    Welcome to the articles manager.
                </h5>
                <p class="card-text">
                   This is a simple application to manage articles.
                </p>
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
                        <tr v-for="(article, index) in Articles">
                            <th scope="row">{{article.id}}</th>
                            <td>
                                <a v-bind:href="'/article/' + article.id">
                                    {{article.title}}
                                </a>
                            </td>
                            <td>
                                Other
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

console.log('ArticlesApp.vue');
export default {
    name: 'ArticlesApp',
    data() {
        return {
            message: this.message,
            errored: false,
            topic: "laravel",
            loading: true,
            Articles: [],
            Topics: [],
        }
    },
    methods: {
        search() {
           this.loading = true;

           fetch('/api/v1/articles?per_page=10')
                .then(res => {
                    return res.json();
                }).then(res => {
                    this.Articles = res.result.data;
                    this.loading = false;

            })  .catch(error => {
               this.loading = false;
               console.error('There was an error!', error);
           });
        }
    },
    mounted()
    {
        this.search("laravel");
    }
}
</script>
