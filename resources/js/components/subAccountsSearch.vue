<template>

        <table class="table table-striped">
            <thead>
            <tr>
                <td>#</td>
                <td COLSPAN="6">Code</td>
                <td>Name</td>
            </tr>
            </thead>
            <tbody v-if="acc.length>0">
            <tr>
                <td>Search: </td>
                <td><input type="text" v-model="code" class="form-control input-xs"> </td>
                <td><input type="text" v-model="codeone" class="form-control input-xs"> </td>
                <td><input type="text" v-model="codetwo" class="form-control input-xs"> </td>
                <td><input type="text" v-model="codethree" class="form-control input-xs"> </td>
                <td><input type="text" v-model="codefour" class="form-control input-xs"> </td>
                <td><input type="text" v-model="codefive" class="form-control input-xs"> </td>
                <td><input type="text" v-model="name" class="form-control input-xs"> </td>
            </tr>
            <tr @click="selected(ac)" v-for="(ac,key) in acc.filter((a)=>{
                $x=true;
                if(code!=''){
                     $x=a.code.charAt(0).indexOf(code)!=-1;
                }
                if(codeone!=''){
                   $x=a.code.substring(3,3).indexOf(codeone)!=-1;
                }
                if(codetwo!=''){
                   $x=a.code.indexOf(codetwo)!=-1;
                }
                if(codethree!=''){
                   $x=a.code.indexOf(codethree)!=-1;
                }
                if(codefour!=''){
                   $x=a.code.indexOf(codefour)!=-1;
                }
                if(codefive!=''){
                   $x=a.code.indexOf(codefive)!=-1;
                }
                if(name!=''){
                    $x= (String(a.name)).toLowerCase().startsWith(name.toLowerCase())
                }
                return $x;

            })">
                <td>{{key+1}}</td>
                <td COLSPAN="6">{{ac.code}}</td>
                <td>{{ac.name}}</td>
            </tr>
            </tbody>
        </table>

</template>

<script>
export default {
name: "subAccountsSearch",
    props:['type'],
    data(){
    return {
        acc:[],
        code:'',
        codeone:'',
        codetwo:'',
        codethree:'',
        codefour:'',
        codefive:'',
        name:'',
    }
    },
    methods:{
    init(){
        this.$http.get('/coa/accounts/'+this.type).then(res=>{
            this.acc=res.data;
        })
    },
        selected(a){
        this.$emit('select',a);
        }
    },
    mounted() {
    this.init()
    }
}
</script>

<style scoped>
table tr:hover{
    background: #ccc;
    color:#fff;
}
table tbody tr{
    cursor: pointer;
}
thead{
    background-color: #49a2fb;
}
</style>
