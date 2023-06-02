<template>
<div>
    <vue-snotify></vue-snotify>
<!--    <div class="hidden-print">
    <v-offline
        online-class="online"
        offline-class="offline"
        @detected-condition="amIOnline">
        <template v-slot:[onlineSlot] :slot-name="onlineSlot">
            ( Online: {{ onLine }} )
        </template>
        <template v-slot:[offlineSlot] :slot-name="offlineSlot">
            ( Online: {{ onLine }} )
        </template>
    </v-offline>
        <br>
    </div>-->



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
            <div class="form-group"  v-on:keydown.up.prevent="udf2(1)" v-on:keydown.down.prevent="udf2(0)">


                <input  v-model="fcustomer" name="fcustomer" id="fcustomer" value="" class="typeahead form-control" autocomplete="off" type="text"  placeholder="Search By Name...">


                <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="fcustomers.length>0 && fcustomer!=''" >

                    <li class="fbb" :class="'ccs'+key"  @click="fcustomerdatavalue(c.id)"  v-on:keyup.enter="fcustomerdatavalue(c.id)" v-for="(c,key) in fcustomers">
                        <a href="javascript:void(0)">   {{c.name}}</a>
                    </li>

                </ul>


            </div>


        </div>

        <div class="col-lg">

            <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">


                <input  v-model="customer" name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search By Member...">


                <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="customers.length>0 && customer!=''" >

                    <li  :class="'fbb fba'+key"  @click="customerdatavalue(c.id)"  v-on:keyup.enter="customerdatavalue(c.id)" v-for="(c,key) in customers">
                        <a href="javascript:void(0)" v-html="c.name"></a>
                    </li>

                </ul>


            </div>

        </div>


        <div class="col-lg">

            <input value="" autocomplete="off" class="form-control "  size="20" type="text"
                   id="cnic" v-model="cnic"
                   name="cnic" placeholder="Search CNIC">
        </div>
        <div class="col-lg">

            <input value="" autocomplete="off" class="form-control "  size="20" type="number"
                   id="contact" v-model="contact"
                   name="contact" placeholder="Search Contact">
        </div>


    </div>

    <div class="row hidden-print">

        <div class="col-lg">
        <div class="row">
            <div class="col-md-7">
            <input value="" class="form-control "  size="20" type="number"
                   id="ageno" v-model="ageno" autocomplete="off"
                   name="ageno" placeholder="Search by Age">
            </div>
            <div class="col-md-2">
            <input type="checkbox" class="form-control input-height" v-model="overage">
            </div>
            <div class="col-md-3">
                <span>Over 25 years of Age</span>
            </div>
        </div>
        </div>


        <div class="col-lg">
            <!-- <p style="color: black;">Card Status:</p>-->
            <multiselect track-by="name" label="name" placeholder="Choose Relationship" v-model="relationship" :multiple="true" :options="(()=>{let x=[];
            relationships.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>

        </div>

        <div class="col-lg">
            <multiselect track-by="name" label="name" placeholder="Choose Gender" v-model="gender" :multiple="true" :options="(()=>{let x=[];
            ['Male','Female','Other'].forEach((a)=>{
                x.push({name:a})
            })
            return x;
            })()"></multiselect>

        </div>

        <div class="col-lg">
            <!-- <p style="color: black;">Card Status:</p>-->
            <multiselect track-by="name" label="name" placeholder="Choose Card Status" v-model="card_status" :multiple="true" :options="(()=>{let x=[];
            cardstati.forEach((a)=>{
                x.push({name:a})
            })
            return x;
            })()"></multiselect>

        </div>

        <div class="col-lg">
            <!-- <p style="color: black;">Status:</p>-->
            <multiselect track-by="name" label="name" placeholder="Choose Status" v-model="status" :multiple="true" :options="(()=>{let x=[];
            stati.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>


        </div>
<!--        <div class="col-lg">
            <div>
                <select v-model="status"  class="form-control">
                    <option v-for="s in ['All','Active','In-Active']">{{s}}</option>
                </select>
            </div>
        </div>-->

    </div>
    <br>
    <div class="scrollclasstable1">

        <div>


            <table class="table-striped table-bordered table-hover ">
                <thead :style="'font-size:15px'">
                <tr>

                    <th class="wd-5p">SR #</th>
                    <th class="wd-5p">ID</th>
                    <th class="wd-10p">CARD NO.</th>
                    <th class="wd-15p">NAME</th>
                    <th class="wd-5p">AGE</th>
                    <th class="wd-15p">MEMBER NAME</th>
                    <th class="wd-5p">RELATIONSHIP</th>
                    <th class="wd-10p">CNIC #</th>
                    <th class="wd-10p">CONTACT</th>
                    <th class="wd-10p">DATE OF BIRTH</th>
                    <th class="wd-10p">CARD ISSUED DATE</th>
                    <th class="wd-5p">CARD STATUS</th>
                    <th class="wd-10p">BARCODE NO.</th>
                    <th class="wd-15p">PICTURE</th>
                    <th class="wd-15p">STATUS</th>
                    <th class="wd-10p">USER</th>
                </tr>
                </thead>
                <tbody :style="'font-size:15px'">
                <tr v-for="(tr,key) in

                sliceP(
                     (()=>{
                      let  x=filterData(memberships);

                   leng=x.length;
                  if(parseInt(leng/pagelength)+((leng%pagelength)>0?1:0)<page){
                      page=1;
                  }

                      //

                     return x;
                    })()

                    )" >
<!--                    <td>{{key+1}}</td>-->
                    <td>{{((page-1)*pagelength)+key+1}}</td>
                    <td>{{tr.id}}</td>
                    <td>{{tr.sup_card_no}}</td>
                    <td>{{tr.title}} {{tr.first_name}} {{tr.middle_name}} {{tr.name}}</td>
                    <td>{{tr.age}}</td>
                    <td>{{tr.mttitle}} {{tr.mfname}} {{tr.mmname}} {{tr.amname}}</td>
                    <td>{{tr.relation}}</td>
                    <td>{{tr.cnic}}</td>
                    <td>{{tr.contact}}</td>
                    <td>{{moment(tr.date_of_birth).format('DD/MM/YYYY')}}</td>
                    <td>{{moment(tr.sup_card_issue).format('DD/MM/YYYY')}}</td>

                    <td>{{tr.card_status}}</td>
                    <td>{{tr.sup_barcode}}</td>
                    <td>
                        <template v-if="tr.image!=''">
                            <img style="width: 100px;" :src="'/'+tr.image">
                        </template>

                    </td>

                    <template v-if="tr.active=='Active' || tr.active=='active' || tr.active=='ACTIVE'">
                        <td><button class="btnwidth btn btn-sm btn-outline-success active btn-block mg-b-10" title="Status">{{tr.active}}</button></td>
                    </template>
                    <template v-else>
                        <td><button class="btnwidth btn btn-sm btn-outline-danger active btn-block mg-b-10" title="Status">{{tr.active}}</button></td>
                    </template>

<!--<template v-if="tr.status==1">
    <td><button class="btnwidth btn btn-outline-success active btn-block mg-b-10" title="Status">Active</button></td>
</template>
                    <template v-else>
                        <td><button class="btnwidth btn btn-outline-danger active btn-block mg-b-10" title="Status">In-Active</button></td>
                    </template>-->


                    <td>{{tr.cashiername}}</td>
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
                                <option :value="memberships.length" >ALL</option>
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
</style>
<script>
import Datepicker from 'vuejs-datepicker';
    export default {
        name: "familymembershipdt",
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
                memberships:[],
                membershipsR:[],
                membershipsM: [],
                barcode:'',
                memberid:'',
                cnic:'',
                contact:'',
                carno:'',
                customers:[],
                fcustomers:[],
                customer:'',
                fcustomer:'',
                mog:2,
                searchId:null,
                famsearchId:null,
                categories:[],
                category:[],
                stati:[],
                status:[],
                cardstati:[ "Issued",
                    "Applied",
                    "Printed",
                    "Re-Printed",
                    "Not Applied",
                    "Expired",
                    "Not Applicable"
                ] ,
                card_status :[],
                gender :[],
                fkey:-1,
                ffkey:0,
                ageno:'',
                overage:false,
                relationship :[],
                relationships :[],
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




            },udf2(event){

                if(event==0){
                    if(this.ffkey!=this.fcustomers.length-1){

                        this.ffkey=this.ffkey+1
                    }
                    $('.ccs'+this.ffkey +' a').focus();

                    // $('.fba'+this.ffkey).focus();
                    // event.preventDefault()
                }if(event==1){

                    if(this.ffkey!=0){

                        this.ffkey=this.ffkey-1
                    }
                    $('.ccs'+this.ffkey+' a').focus();

                    // event.preventDefault()
                }


            },
            filterData(memberships){
             let   x=memberships;

                if(this.relationship.length==0 && this.status.length==0 && this.card_status.length==0 && this.gender.length==0 && !this.barcode && !this.memberid && !this.overage && !this.ageno && !this.cnic && !this.contact && !this.searchId && !this.famsearchId)
                {
                    return [];
                }
              /*  if(this.status){
                    if(this.status=='Active')
                    {
                        x=x.filter((a)=>{return a.status==1});

                    }
                    else if(this.status=='In-Active')
                        {
                        x=x.filter((a)=>{return a.status==0});

                    }
                    else{
                        x=x;
                    }
                    return x;
                }*/

                if(this.status.length>0){
                    x=x.filter((a)=>{return this.status.filter((m)=>{
                        return a.status==m.id;
                    }).length>0});

                }

                if(this.relationship.length>0){
                    x=x.filter((a)=>{return this.relationship.filter((m)=>{
                        return a.relation==m.name;
                    }).length>0});

                }

                if(this.card_status.length>0){
                    x=x.filter((a)=>{return this.card_status.filter((m)=>{
                        return a.card_status==m.name;
                    }).length>0});

                }

                if(this.gender.length>0){
                    x=x.filter((a)=>{return this.gender.filter((m)=>{
                        return a.gender==m.name;
                    }).length>0});

                }

                if(this.barcode){

                    x=x.filter((a)=>{
                        return a.sup_barcode?a.sup_barcode.split(',').indexOf(this.barcode.toString())!=-1:false
                    });

                }

                if(this.memberid){
                    x=x.filter((a)=>{
                        let self = this;
                        return (String(a.id)).startsWith(self.memberid)});

                }

                if(this.overage){
                    x=x.filter((a)=>{return a.age>25});

                }

                if(this.ageno){
                    x=x.filter((a)=>{
                        let self = this;
                        return (String(a.age)).startsWith(self.ageno)});

                }


                if(this.cnic){
                    x=x.filter((a)=>{
                        let self = this;
                        return (String(a.cnic)).startsWith(self.cnic)});

                }

                if(this.contact){
                    x=x.filter((a)=>{
                        let self = this;
                        return (String(a.contact)).startsWith(self.contact)});

                }

                if (this.searchId){
                    x=x.filter((a)=>{return a.member_id==this.searchId});

                }

                if (this.famsearchId){
                    x=x.filter((a)=>{return a.id==this.famsearchId});

                }

                return x;

            },
            amIOnline(e) {
                this.onLine = e;
            },
            sliceP(memberships){
                // console.log(123);
                this.membershipsM=memberships;
              return  memberships.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
            },
            init:function () {

                this.$http.get('/club-hospitality/family-membership/fam_init_vue').then(result=>{
                    let data=result.data;

                    this.categories=data.categories;
                    this.stati=data.stati;
                    this.relationships=data.relationships;
                    this.memberships=data.memberships;
                    this.membershipsR=data.memberships;
                    this.leng=data.memberships.length;
                })
            },

            customerdata(){
                let v = 0;
                this.$http.post('/search/customerdatalike',{customerid:this.customer,MOC:v}).then(result=>{
                    let data =result.data;
                    if(v==0){
                        data.filter((a)=>{
                            let fname=a.first_name?a.first_name+' ':'';
                            let mname=a.middle_name?a.middle_name+' ':'';
                            let lname=a.applicant_name?a.applicant_name:'';
                            let fullname=fname+mname+lname;

                            a.name=fullname + ':' + a.mem_no + ' ' + '<span style="color: '+a.mem_status.color+'">(' + a.mem_status.desc + ')</span>'
                            a.color=a.mem_status.color
                        })
                    }

                    if(data){

                        this.customers=data;

                    }
                });

            },
            customerdatavalue(val,m){
                this.customers=[];
                let v = 0;
                let r='';

                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/customerdata?inv=1&MOC='+v+r,{customerid:val}).then(result=>{
                    let data =result.data;

                    if(data){

                        this.searchId=data.id;

                        if (v == 0) {
                            this.mem_id = data.mem_no;
                            this.mem_id_ = data.id;
                            let fname=data.first_name?data.first_name+' ':'';
                            let mname=data.middle_name?data.middle_name+' ':'';
                            let lname=data.applicant_name?data.applicant_name:'';

                            this.customer = fname+mname+lname;
                            this.guest_contact = data.mob_a;

                        }


                        this.alreadySearched=true;
                    }
                });
            },
            fcustomerdata(){
                this.$http.post('/search/famcustomerdatalike',{customerid:this.fcustomer}).then(result=>{
                    let data =result.data;

                        data.filter((a)=>{
                            let fname=a.first_name?a.first_name+' ':'';
                            let mname=a.middle_name?a.middle_name+' ':'';
                            let lname=a.name?a.name:'';
                            let fullname=fname+mname+lname;

                            if(a.status==1){
                                a.name=fullname + ':' + a.sup_card_no + ' ' + '(' + 'Active' + ')'
                            }
                            else if(a.status==2){
                                a.name=fullname + ':' + a.sup_card_no + ' ' + '(' + 'In-Active' + ')'
                            }

                        })

                    if(data){

                        this.fcustomers=data;

                    }
                });

            },
            fcustomerdatavalue(val,m){
                this.fcustomers=[];

                this.$http.post('/search/famcustomerdata?inv=1',{customerid:val}).then(result=>{
                    let data =result.data;

                    if(data){
                        this.famsearchId=data.id;

                            let fname=data.first_name?data.first_name+' ':'';
                            let mname=data.middle_name?data.middle_name+' ':'';
                            let lname=data.name?data.name:'';

                            this.fcustomer = fname+mname+lname;
                            this.guest_contact = data.contact;


                        this.falreadySearched=true;
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
            membershipsM:function(){
                console.log(1);
            },
            customer:function(){
                if(this.customer.length==0){
                    this.alreadySearched=false;
                    this.searchId=null;
                }

                if(this.customer.length>2 && !this.alreadySearched){
                    this.customerdata();
                }
            },
            fcustomer:function(){
                if(this.fcustomer.length==0){
                    this.falreadySearched=false;
                    this.famsearchId=null;
                }

                if(this.fcustomer.length>2 && !this.falreadySearched){
                    this.fcustomerdata();
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

