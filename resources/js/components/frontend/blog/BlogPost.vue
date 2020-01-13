<template>
    <span id="blogpost">
        <section id="inner-headline">
            <div class="container">
                <div class="row">
                    <div class="span4">
                        <div class="inner-heading">
                            <h2>Blog left sidebar</h2>
                        </div>
                    </div>
                    <div class="span8">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="icon-home"></i></a><i class="icon-angle-right"></i></li>
                            <li><a href="#">Blog</a><i class="icon-angle-right"></i></li>
                            <li class="active">Blog with left sidebar</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section id="content">
            <div class="container">
                <div class="row">
                    <div class="span8">
                        <article v-for="post in posts" :key="post.id">
                            <div class="row">
                                <div class="span8">
                                    <div class="post-image">
                                        <div class="post-heading">
                                            <h3><a href="#">{{ post.title }}</a></h3>
                                        </div>
                                        <img src="img/dummies/blog/img1.jpg" alt="" />
                                    </div>
                                    <p>
                                        Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius
                                        ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.
                                    </p>
                                    <div class="bottom-article">
                                        <ul class="meta-post">
                                            <li><i class="icon-calendar"></i><a href="#"> {{ post.created_at | myDate }}</a></li>
                                            <li><i class="icon-user"></i><a href="#"> {{ post.user }}</a></li>
                                            <li><i class="icon-folder-open"></i><a href="#"> Blog</a></li>
                                            <li><i class="icon-comments"></i><a href="#">4 Comments</a></li>
                                        </ul>
                                        <a href="#" class="pull-right">Continue reading <i class="icon-angle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <div id="pagination">
                            <span class="all">Page 1 of 3</span>
                            <span class="current">1</span>
                            <a href="#" class="inactive">2</a>
                            <a href="#" class="inactive">3</a>
                        </div>
                    </div>
                    <BlogSidebar/>
                </div>
            </div>
        </section>
    </span>
</template>

<script>
import BlogSidebar from './BlogSidebar.vue'
export default {
    data(){
        return{
            posts:{},
        }
    },
        methods:{
        loadPosts(){
            axios.get('api/blogpost').then(({data}) =>(this.posts = data))

        }
    },
    mounted() {
        this.loadPosts();
    },
    components:{
        BlogSidebar
    },
}
</script>
