<template>
	<div>
	    <form @submit.prevent="submit" v-if="isAuthenticated">
	        <div class="card-body bg-light">
	            <textarea name="body"
	            		v-model="body"
	            		class="form-control border-0 bg-light"
	                	:placeholder="`Qué estas pensado ${currentUser.name}?`">
	            </textarea>
	        </div>
	        <div class="card-footer">
	            <button id="create-status" class="btn btn-primary">Publicar</button>
	        </div>
	    </form>
	    <!-- <div v-for="status in statuses" v-text="status.body"></div> -->
	    <div v-else class="card-body bg-light">
	    	<a href="/login">debes hacer login</a>
	    </div>
    </div>
</template>

<script>
	// let user = document.head.querySelector('meta[name="user"]');
	// console.log(JSON.parse(user.content));
	// import auth from '../mixins/auth';

	export default {
		data() {
			return {
				body: '',
			}
		},

		// mixins: [auth],

		methods: {
			submit() {
				axios.post('/statuses', { body: this.body })
					.then(res => {
						EventBus.$emit('status-created', res.data);
						this.body = '';
					})
					.catch(err => {
						console.log(err.response.data);
					})
			}
		}
	}
</script>