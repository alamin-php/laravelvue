<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Categories Table</h3>

                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModel">Add <i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category</th>
                                    <th>Created At</th>
                                    <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(category, index) in categories.data":key="category.id">
                                    <td>{{ index+1 }}</td>
                                    <td>{{ category.name }}</td>
                                    <td>{{ category.created_at | myDate}}</td>
                                    <td>
                                        <a href="#" @click="editModel(category)"><i class="fa fa-edit"></i></a>/
                                        <a href="#" @click="deleteCat(category.id)"><i class="fa fa-trash"></i></a>
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
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewTitle" v-show="!editmode">Add New</h5>
                        <h5 class="modal-title" id="addNewTitle" v-show="editmode">Update Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateCat() : createCat()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Category Name</label>
                                <input v-model="form.name" type="text" name="name" placeholder="Enter a category name" 
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" v-show="editmode" class="btn btn-success">Update</button>
                            <button type="submit" v-show="!editmode" class="btn btn-success">Save</button>
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
            categories:{},
            form: new Form({
                id:'',
                name:''
            })
        }
    },
    methods:{
        updateCat(){
            this.$Progress.start()
            this.form.put('api/categories/'+this.form.id)
            .then(() =>{
                $('#addNew').modal('hide')
                Fire.$emit('AfterCreate');
                this.$Progress.finish()
                Toast.fire({
                    icon: 'success',
                    title: 'Category Updated in successfully'
                })
            })
            .catch(() =>{
                this.$Progress.fail()
            })
        },
        editModel(category){
            this.editmode = true;
            this.form.reset();
            this.form.clear();
            $('#addNew').modal('show')
            this.form.fill(category);
        },        
        newModel(){
            this.editmode = false;
            this.form.reset();
            this.form.clear();
            $('#addNew').modal('show')
        },
        deleteCat(id){
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
                    this.form.delete('api/categories/'+id)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        this.$Progress.finish()
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                            )
                    })
                    .catch(() => {
                        this.$Progress.fail()

                    })
                }
            })
        },
        createCat(){
            this.$Progress.start()
            this.form.post('api/categories')
            .then(() =>{
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide')
                Toast.fire({
                    icon: 'success',
                    title: 'Category created in successfully'
                })
                this.$Progress.finish()
            })
            .catch(() =>{
                this.$Progress.fail()
            })
        },
        loadCat(){
            axios.get('api/categories').then(({data}) =>(this.categories = data))
        }
    },
    mounted() {
        this.loadCat();
        Fire.$on('AfterCreate', () =>{
            this.loadCat();
        })
    }
}
</script>


