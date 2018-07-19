<template>
    <div>
        <h2>Articles</h2>
        <form @submit.prevent="addAticle" class="mb-3">
            <div class="form-group">
                <input type="text" class="form-control mb-2" placeholder="Title" v-model="article.title" />
                <textarea type="text" class="form-control mb-2" placeholder="Body" v-model="article.body"></textarea>
                <button class="btn btn-light btn-block">Save</button>
            </div>
        </form>
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                <a class="page-link" href="#" @click="fetchArticles(pagination.prev_page_url)">Previous</a>
            </li>
            <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

            <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                <a class="page-link" href="#" @click="fetchArticles(pagination.next_page_url)">Next</a>
            </li>
          </ul>
        </nav>        
        <div class="card card-body mb-2" v-for="article in articles" v-bind:key="article.id">
        	<h3>{{ article.title }}</h3>
        	<p>{{ article.body }}</p>
            <hr>
            <button class="btn btn-warning mb-2" @click="editArticle(article)">Edit</button>
            <button class="btn btn-danger mb-2" @click="deleteArticle(article.id)">Delete</button>
        </div>
    </div>
</template>

<script>
	export default {
		data(){
			return {
				articles: [],
				article: {
					id: '',
					title: '',
					body: ''
				},
				article_id: '',
				pagination: {},
				edit: false
			};
		},
		//una vez creado el componente y la pagina carga se ejecuta la funcion
		created(){
			this.fetchArticles();
		},
		methods:{
			fetchArticles(page_url){
				let vm = this;
				page_url = page_url || '/api/articles';
				//conviene usar axios en vez de fetch (deprecated)
				fetch(page_url)
					.then(res => res.json()) //no es necesario con axios
					.then(res => {
						this.articles = res.data;
						vm.makePagination(res.meta, res.links);
					})
					.catch(err => console.log(err));
			},
			makePagination(meta, links){
				let pagination = {
					current_page: meta.current_page,
					last_page: meta.last_page,
					next_page_url: links.next,
					prev_page_url: links.prev
				}

				this.pagination = pagination;
			},
            deleteArticle(id){
                if(confirm("Are you sure?")){
                    fetch(`api/article/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert("Article removed");
                        this.fetchArticles();
                    })
                    .catch(err => console.log(err));
                }
            },
            addAticle(){
                if (this.edit === false) {
                    //add
                    fetch('api/article', {
                        method: 'post',
                        body: JSON.stringify(this.article),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.article.title = '',
                        this.article.body = '',
                        alert("Article added");
                        this.fetchArticles();
                    })
                    .catch(err => console.log(err));
                } else {
                    //update
                    fetch('api/article', {
                        method: 'put',
                        body: JSON.stringify(this.article),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.article.title = '',
                        this.article.body = '',
                        alert("Article updatet");
                        this.fetchArticles();
                    })
                    .catch(err => console.log(err));
                }
            },
            editArticle(article){
                this.edit = true;
                this.article.id = article.id;
                this.article.article_id = article.id;
                this.article.title = article.title;
                this.article.body = article.body;
            }
		}
	}
</script>