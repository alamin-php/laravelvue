<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 mt-3">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Post's Table</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-success"  @click="newModel">Add Post <i class="fa fa-plus"></i></button>
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
                  <th>User</th>
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
                  <td class="text-danger" v-else>No Category</td>
                  <td v-if="post.user">{{ post.user.name }}</td>
                  <td class="text-danger" v-else>Unknow User</td>
                  <td>{{ post.created_at |myDate}}</td>
                  <td><img width="64" height="32" :src="ourImage(post.photo)" alt="Image"></td>
                  <td class="text-right py-0 align-middle">
                    <div class="btn-group btn-group-sm">
                      <a href="#" class="btn btn-primary" @click.prevent="showPost(post.id)"><i class="fas fa-eye"></i></a>
                      <a href="#" class="btn btn-success" @click.prevent="editModel(post)"><i class="fas fa-edit"></i></a>
                      <a href="#" class="btn btn-danger" @click.prevent="deletePost(post.id)"><i class="fas fa-trash"></i></a>
                    </div>
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
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle" v-show="!editmode">Add a new post</h5>
            <h5 class="modal-title" id="exampleModalLongTitle" v-show="editmode">Update post info</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form role="form" enctype="multipart/form-data" @submit.prevent="editmode ? updatePost() : createPost()">
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
                <!-- <markdown-editor :options="form.body"></markdown-editor> -->
                <!-- <markdown-editor v-model="form.body"></markdown-editor> -->
                <has-error :form="form" field="body"></has-error>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Select Category</label>
                    <select class="form-control" v-model="form.category_id" name="category_id" :class="{ 'is-invalid': form.errors.has('category_id') }">
                      <option disabled value="">Select One</option>
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
                    <img :src="ourImage(post.photo)" width="150" height="100">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success" v-show="editmode">Update</button>
              <button type="submit" class="btn btn-success" v-show="!editmode">Save</button>
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
      editmode:false,
      value: '',
      categories:{},
      posts:{},
      form:new Form({
        id:'',
        title:'',
        body:'',
        category_id:'',
        user_id:'',
        photo:'',
      })
    }
  },
  methods:{
    updatePost(){
      console.log('edit')

    },
    editModel(post){
      this.editmode = true
      this.form.reset();
      this.form.clear();
      $('#addNew').modal('show')
      this.form.fill(data.post)
    },
    showPost(id){
      this.form.get('api/posts/'+id)
    },
    deletePost(id){
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {      
          this.form.delete('api/posts/'+id)
          .then(() => {
            Fire.$emit('AfterCreate');
            Swal.fire(
              'Deleted!',
              'Your file has been deleted.',
              'success'
              )

          })
          .catch(() => {

          })
        }
      })
    },
    ourImage(img){
      return 'upload/'+img;
    },    
    newModel(){
      this.editmode = false;
      this.form.reset();
      this.form.clear();
      $('#addNew').modal('show')
    },
    createPost(){
      // console.log(this.form.title)
      this.$Progress.start()
      this.form.post('api/posts')
      .then(() => {
        $('#addNew').modal('hide')
        Fire.$emit('AfterCreate');
        Toast.fire({
          icon: 'success',
          title: 'Post Created in successfully'
        })
        this.$Progress.finish()

      })
      .catch(() => {
        this.$Progress.fail()
      })
    },
    chengePhoto(event){
      let file = event.target.files[0];
      console.log(file)
      if (file.size > 1048576) {
        Swal.fire(
          'Oops...',
          'Your uploding file too large!',
          'error'
          )
      }else{
        let reader = new FileReader();
        reader.onload = event => {
          this.form.photo = event.target.result
          console.log(event.target.result)
        };

        reader.readAsDataURL(file);
      }
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

