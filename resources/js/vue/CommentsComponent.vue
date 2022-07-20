<template>

    <div class="container">
        <div class="col-lg-12">
            <h2>Comments Section</h2>

            <div class="row">
                <div class="col-lg-12">
                    dsadasdasdsa
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="comment">Comment</label>
                                        <textarea class="form-control" id="comment" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
console.log('CommentsComponent');
export default {
    name: 'CommentsComponent',
    data() {
        return {
            message: this.message,
            errored: false,
            comments: [],
            page: 1,
            imageLoaded: false,
        }
    },
    methods: {
        handleLoadMore($state) {
            fetch('/api/v1/comments/article/?page=' + this.page)
                .then(res => {
                    return res.json();
                }).then(res => {
                this.Categories = res.categories;

                $.each(res.result.data, (key, value) => {
                    this.Articles.push(value);
                });
                $state.loaded();
            });
            this.page = this.page + 1;
        },
        showArticle(article) {
            console.log(article)
        },
        imageLoadError() {
            console.log('imageLoadError')
            console.log('Image failed to load');
        },
        selectedFile() {
            this.imageLoaded = false;

            let file = this.$refs.myFile.files[0];
            if(!file || file.type.indexOf('image/') !== 0) return;

            this.image.size = file.size;

            let reader = new FileReader();

            reader.readAsDataURL(file);

            reader.onload = evt => {
                let img = new Image();
                img.onload = () => {
                    this.image.width = img.width;
                    this.image.height = img.height;
                    this.imageLoaded = true;
                }
                img.src = evt.target.result;
            }

            reader.onerror = evt => {
                console.error(evt);
            }

        }
    },
    mounted() {
        console.log("Welcome to the app!");
    }
}
</script>
<style>
.hearth:hover {
    color: red;
}
</style>
