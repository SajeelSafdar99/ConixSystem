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

                                <span style="color: black;">Do you really want to Delete this Membership ?</span>
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

                <input value="" class="form-control "  size="20" type="text"
                       id="barcode" autocomplete="off" v-model="barcode"
                       name="barcode" placeholder="Search Barcode">
        </div>

        <div class="col-lg">

            <input value="" class="form-control "  size="20" type="text"
                   id="kinshipid" autocomplete="off" v-model="kinshipid"
                   name="kinshipid" placeholder="Search ID">
        </div>
<!--        <div class="col-lg">

            <input value="" class="form-control "  size="20" type="number"
                   id="memberid" v-model="memberid" autocomplete="off"
                   name="memberid" placeholder="Search Member ID">
        </div>-->

        <div class="col-lg">

            <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">

                <input  v-model="customer" name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search Name / Mem Number...">


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
        <div class="col-lg">

            <input value="" autocomplete="off" class="form-control "  size="20" type="text"
                   id="carno" v-model="carno"
                   name="carno" placeholder="Search Car Number">
        </div>

    </div>


    <div class="row hidden-print">
        <div class="col-lg">

            <input value="" class="form-control" type="number"
                   id="duration" v-model="duration" autocomplete="off"
                   name="duration" placeholder="Search Duration (Years)">
        </div>

        <div class="col-lg">
            <!-- <p style="color: black;">Category:</p>-->
            <multiselect track-by="name" label="name" placeholder="Choose Category" v-model="category" :multiple="true" :options="(()=>{let x=[];
            categories.forEach((a)=>{
                x.push({name:a.desc+' '+'-'+' '+a.unique_code,id:a.id})
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

                <select v-model="kinship"  class="form-control">
                    <option v-for="s in ['Choose Option','Include Kinships','Exclude Kinships','Only Kinships']">{{s}}</option>
                </select>
            </div>
        </div>-->

        <div class="col-xs">
            <div class="row">
        <div class="col-md-2">
            <input type="checkbox"   v-model="expired">
        </div>
        <div class="col-md-2">
            <span>Expired Corporate Memberships</span>
        </div>
            </div>
        </div>

    </div>
    <br>
    <div class="scrollclasstable1">

        <div>


            <table class="table-striped table-bordered table-hover ">
                <thead :style="'font-size:15px'">
                <tr>

                    <th class="wd-5p">SR #</th>
                    <th class="wd-5p">ID</th>
                    <th class="wd-10p">COMPANY</th>
                    <th class="wd-10p">MEMBERSHIP NO.</th>
                    <th class="wd-15p">MEMBER NAME</th>
                    <th class="wd-10p">MEMBERSHIP DURATION</th>
                    <th class="wd-10p">CATEGORY</th>
                    <th class="wd-10p">CNIC #</th>
                    <th class="wd-10p">CONTACT</th>
                    <th class="wd-10p">MEMBERSHIP DATE</th>
                    <th class="wd-10p">MEMBER TYPE</th>
                    <th class="wd-5p">FAMILY MEMBERS</th>
                    <th class="wd-10p">CARD STATUS</th>
                    <th class="wd-15p">PICTURE</th>
                    <th class="wd-10p">STATUS</th>
                    <th class="wd-10p">USER</th>
                    <th class="wd-5p hidden-print">VIEW</th>
                    <th class="wd-5p hidden-print">EDIT</th>
                    <th class="wd-5p hidden-print">DELETE</th>
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
                    <td>{{((page-1)*pagelength)+key+1}}</td>
                    <td>{{tr.id}}</td>
                    <td>{{tr.corporate}}</td>
                    <td>{{tr.mem_no}}</td>
                    <td>{{tr.title}} {{tr.first_name}} {{tr.middle_name}} {{tr.applicant_name}}</td>
                    <td><span v-if="tr.duration_year">{{tr.duration_year}} year(s)</span>
                        <template v-if="tr.duration_year && tr.duration_month">{{tr.duration_month-(tr.duration_year*12)}} month(s)</template>
                        <template v-else-if="!tr.duration_year && tr.duration_month">{{tr.duration_month}} month(s)</template>
                        <template v-else></template>
                    </td>
                    <td>{{tr.memcategoryid}}</td>
                    <td>{{tr.cnic}}</td>
                    <td>{{tr.mob_a}}</td>
                    <td>{{moment(tr.membership_date).format('DD/MM/YYYY')}}</td>
                    <td>{{tr.memclassificationid}}</td>

                    <td><a target="_blank" :href="'/club-hospitality/corporate-membership/corporate-familymember-aeu/' + tr.id">{{tr.famcount}}</a></td>

                    <td>{{tr.card_status}}</td>
                    <td>
                        <template v-if="tr.image!=''">
                            <img style="width: 100px;" :src="'/'+tr.image">
                        </template>

                    </td>

<template v-if="tr.activestatus=='Active' || tr.activestatus=='active' || tr.activestatus=='ACTIVE'">
    <td><button class="btnwidth btn btn-outline-success active btn-block mg-b-10" title="Status">{{tr.activestatus}}</button></td>
</template>
                    <template v-else>
                        <td><button class="btnwidth btn btn-outline-danger active btn-block mg-b-10" title="Status">{{tr.activestatus}}</button></td>
                    </template>

                    <td>{{tr.cashiername}}</td>
                    <td class="hidden-print"><button class="buttoncolor" title="View"><a style="color:#000000;" target="_blank" :href="'/club-hospitality/corporate-membership/corporate-membership-view/' + tr.id"><i class="fas fa-eye"></i></a></button></td>
                    <td class="hidden-print"><button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" :href="'/club-hospitality/corporate-membership/corporate-membership-aeu/' + tr.id"><i class="fas fa-edit"></i></a></button></td>
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
.block-col{

    height: 10px;
    width: 10px;
    display: block;
    float: left;
    margin: 3px;
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
        name: "corporatemembershipdt",
        components: {
            Datepicker
        },
        props: [],
        data(){
            return{
                kinship:'Choose Option',
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
                kinshipid:'',
                memberid:'',
                cnic:'',
                contact:'',
                carno:'',
                customers:[],
                customer:'',
                mog:2,
                searchId:null,
                categories:[],
                category:[],
                stati:[],
                status:[],
                cardstati:[ "In-Process",
                    "Printed",
                    "Received",
                    "Issued",
                    "Re-Printed"] ,
                card_status:[],
                fkey:-1,

                ffkey:0,
                duration:'',
                deletethisid:'',
                DeleteTheInvoice:false,
                remarks:'',
                expired:false,
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
                let url='/club-hospitality/corporate-membership/delete/'+this.deletethisid;
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
            filterData(memberships){
             let   x=memberships;
                let CurrentDate = new Date();

             if(this.category.length==0  && this.expired==false && this.status.length==0 && this.card_status.length==0 && !this.barcode && !this.kinshipid && !this.memberid && !this.duration && !this.cnic && !this.contact && !this.carno && !this.searchId && this.kinship=='Choose Option')
             {
                 return [];
             }
                if(this.category.length>0){
                    x=x.filter((a)=>{return this.category.filter((m)=>{
                        return a.mem_category_id==m.id;
                    }).length>0});

                }

                if(this.expired){

                    console.log(CurrentDate);
                    x=x.filter((a)=>{
if(  moment(a.card_exp).isBefore(CurrentDate)==true){
    return  moment(a.card_exp).format("dd-mm-yyyy") <= moment(CurrentDate).format("dd-mm-yyyy")
}


                          /* return  moment(a.card_exp).format("dd-mm-yyyy") <= moment(CurrentDate).format("dd-mm-yyyy")*/  });
                }



                if(this.status.length>0){
                    x=x.filter((a)=>{return this.status.filter((m)=>{
                        return a.active==m.id;
                    }).length>0});

                }

                if(this.card_status.length>0){
                    x=x.filter((a)=>{return this.card_status.filter((m)=>{
                        return a.card_status==m.name;
                    }).length>0});
                }

                if(this.kinship){
                    if(this.kinship=='Choose Option'){
                       /* x=x.filter((a)=>{return a.id!=null});*/
                    } else if(this.kinship=='Include Kinships'){
                        x=x.filter((a)=>{return a.id!=null});
                    }   else if(this.kinship=='Exclude Kinships'){
                        x=x.filter((a)=>{return a.kinship==null});
                    }   else if(this.kinship=='Only Kinships'){
                        x=x.filter((a)=>{return a.kinship!=null});
                    }
                    else{
                        x=x;
                    }
                }

                if(this.barcode){

                    x=x.filter((a)=>{
                        if(a.mem_barcode==this.barcode)
                        {
                            return a.mem_barcode==this.barcode
                        }
                        else{
                            return a.supbarcode?a.supbarcode.split(',').indexOf(this.barcode.toString())!=-1:false
                        }

                           });

                }

                /*if(this.memberid){
                    x=x.filter((a)=>{return a.id==this.memberid});

                }*/

                if(this.kinshipid){
                    x=x.filter((a)=>{return a.id==this.kinshipid});
                }

                if(this.memberid){
                    x=x.filter((a)=>{
                        let self = this;
                        return (String(a.id)).startsWith(self.memberid)});

                }

                if(this.duration){
                    x=x.filter((a)=>{
                        let self = this;
                        return (String(a.duration_year)).startsWith(self.duration)});

                }

                if(this.cnic){
                    x=x.filter((a)=>{
                        let self = this;
                        return (String(a.cnic)).startsWith(self.cnic)});

                }
                /*if(this.cnic){
                    x=x.filter((a)=>{return a.cnic==this.cnic});

                }*/

                if(this.contact){
                    x=x.filter((a)=>{
                        let self = this;
                        return (String(a.mob_a)).startsWith(self.contact)});

                }
                /*if(this.contact){
                    x=x.filter((a)=>{return a.mob_a==this.contact});

                }*/
                if(this.carno){
                    x=x.filter((a)=>{return  a.carno?a.carno.split(',').indexOf(this.carno.toString())!=-1:false});

                }

                if (this.searchId){
                    x=x.filter((a)=>{return a.id==this.searchId});

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

                this.$http.get('/club-hospitality/corporate-membership/init_vue').then(result=>{
                    let data=result.data;

                    this.categories=data.categories;
                    this.stati=data.stati;
                    this.memberships=data.memberships;
                    this.membershipsR=data.memberships;
                    this.leng=data.memberships.length;
                })
            },

            customerdata(){
                let v = 0;
                this.$http.post('/search/corporatemem/datalike',{customerid:this.customer,MOC:v}).then(result=>{
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
                this.$http.post('/search/corporatemem/data?inv=1&MOC='+v+r,{customerid:val}).then(result=>{
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

