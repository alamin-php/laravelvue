<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">User's Table</h3>

                        <div class="card-tools">
                            <button class="btn btn-success" data-toggle="modal" data-target="#addNew">Add New <i class="fa fa-user-plus"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Photo</th>
                                    <th>User</th>
                                    <th>Date</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, index) in users":key="user.id">
                                    <td>{{ index+1 }}</td>
                                    <td><img width="64" height="64" class="brand-image img-circle elevation-2" :src="getProfilePhoto(user.photo)" alt="Image"></td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.created_at | myDate}}</td>
                                    <td><span class="tag tag-success">{{ user.type }}</span></td>
                                    <td class="text-right py-0 align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <!-- <a href="#" class="btn btn-primary" @click.prevent="showPost(post.id)"><i class="fas fa-eye"></i></a> -->
                                            <a href="#" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                            <a href="#" class="btn btn-danger" @click="deleteUser(user.id)"><i class="fas fa-trash"></i></a>
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
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add a new</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form enctype="multipart/form-data" @submit.prevent = 'createUser()'>
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name" placeholder="Enter user name" 
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>                        
                            <div class="form-group">
                                <input v-model="form.email" type="email" name="email" placeholder="Enter user email" 
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>                      
                            <div class="form-group">
                                <textarea v-model="form.bio" id="bio" name="bio" placeholder="Sort for user bio (optional)" 
                                class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                                <has-error :form="form" field="bio"></has-error>
                            </div>                      
                            <div class="form-group">
                                <select class="form-control" v-model="form.type" name="type" :class="{ 'is-invalid': form.errors.has('type') }">
                                    <option disabled value="">Select One</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                    <option value="author">Author</option>
                                </select>
                                <has-error :form="form" field="type"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.password" type="password" name="password" placeholder="Enter user password" 
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Upload User Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile" @change = "chengePhoto($event)">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-md-5">
                                    <div class="timeline-body">
                                        <img :src="form.photo" width="150" height="100">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Create</button>
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
            users:{},
            form: new Form({
                name:'',
                email:'',
                password:'',
                type:'',
                bio:'',
                photo:'',
            })
        }
    },
    methods:{
        deleteUser(id){
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
               this.$Progress.start()
               this.form.delete('api/users/'+id)
               .then(() =>{
                Fire.$emit('AfterCreate');
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                  )
                this.$Progress.finish()
            })
               .catch(() =>{

               })
           }
       })
      },
      createUser(){
        this.form.post('api/users')
        .then(() => {
           $('#addNew').modal('hide')
           Fire.$emit('AfterCreate');
           Toast.fire({
              icon: 'success',
              title: 'User Created in successfully'
          })
           this.$Progress.finish()

       })
        .catch(() => {

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
getProfilePhoto(img){
  return "upload/profile/"+img;
}, 
loadusers(){
    axios.get('api/users').then(({data}) => (this.users = data.data))
},
},
mounted() {
    this.loadusers();
    Fire.$on('AfterCreate', () =>{
        this.loadusers();
    })
}
}
</script>
