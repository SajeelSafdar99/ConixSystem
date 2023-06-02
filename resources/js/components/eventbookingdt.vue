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

                                    <span style="color: black;">Do you really want to Delete this Booking ?</span>
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
        <div v-if="CancelTheInvoice">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title" style="color: black;">ARE YOU SURE ?</h5>
                                    <button type="button" class="close" @click="CancelTheInvoice=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <span style="color: black;">Do you really want to Cancel this Booking ?</span>
                                    <br> <br>
                                    <input placeholder="Enter Remarks" class="form-control input-height" v-model="cancel_details" id="cancel_details">

                                    <br>

                                </div>
                                <div class="modal-footer">
                                    <button @click="aftercan();" class="btn btn-outline-warning active">Yes</button>
                                    <button type="button" class="btn btn-secondary" @click="CancelTheInvoice=false">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>

        <div class="row hidden-print">

            <div class="col-lg">
                <div class="row mb-2">

                    <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input  type="radio"  name="mog" v-model="mog" value="2"><span class="pabs">All</span>
                        </label>
                    </div> <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                    <label class="rdiobox">
                        <input  type="radio"  name="mog" v-model="mog" value="0"><span class="pabs">Member</span>
                    </label>
                </div>
                    <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input type="radio" name="mog" v-model="mog" value="1"><span class="pabs">Guest</span>
                        </label>
                    </div>
                </div>
                <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">

                    <input style="margin-top: -3px;" v-model="customer" name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search by Name...">


                    <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="customers.length>0 && customer!=''" >

                        <li  :class="'fbb fba'+key"  @click="customerdatavalue(c.id)"  v-on:keyup.enter="customerdatavalue(c.id)" v-for="(c,key) in customers">
                            <a href="javascript:void(0)" v-html="c.name"></a>
                        </li>

                    </ul>
                </div>

            </div>

            <div class="col-lg">
                <p style="color: black;">Booking No.</p>
                <input value="" class="form-control tablikebutton"  size="20" type="number"
                       id="booking_no" v-model="booking_no"
                       name="booking_no" placeholder="Search Id">
            </div>
            <div class="col-lg">
                <div>
                    <p style="color: black;">Booking Date (From):</p>
                    <datepicker  v-model="start_date" :clear-button="true" placeholder="From (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>

                </div>
            </div>
            <div class="col-lg">
                <div>
                    <p style="color: black;">Booking Date (To):</p>
                    <datepicker  v-model="end_date" :clear-button="true" placeholder="To (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
                </div>
            </div>

            <div class="col-lg">
                <div>
                    <p style="color: black;">Event Date (From):</p>
                    <datepicker v-model="start_date_two" :clear-button="true" placeholder="From (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="start_date_two"></datepicker>

                </div>
            </div>
            <div class="col-lg">
                <div>
                    <p style="color: black;">Event Date (To):</p>
                    <datepicker v-model="end_date_two" :clear-button="true" placeholder="To (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="end_date_two"></datepicker>
                </div>
            </div>


        </div>


        <div class="row hidden-print">
            <div class="col-lg">

                <multiselect track-by="name" label="name" placeholder="Choose Venues" v-model="venue" :multiple="true" :options="(()=>{let x=[];
            venues.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>
            </div>
            <div class="col-lg">
                <multiselect track-by="name" label="name" placeholder="Choose Users" v-model="user" :multiple="true" :options="(()=>{let x=[];
            users.forEach((a)=>{
                x.push({name:a.name,id:a.id})
            })
            return x;
            })()"></multiselect>
            </div>

            <div v-if="this.exported" class="col-xs">

                <export-excel
                    class   = "btn btn-primary"
                    :data   = "json_data"
                    worksheet = "My Worksheet"
                    name    = "EventBookings.xls">
                </export-excel>
                <!--    <button type="button" class=" btn btn-primary"><i class="fa fa-file"></i> Export</button>-->
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
                        <th class="wd-5p">BOOKING #</th>
                        <th class="wd-10p">BOOKING DATE</th>
                        <th class="wd-15p">NAME</th>
                        <th class="wd-10p">CUSTOMER TYPE</th>
                        <th class="wd-15p">VENUE</th>
                        <th class="wd-15p">MENU</th>
                        <th class="wd-10p">EVENT DATE</th>
                        <th class="wd-10p">TIMING (FROM)</th>
                        <th class="wd-10p">TIMING (TO)</th>
                        <th class="wd-10p">GRAND TOTAL</th>
                        <th class="wd-10p">STATUS</th>
                        <th class="wd-10p">USER</th>
                        <th class="wd-5p hidden-print">INVOICE</th>
                        <th class="wd-5p hidden-print">CANCEL</th>
                        <th class="wd-5p hidden-print">EDIT</th>
                        <th class="wd-5p hidden-print">DELETE</th>
                    </tr>
                    </thead>
                    <tbody :style="'font-size:15px'">
                    <tr v-for="(tr,key) in

                sliceP(
                     (()=>{
                      let  x=filterData(collection);

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
                        <td>{{tr.booking_no}}</td>
                        <td>{{moment(tr.booking_date).format('DD/MM/YYYY')}}</td>
                        <template v-if="tr.booking_type==0">
                            <td>{{tr.tname}} {{tr.fname}} {{tr.mname}} {{tr.lname}}</td>
                        </template>
                        <template v-else-if="tr.booking_type==1">
                            <td>{{tr.customer}}</td>
                        </template>
                        <template v-else>
                            <td></td>
                        </template>

                        <template v-if="tr.booking_type==1">
                            <td>Guest ({{tr.customer_id}})</td>
                        </template>
                        <template v-else-if="tr.booking_type==0">
                            <td>Member ({{tr.mem_no}}) - {{tr.activity}}</td>
                        </template>
                        <template v-else>
                            <td></td>
                        </template>

                        <td>{{tr.venue}}</td>
                        <td>{{tr.menu}}</td>
                        <td>{{moment(tr.event_date).format('DD/MM/YYYY')}}</td>
                        <td>{{tr.from}}</td>
                        <td>{{tr.to}}</td>
                        <td>{{tr.grand_total}}</td>

                        <td><button title="Check Out Event" class="btn btn-sm btn-outline-danger active"><a style="color:white;" target="_blank" :href="'/events-management/event-booking/event-checkout-aeu/'+tr.id">Done</a></button></td>

                        <td>{{tr.user}}</td>
                        <td class="hidden-print"><button class="buttoncolor" title="Print Invoice"><a style="color:#000000;" target="_blank" :href="'/events-management/event-booking/invoice/' + tr.id"><i class="fa fa-print" aria-hidden="true"></i></a></button></td>
                        <td class="hidden-print"><button class="buttoncolor" @click="cancelme(tr.id,tr.cancel_details);" title="Cancel"><i class="fas fa-times"></i></button></td>
                        <td class="hidden-print"><button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" :href="'/events-management/event-booking/event-booking-aeu/' + tr.id"><i class="fas fa-edit"></i></a></button></td>
                        <td class="hidden-print"><button class="buttoncolor" @click="deleteme(tr.id,tr.additional_notes);" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
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
                                <option :value="collection.length" >ALL</option>
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

export default {
    name: "eventbookingdt",
    props: [],
    json_data: [],
    data(){
        return{
            page:1,
            pagelength:50,
            leng:0,
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            collection:[],
            collectionR:[],
            collectionM: [],
            booking_no:'',
            start_date:'',
            end_date:'',
            start_date_two:'',
            end_date_two:'',
            customers:[],
            customer:'',
            mog:2,
            searchId:null,
            fkey:-1,
            ffkey:0,
            deletethisid:'',
            DeleteTheInvoice:false,
            remarks:'',
            venues:[],
            venue:[],
            users:[],
            user:[],
            exported:'',
            json_data: [],
            cancelthisid:'',
            CancelTheInvoice:false,
            cancel_details:'',
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
            let url='/events-management/event-booking/delete/'+this.deletethisid;
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
        cancelme: function (k,com) {
            this.CancelTheInvoice=true;
            this.cancelthisid=k;
            this.cancel_details=com;
        },
        aftercan:function(){
            let data={
                cancel_details:this.cancel_details
            };
            let url='/events-management/event-booking/event-cancel/'+this.cancelthisid;
            if(this.validation(data,['cancel_details'])==0){
                this.CancelTheInvoice=false;
                this.$http.post(url,data).then(result=> {
                    this.init();
                });
            }
        },
        filterData(collection){
            let   x=collection;
            if(this.booking_no){
                x=x.filter((a)=>{
                    let self = this;
                    return (String(a.booking_no)).startsWith(self.booking_no)});
            }


            if(this.user.length>0){
                x=x.filter((a)=>{return this.user.filter((m)=>{
                    return a.created_by==m.id;
                }).length>0});

            }

            if(this.venue.length>0){
                x=x.filter((a)=>{return this.venue.filter((m)=>{
                    return a.venue==m.name;
                }).length>0});
            }
            if(this.start_date){
                x=x.filter((a)=>{return moment(a.booking_date,'YYYY-MM-DD').format('x')>=moment(moment(this.start_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});

            }
            if(this.end_date){
                x=x.filter((a)=>{return moment(a.booking_date,'YYYY-MM-DD').format('x')<=moment(moment(this.end_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }

            if(this.start_date_two){
                x=x.filter((a)=>{return moment(a.event_date,'YYYY-MM-DD').format('x')>=moment(moment(this.start_date_two).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});

            }
            if(this.end_date_two){
                x=x.filter((a)=>{return moment(a.event_date,'YYYY-MM-DD').format('x')<=moment(moment(this.end_date_two).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }

            if (this.searchId){
                if(this.mog==0){
                    x=x.filter((a)=>{return a.member_id==this.searchId});
                }
                else if(this.mog==1){
                    x=x.filter((a)=>{return a.customer_id==this.searchId});
                }
            }
            if(this.mog!=2) {

                x=x.filter((a)=>{
                    if(this.mog==1)
                        return a.booking_type==1
                    else if(this.mog==0)
                        return a.booking_type==0
                });
            }
            else{
                x=x;
            }
            return x;
        },
        amIOnline(e) {
            this.onLine = e;
        },
        sliceP(collection){
            // console.log(123);
            this.collectionM=collection;
            return  collection.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },
        init:function () {

            this.$http.get('/events-management/event-booking/init_vue').then(result=>{
                let data=result.data;

                this.collection=data.collection;
                this.collectionR=data.collection;
                this.leng=data.collection.length;
                this.users=data.users;
                this.venues=data.venues;
                this.exported=data.exported;
                this.json_data=data.sales;

            })
        },

        customerdata(){
            let v = this.mog;
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
                else if(v==1){
                    data.filter((a)=>{a.name=a.customer_name + ' ' + a.id})
                }
                if(data){

                    this.customers=data;

                }
            });

        },
        customerdatavalue(val,m){
            this.customers=[];
            let v = this.mog;
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/customerdata?inv=0&MOC='+v+r,{customerid:val}).then(result=>{
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

                    }
                    else if (v == 1) {
                        this.customer_id = data.id;
                        this.customer = data.customer_name;
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
        collection:function(){
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

