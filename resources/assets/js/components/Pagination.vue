<template>
	<div>
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
	</div>
</template>

<script>
	export default{
		props: ['pagination'],
		methods: {
			
		}
	}
</script>