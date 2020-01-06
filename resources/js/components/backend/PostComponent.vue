<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 mt-3">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Post's Table</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Add Post <i class="fa fa-plus"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Category</th>
                  <th>Post By</th>
                  <th>Post Date</th>
                  <th>Photo</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(post,index) in posts":key="post.id">
                  <td>{{ index+1 }}</td>
                  <td>{{ post.title | sortlength(15,'...')}}</td>
                  <td v-if="post.category">{{ post.category.name }}</td>
                  <td v-if="post.user">{{ post.user.name }}</td>
                  <td>{{ post.created_at |myDate}}</td>
                  <td><img width="100" height="64" :src="post.photo" alt="Image"></td>
                  <td>
                    <a href="#"><i class="fa fa-eye"></i></a>/
                    <a href="#"><i class="fa fa-edit"></i></a>/
                    <a href="#"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add a new post</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form>
            <div class="modal-body">
              <div class="form-group">
                <label>Post Title</label>
                <input v-model="form.title" type="text" name="title" placeholder="Enter post title" 
                class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                <has-error :form="form" field="title"></has-error>
              </div>            

              <div class="form-group">
                <label>Post Body</label>
                <textarea v-model="form.body" id="body" name="body" placeholder="Enter post title" 
                class="form-control" :class="{ 'is-invalid': form.errors.has('body') }"></textarea>
                <has-error :form="form" field="body"></has-error>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group" v-model="form.category_id" name="category_id" :class="{ 'is-invalid': form.errors.has('category_id') }">
                    <label>Select Category</label>
                    <select class="form-control">
                      <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                    </select>
                    <has-error :form="form" field="category_id"></has-error>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputFile">Upload Post Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" @change="chengePhoto($event)">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div> 
                </div>
                <div class="col-md-4">
                  <div class="timeline-body">
                    <img :src="form.photo" width="150" height="100">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      categories:{},
      posts:{},
      form:new Form({
        title:'',
        body:'',
        category_id:'',
        comment_id:'',
        tag_id:'',
        user_id:'',
        photo:'',
      })
    }
  },
  methods:{
    chengePhoto(event){
      let file = event.target.files[0];
      let reader = new FileReader();
      reader.onload = event => {
        this.form.photo = event.target.result
      };

      reader.readAsDataURL(file);
    },
    loadPosts(){
      this.$Progress.start()
      axios.get('api/posts').then(({data}) => (this.posts = data.data))
      this.$Progress.finish()
    },
    loadCat(){
      axios.get('api/categories').then(({data}) =>(this.categories = data.data))
    }
  },
  mounted() {
    this.loadCat();
    this.loadPosts();
    Fire.$on('AfterCreate', () => {
      this.loadPosts();
    })
  }
}
</script>

