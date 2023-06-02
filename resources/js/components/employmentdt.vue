<template>
    <div>
        <vue-snotify></vue-snotify>

        <div v-if="DeleteTheInvoice">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title" style="color: black;">ARE YOU SURE ?</h5>
                                    <button type="button" class="close" @click="DeleteTheInvoice=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <span style="color: black;">Do you really want to Delete this Employment ?</span>
                                    <br> <br>
                                    <input placeholder="Enter Remarks" class="form-control input-height" v-model="remarks" id="remarks">

                                    <br>

                                </div>
                                <div class="modal-footer">
                                    <button @click="afterdel();" class="btn btn-outline-warning active">Yes</button>
                                    <button type="button" class="btn btn-secondary" @click="DeleteTheInvoice=false">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>

        <div class="row hidden-print">
            <div class="col-lg">
                <multiselect track-by="name" label="name" placeholder="Choose Company" v-model="company" :multiple="true" :options="(()=>{let x=[];
            companies.forEach((a)=>{
                x.push({name:a.name,id:a.code})
            })
            return x;
            })()"></multiselect>

            </div>

            <div class="col-lg">
                <multiselect track-by="name" label="name" placeholder="Choose Department" v-model="department" :multiple="true" :options="(()=>{
                let x=[];
                departments.filter((a)=>{
                    if(company.length>0){
                        return pluck(company,'id').indexOf((a.company))!=-1
                    } else{
                        return true;
                    } } ).forEach((a)=>{
                        x.push({name:a.desc,id:a.id})
                })
                return x;
            })()"></multiselect>


            </div>

            <div class="col-lg">
                <multiselect track-by="name" label="name" placeholder="Choose Sub-Department" v-model="subdepartment" :multiple="true" :options="(()=>{
                let x=[];
                subdepartments.filter((a)=>{
                    let cond=true;
                    if(company.length>0 && department.length==0){

                        return pluck(company,'id').indexOf((a.company))!=-1
                    }
                    else if(department.length>0){
                         return pluck(department,'id').indexOf(parseInt(a.department))!=-1
                     }
                        else{
                        return true;
                    }
                    } ).forEach((a)=>{
                        x.push({name:a.desc,id:a.id})
                })
                return x;
            })()"></multiselect>

            </div>

            <!--        <div class="col-lg">

                        <input value="" autocomplete="off" class="form-control" type="text"
                               id="designation" v-model="designation"
                               name="designation" placeholder="Search by Designation">
                    </div>-->
            <div class="col-lg">
                <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">

                    <input  v-model="designation" name="designation" id="designation" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search by Designation...">


                    <ul id="areabox2" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="designations.length>0 && designation!=''" >

                        <li  :class="'fbb fba'+key"  @click="designationdatavalue(c.id)"  v-on:keyup.enter="designationdatavalue(c.id)" v-for="(c,key) in designations">
                            <a href="javascript:void(0)">   {{c.designation}}</a>
                        </li>

                    </ul>
                </div>

            </div>


        </div>

    <br>

        <div class="row hidden-print">



            <div class="col-lg">

                <input value="" class="form-control "  size="20" type="text"
                       id="barcode" autocomplete="off" v-model="barcode"
                       name="barcode" placeholder="Search by Barcode">
            </div>
            <div class="col-lg">

                <input value="" class="form-control "  size="20" type="number"
                       id="memberid" v-model="memberid" autocomplete="off"
                       name="memberid" placeholder="Search by ID">
            </div>

            <div class="col-lg">

                <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">

                    <input  v-model="customer" name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search by Name...">


                    <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="customers.length>0 && customer!=''" >

                        <li  :class="'fbb fba'+key"  @click="customerdatavalue(c.id)"  v-on:keyup.enter="customerdatavalue(c.id)" v-for="(c,key) in customers">
                            <a href="javascript:void(0)">   {{c.name}}</a>
                        </li>

                    </ul>
                </div>

            </div>
            <div class="col-lg">

                <input value="" autocomplete="off" class="form-control "  size="20" type="text"
                       id="cnic" v-model="cnic"
                       name="cnic" placeholder="Search by CNIC">
            </div>
            <div class="col-lg">

                <input value="" autocomplete="off" class="form-control "  size="20" type="number"
                       id="contact" v-model="contact"
                       name="contact" placeholder="Search by Contact">
            </div>

            <div class="col-lg">
                <div>
                    <select v-model="status"  class="form-control">
                        <option v-for="s in ['All','Active','In-Active']">{{s}}</option>
                    </select>
                </div>
            </div>

        </div>


        <div class="scrollclasstable1">

            <div>
                <table class="table-striped table-bordered table-hover ">
                    <thead :style="'font-size:15px'">
                    <tr>
                        <th class="wd-5p">SR #</th>
                        <th class="wd-5p">ID</th>
                        <th class="wd-15p">NAME</th>
                        <th class="wd-15p">FATHER NAME</th>
                        <th class="wd-10p">COMPANY DETAILS</th>
                        <th class="wd-10p">CNIC #</th>
                        <th class="wd-10p">CONTACT</th>
                        <th class="wd-10p">EMAIL</th>
                        <th class="wd-15p">ADDRESS</th>

                        <th class="wd-10p">BARCODE #</th>
                        <th class="wd-15p">PICTURE</th>
                        <th class="wd-10p">STATUS</th>
                        <th class="wd-10p">USER</th>
                        <th class="wd-5p hidden-print">EDIT</th>
                        <th class="wd-5p hidden-print">DELETE</th>
                    </tr>
                    </thead>
                    <tbody :style="'font-size:15px'">
                    <tr v-for="(tr,key) in

                sliceP(
                     (()=>{
                      let  x=filterData(employees);

                   leng=x.length;
                  if(parseInt(leng/pagelength)+((leng%pagelength)>0?1:0)<page){
                      page=1;
                  }

                      //

                     return x;
                    })()

                    )" >
                        <td>{{((page-1)*pagelength)+key+1}}</td>
                        <td>{{tr.id}}</td>
                        <td>{{tr.name}} ({{tr.designation}})</td>
                        <td>{{tr.father_name}}</td>
                        <td>{{tr.company}}<br>{{tr.department}}<br>{{tr.subdepartment}}</td>
                        <td>{{tr.cnic}}</td>
                        <td>{{tr.mob_a}}</td>
                        <td>{{tr.email}}</td>
                        <td>{{tr.cur_address}}</td>

                        <td>{{tr.barcode}}</td>
                        <td>
                            <template v-if="tr.image!=''">
                                <img style="width: 100px;" :src="'/'+tr.image">
                            </template>

                        </td>

                        <template v-if="tr.active==1">
                            <td><button class="btnwidth btn btn-outline-success active btn-block mg-b-10" title="Status">Active</button></td>
                        </template>
                        <template v-else>
                            <td><button class="btnwidth btn btn-outline-danger active btn-block mg-b-10" title="Status">In-Active</button></td>
                        </template>

                        <td>{{tr.cashiername}}</td>
                        <td class="hidden-print"><button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" :href="'/human-resource/employment/employment-aeu/' + tr.id"><i class="fas fa-edit"></i></a></button></td>
                        <td class="hidden-print"><button class="buttoncolor" @click="deleteme(tr.id,tr.remarks);" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                    </tr>
                    </tbody>

                </table>
                <div class="hidden-print">
                    <ul class="pagination">
                        <li :class="page==n?'active':''"  v-for="n in (parseInt(leng/pagelength)+((leng%pagelength)>0?1:0))" @click="page=n"><span  >{{n}} </span></li>
                        <li>
                            <select  v-model="pagelength" class="">
                                <option value="30" >30</option>
                                <option value="50" >50</option>
                                <option value="100" >100</option>
                                <option value="150" >150</option>
                                <option :value="employees.length" >ALL</option>
                            </select>
                        </li>  </ul>
                </div>

            </div>
        </div>


    </div>
</template>
<style>
.vdp-datepicker__clear-button{

    position: absolute;
    right: 10px;
    top: 5px;
    font-size: 20px;
    color: #000;

}
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
.table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
    background-color:#bcd3e3;
}
.pagination li {
    padding: 5px 10px;
    border: 1px solid #0a4177;
    margin-right: 2px;
    /* border-radius: 50%; */
    /* height: 40px; */
    /* width: 40px; */
    text-align: center;

    cursor: pointer;
    transition: all 0.3s;
}
.pagination li.active{
    background: #49a2fb;
    color: #fff;
}
.pagination li:hover{
    background: #49a2fb;
    color: #fff;
}

.groove{
    overflow: auto;
    height: 300px !important;
}
.offline {
    background-color: #fc9842;
    background-image: linear-gradient(315deg, #fc9842 0%, #fe5f75 74%);
}
.online {
    background-color: #00b712;
    background-image: linear-gradient(315deg, #00b712 0%, #5aff15 74%);
}
/*table thead th{
    position: sticky;
    top: 80px;
    background: #000;
}*/
table th{
    background:#0c3661;
    height: 50px !important;
}
table tfoot{
    background:#0c91ed;
}
table tfoot td{
    color :black !important;
    height: 30px !important;

}

.fbb{
    padding: 0!important;
    border: none!important;
    border-bottom: 1px solid #e7e7e7!important;
}
.fbb a{
    opacity: 1;
    background: #fdf7f7;

    display: block;
    color: #000;
}
.fbb a:focus{
    opacity: 1;
    background:#49a2fb;
    color: #fff;
    font-weight:bold;
}
.areabox{
    padding:0!important
}
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: table;
    transition: opacity .3s ease;
}
.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
}
</style>
<script>
import Datepicker from 'vuejs-datepicker';
export default {
    name: "employmentdt",
    components: {
        Datepicker
    },
    props: [],
    data(){
        return{
            page:1,
            pagelength:50,
            leng:0,
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            employees:[],
            employeesR:[],
            employeesM: [],
            barcode:'',
            memberid:'',
            cnic:'',
            contact:'',
            customers:[],
            customer:'',
            mog:2,
            searchId:null,
            status:'All',
            fkey:-1,
            ffkey:0,
            departments:[],
            companies:[],
            subdepartments:[],
            company:[],
            department:[],
            subdepartment:[],

            deletethisid:'',
            DeleteTheInvoice:false,
            remarks:'',
            designations:[],
            designation:'',
            desId:null,
        }
    },

    methods:{
        fup(){

        },fdown(){
            console.log(1)

        },udf(event){

            if(event==0){
                if(this.fkey!=this.customers.length){

                    this.fkey=this.fkey+1
                }
                $('.fba'+this.fkey +' a').focus();

                // $('.fba'+this.fkey).focus();
                // event.preventDefault()
            }if(event==1){

                if(this.fkey!=-1){

                    this.fkey=this.fkey-1
                }
                $('.fba'+this.fkey+' a').focus();

                // event.preventDefault()
            }
        },
        afterdel:function(){
            let data={
                remarks:this.remarks
            };
            let url='/human-resource/employment/delete/'+this.deletethisid;
            if(this.validation(data,['remarks'])==0){
                this.DeleteTheInvoice=false;
                this.$http.post(url,data).then(result=> {
                    this.init();
                });
            }
        },
        deleteme: function (k,com) {
            this.DeleteTheInvoice=true;
            this.deletethisid=k;
            this.remarks=com;
        },
        filterData(employees){
            let   x=employees;

            if(this.barcode){
                x=x.filter((a)=>{
                    let self = this;
                    return (String(a.barcode)).startsWith(self.barcode)});
            }
            if(this.memberid){
                x=x.filter((a)=>{
                    let self = this;
                    return (String(a.id)).startsWith(self.memberid)});
            }
            if(this.cnic){
                x=x.filter((a)=>{
                    let self = this;
                    return (String(a.cnic)).startsWith(self.cnic)});
            }
            if(this.contact){
                x=x.filter((a)=>{
                    let self = this;
                    return (String(a.mob_a)).startsWith(self.contact)});
            }
            /* if(this.designation){
                 x=x.filter((a)=>{
                     let self = this;
                     return (String(a.designation)).toLowerCase().startsWith(self.designation.toLowerCase())});
             }*/
            if (this.searchId){
                x=x.filter((a)=>{return a.id==this.searchId});
            }
            if (this.desId){
                x=x.filter((a)=>{return a.designation==this.desId});
            }

            if(this.company.length>0){
                x=x.filter((a)=>{return this.company.filter((m)=>{
                    return a.company==m.name;
                }).length>0});
            }
            if(this.department.length>0){
                x=x.filter((a)=>{return this.department.filter((m)=>{
                    return a.department==m.name;
                }).length>0});
            }
            if(this.subdepartment.length>0){
                x=x.filter((a)=>{return this.subdepartment.filter((m)=>{
                    return a.subdepartment==m.name;
                }).length>0});
            }
            if(this.status){
                if(this.status=='Active'){
                    x=x.filter((a)=>{return a.active==1});
                }   else if(this.status=='In-Active'){
                    x=x.filter((a)=>{return a.active==0});
                }
                else{
                    x=x;
                }
            }
            return x;
        },
        amIOnline(e) {
            this.onLine = e;
        },
        sliceP(employees){
            // console.log(123);
            this.employeesM=employees;
            return  employees.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },
        init:function () {

            this.$http.get('/human-resource/employment/init_vue').then(result=>{
                let data=result.data;

                this.employees=data.employees;
                this.employeesR=data.employees;
                this.leng=data.employees.length;
                this.companies=data.companies;
                this.departments=data.departments;
                this.subdepartments=data.subdepartments;

            })
        },

        customerdata(){
            let v = 3;
            this.$http.post('/search/customerdatalike',{customerid:this.customer,MOC:v}).then(result=>{
                let data =result.data;
                data.filter((a)=>{a.name=a.name + ' ' + a.id + ' ' + '('+ a.hrcompany.desc + ' '+ '-' + ' ' + a.designation +')'})

                if(data){

                    this.customers=data;

                }
            });

        },
        customerdatavalue(val,m){
            this.customers=[];
            let v = 3;
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/customerdata?inv=1&MOC='+v+r,{customerid:val}).then(result=>{
                let data =result.data;

                if(data){

                    this.searchId=data.id;

                    this.customer = data.name;

                    this.alreadySearched=true;
                }
            });
        },


        designationdata(){

            this.$http.post('/search/designationdatalike',{designationid:this.designation}).then(result=>{
                let data =result.data;
                data.filter((a)=>{a.designation=a.designation})

                if(data){

                    this.designations=data;

                }
            });

        },
        designationdatavalue(val,m){
            this.designations=[];

            this.$http.post('/search/designationdata',{designationid:val}).then(result=>{
                let data =result.data;

                if(data){

                    this.desId=data.designation;

                    this.designation = data.designation;

                    this.alreadySearched2=true;
                }
            });
        },
        pluck: function (objs, name) {
            var sol = [];
            for(var i in objs){
                if(objs[i].hasOwnProperty(name)){
                    // console.log(objs[i][name]);
                    sol.push(objs[i][name]);
                }
            }
            return sol;
        },
        sum:  function (input){

            if (toString.call(input) !== "[object Array]")
                return false;

            var total =  0;
            for(var i=0;i<input.length;i++)
            {
                if(isNaN(input[i])){
                    continue;
                }
                total += Number(input[i]);
            }
            return total;
        },
        amountChange:function(k,e){
            if(parseInt(e.target.value)>parseInt(e.target.max)){
                this.invoices[k].p=e.target.max;
            }
        }
        ,
        validation:function(data,valid){
            let self=this;
            let  mm=0;
            valid.forEach((a)=> {
                if(data[a]=='' || data[a]==null){
                    self.$snotify.error(a+' is required!');
                    mm++
                }

            })
            return mm;
        },
    },
    watch:{
        employeesM:function(){
            console.log(1);
        },
        customer:function(){
            if(this.customer.length==0){
                this.alreadySearched=false;
                this.searchId=null;
            }

            if(!this.alreadySearched){
                this.customerdata();
            }
        },
        designation:function(){
            if(this.designation.length==0){
                this.alreadySearched2=false;
                this.desId=null;
            }

            if(!this.alreadySearched2){
                this.designationdata();
            }
        },
    },
    mounted() {
        if(this.id){
            this.init(this.id);

            // this.init(id.id);

        }
        else{
            this.init();

        }

    }
}
</script>
