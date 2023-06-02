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

                                    <span style="color: black;">Do you really want to Delete this Lead ?</span>
                                    <br> <br>
                                    <input placeholder="Enter Remarks" class="form-control input-height" v-model="remark" id="remark">

                                    <br>

                                </div>
                                <div class="modal-footer" style="display:inherit;">
                                    <button @click="afterdel();" class="btn btn-outline-warning active">Yes</button>
                                    <button type="button" class="btn btn-secondary" @click="DeleteTheInvoice=false">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>

        <div v-if="showCallTime">
            <transition name="modal">
                <div class="modal-mask" style="color: black;" id="callmodall">
                    <div class="modal-wrapper">
                        <div class="modal-dialog" style="max-width: 735px !important;">
                            <div class="modal-content" style=" width: 800px !important;">
                                <div class="modal-header">

                                    <h5 class="modal-title" >CALL DETAILS:</h5>
                                    <button type="button" class="close" @click="showCallTime=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <br>

                                    <div class="row">
                                        <label class="col-sm-2 form-control-label">Call Time:</label>
                                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                            <input  name="call_time"  :value="new Date() | moment('DD/MM/YYYY HH:mm:ss')" class="form-control input-height" readonly>
                                        </div>
                                        <label class="col-sm-2 form-control-label">Response:</label>
                                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                            <select v-model="call_status" id="call_status" name="call_status" class="form-control">
                                                <option v-for="r in responses" :value="r.id">
                                                    {{r.desc}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                    <label class="col-sm-2 form-control-label">Follow Up Date:</label>
                                    <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                        <input type="datetime-local" v-model="follow_up" id="follow_up" name="follow_up" class="form-control">
<!--                                    <datetime v-model="follow_up" ref="dateandtime" name="follow_up" format="DD/MM/YYYY h:i:s"></datetime>-->
                                    </div>
                                    <label class="col-sm-2 form-control-label">Remarks:</label>
                                    <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                        <textarea class="form-control" v-model="remarks" placeholder="Enter Details" rows="2" type="text" name="remarks"></textarea>
                                    </div>
                                    </div>

                                    <hr>
                                    <button type="button" class="btn btn-info" :disabled="disableds" @click="call()">Save</button>
                                    <button type="button" class="btn btn-secondary" @click="showCallTime=false">Cancel</button>
                               <br> <br>
                                    <div class="scrollclasstable1" :class="{scrollclasstable2: this.selected_items.length>0 }">
                                        <div>
                                            <table class="table-bordered">
                                                <thead :style="'font-size:16px'">
                                                <tr>
                                                    <th class="wd-10p" bgcolor="#969696 !important">CALL TIME</th>
                                                    <th class="wd-10p" bgcolor="#969696 !important">RESPONSE</th>
                                                    <th class="wd-10p" bgcolor="#969696 !important">FOLLOW UP</th>
                                                    <th class="wd-20p" bgcolor="#969696 !important">REMARKS</th>
                                                </tr>
                                                </thead>
                                                <tbody :style="'font-size:15px'">
                                                <tr v-if="tr.lead_id==callthisid" v-for="(tr,key) in selected_items">
                                                    <td >{{tr.call_time}}  <input type="hidden" v-model="tr.hid"></td>
                                                    <td>{{responses.filter(function(a){return a.id==tr.call_status})[0].desc}}</td>
                                                    <td>{{moment(tr.follow_up).format('DD/MM/YYYY HH:mm:ss')}}</td>
                                                    <td>{{tr.remarks}}</td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <div v-if="showVisits">
            <transition name="modal">
                <div class="modal-mask" style="color: black;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog" style="max-width: 735px !important;">
                            <div class="modal-content" style=" width: 800px !important;">
                                <div class="modal-header">

                                    <h5 class="modal-title" >VISIT DETAILS:</h5>
                                    <button type="button" class="close" @click="showVisits=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <br>
                                    <div class="row">
                                        <label class="col-sm-2 form-control-label">Dated:</label>
                                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                            <input  name="visit_time"  :value="new Date() | moment('DD/MM/YYYY HH:mm:ss')" class="form-control input-height" readonly>
                                        </div>
                                        <label class="col-sm-2 form-control-label">Visit Date:</label>
                                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                            <input type="datetime-local" v-model="visit_date" id="visit_date" name="visit_date" class="form-control">
                                            <!--                                            <datetime v-model="visit_date" ref="visitdate" name="visit_date" format="DD/MM/YYYY h:i:s"></datetime>-->
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">

                                        <label class="col-sm-2 form-control-label">Next Visit Date:</label>
                                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                            <input type="datetime-local" v-model="next_visit" id="next_visit" name="next_visit" class="form-control">
<!--                                            <datetime v-model="next_visit" ref="nextvisit" name="next_visit" format="DD/MM/YYYY h:i:s"></datetime>-->
                                        </div>

                                        <label class="col-sm-2 form-control-label">Quoted Membership Amount:</label>
                                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                            <input class="form-control input-height" placeholder="Enter Amount" v-model="membership_amount" name="membership_amount" id="membership_amount" type="number">
                                        </div>

                                    </div>



                                    <div class="row">

                                        <label class="col-sm-2 form-control-label">Advance Amount:</label>
                                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                            <input class="form-control input-height" placeholder="Enter Amount" v-model="advance_amount" name="advance_amount" id="advance_amount" type="number">
                                        </div>

                                        <label class="col-sm-2 form-control-label">Remaining Amount:</label>
                                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                            <input class="form-control input-height" placeholder="Enter Amount" readonly :value="parseInt(membership_amount)-parseInt(advance_amount)" name="remaining_amount" id="remaining_amount" type="number">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 form-control-label">Remarks:</label>
                                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                            <textarea class="form-control" v-model="visit_remarks" placeholder="Enter Details" rows="2" type="text" name="visit_remarks"></textarea>
                                        </div>
                                    </div>

                                    <hr>
                                    <button type="button" class="btn btn-info" :disabled="disableds" @click="visit()">Save</button>
                                    <button type="button" class="btn btn-secondary" @click="showVisits=false">Cancel</button>
                                    <br> <br>
                                    <div class="scrollclasstable1" :class="{scrollclasstable2: this.selected_visits.length>0 }">
                                        <div>
                                            <table class="table-bordered">
                                                <thead :style="'font-size:16px'">
                                                <tr>
                                                    <th class="wd-10p" bgcolor="#969696 !important">DATED</th>
                                                    <th class="wd-10p" bgcolor="#969696 !important">VISIT DATE</th>
                                                    <th class="wd-10p" bgcolor="#969696 !important">QUOTED MEMBERSHIP AMOUNT</th>
                                                    <th class="wd-10p" bgcolor="#969696 !important">ADVANCE AMOUNT</th>
                                                    <th class="wd-10p" bgcolor="#969696 !important">REMAINING AMOUNT</th>
                                                    <th class="wd-10p" bgcolor="#969696 !important">NEXT VISIT</th>
                                                    <th class="wd-20p" bgcolor="#969696 !important">REMARKS</th>
                                                </tr>
                                                </thead>
                                                <tbody :style="'font-size:15px'">
                                                <tr v-if="tr.lead_id==visitthisid" v-for="(tr,key) in selected_visits">
                                                    <td >{{tr.visit_time}}</td>
                                                    <td>{{moment(tr.visit_date).format('DD/MM/YYYY HH:mm:ss')}}  <input type="hidden" v-model="tr.vid"></td>
                                                    <td>{{tr.membership_amount}}</td>
                                                    <td>{{tr.advance_amount}}</td>
                                                    <td>{{tr.remaining_amount}}</td>
                                                    <td>{{moment(tr.next_visit).format('DD/MM/YYYY HH:mm:ss')}}</td>
                                                    <td>{{tr.visit_remarks}}</td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <div v-if="showModal">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title" style="color: black;">ASSIGN LEAD TO USER:</h5>
                                    <button type="button" class="close" @click="showModal=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <br>
                                    <select v-model="assigned_to" id="assigned_to" name="assigned_to" class="form-control">
                                       <option value="0">Choose Option</option>
                                        <option v-for="u in users" :value="u.id">
                                            {{u.name}}
                                        </option>
                                    </select>
                                    <br>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-info" @click="assign()">Save</button>
                                    <button type="button" class="btn btn-secondary" @click="showModal=false">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>

        <div class="row hidden-print">


            <div class="col-lg">
                <input value="" class="form-control "  size="20" type="number"
                       id="memberid" v-model="f.memberid" autocomplete="off"
                       name="memberid" placeholder="Search by ID">
            </div>

            <div class="col-lg">
                <div>
                    <datepicker v-model="f.start_date" :clear-button="true" placeholder="From (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>
                </div>
            </div>
            <div class="col-lg">
                <div>
                    <datepicker v-model="f.end_date" :clear-button="true"  placeholder="To (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
                </div>
            </div>

            <div class="col-lg">
                <input value="" autocomplete="off" class="form-control "  size="20" type="text"
                       id="name" v-model="f.name"
                       name="name" placeholder="Search by Name">
            </div>
            <div class="col-lg">

                <input value="" autocomplete="off" class="form-control "  size="20" type="text"
                       id="contact" v-model="f.contact"
                       name="contact" placeholder="Search by Contact">
            </div>
            <div class="col-lg">

                <input value="" autocomplete="off" class="form-control "  size="20" type="text"
                       id="city" v-model="f.city"
                       name="city" placeholder="Search by City">
            </div>
        </div>
        <br>
        <div class="row hidden-print">
<!--            <div class="col-lg">
                &lt;!&ndash; <p style="color: black;">Status:</p>&ndash;&gt;
                <multiselect track-by="name" label="name" placeholder="Choose Lead Status" v-model="status" :multiple="true" :options="(()=>{let x=[];
            stati.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>
            </div>-->

            <div class="col-lg">
<!--                <p style="color: black;">Status:</p>-->
                <multiselect track-by="name" label="name" placeholder="Choose Call Status" v-model="f.response" :multiple="true" :options="(()=>{let x=[];
            responses.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>
            </div>

            <div class="col-lg">
                <!-- <p style="color: black;">Status:</p>-->
                <multiselect track-by="name" label="name" placeholder="Choose Sources" v-model="f.lead_source" :multiple="true" :options="(()=>{let x=[];
            sources.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>
            </div>

            <div class="col-lg">
                <multiselect track-by="name" label="name" placeholder="Choose Users" v-model="f.user" :multiple="true" :options="(()=>{let x=[];
            users.forEach((a)=>{
                x.push({name:a.name,id:a.id})
            })
            return x;
            })()"></multiselect>
            </div>
            <div v-if="this.exported" class="col-xs">
                <export-excel
                    class   = "btn btn-primary"
                    :data   = "(()=>{return filterData(leads)})()"
                    worksheet = "My Worksheet"
                    name    = "Leads.xls">
                </export-excel>
            </div>
            &nbsp
            <div class="col-xs">
                <button type="button" class="btn btn-secondary" @click="refreshData();">Refresh</button>
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
                        <th class="wd-10p">LEAD DATE</th>
                        <th class="wd-15p">NAME</th>
                        <th class="wd-10p">EMAIL</th>
                        <th class="wd-10p">CONTACT</th>
                        <th class="wd-15p">COMPANY / DEPARTMENT</th>

                        <th class="wd-15p">JOB TITLE</th>
                        <th class="wd-10p">CITY</th>
                      <!--  <th class="wd-10p">COMPANY NUMBER</th>-->
                        <th class="wd-10p">STATUS</th>
                        <th class="wd-10p">CREATED AT</th>
                        <th class="wd-10p">USER</th>
                        <th class="wd-5p">ASSIGN LEAD</th>
                        <th class="wd-5p hidden-print">CALL TIME</th>
                        <th class="wd-5p hidden-print">VISITS</th>
                        <th class="wd-5p hidden-print">EDIT</th>
                        <th class="wd-5p hidden-print">DELETE</th>
                    </tr>
                    </thead>
                    <tbody :style="'font-size:15px'">
                    <tr v-for="(tr,key) in

                (
                      (()=>{
                      let  x=(leads);

                  /* leng=x.length;
                  if(parseInt(leng/pagelength)+((leng%pagelength)>0?1:0)<page){
                      page=1;
                   }*/

                      //

                     return x;
                    })()

                    )" >
                        <td>{{((page-1)*pagelength)+key+1}}</td>
                        <td>{{tr.id}}</td>
                        <td>{{moment(tr.lead_date).format('DD/MM/YYYY')}}</td>
                        <td>{{tr.name}}</td>
                        <td>{{tr.email}}</td>
                        <td>{{tr.contact}}</td>
                        <td>{{tr.company}}</td>
                        <td>{{tr.designation}}</td>

                        <td>{{tr.city}}</td>
                       <!--<td>{{tr.company_number}}</td>-->
                        <td>{{tr.callstatus==null?'Open':tr.callstatus}}</td>
                        <td>{{tr.created_at}}</td>
                        <td>{{tr.username}}</td>

                        <template v-if="!tr.assigned_to">
                            <td><button @click="callModal(tr.id)" class=" btn-sm btn-outline-danger active" title="Assign Lead">Assign</button></td>
                        </template>
                        <template v-else>
                            <td><button @click="callModal(tr.id)" class=" btn-sm btn-outline-success active" title="Assigned To">{{users.filter(function(a){return a.id==tr.assigned_to}).length>0?users.filter(function(a){return a.id==tr.assigned_to})[0].name:''}}</button></td>
                        </template>

                        <td><button @click="callTimeModal(tr.id)" class=" btn-sm btn-outline-success active" title="Call Time"><i class="fas fa-phone-alt"></i></button></td>
                        <td><button @click="visitsModal(tr.id)" class="btn-sm btn-outline-warning active" title="Visits"><i class="fas fa-walking"></i></button></td>
                        <td class="hidden-print"><button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" :href="'/crm/leads/leads-aeu-vue/' + tr.id"><i class="fas fa-edit"></i></a></button></td>
                        <td class="hidden-print"><button class="buttoncolor" @click="deleteme(tr.id,tr.delete_comments);" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
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
                                <option :value="leads.length" >ALL</option>
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
.svg-inline--fa.fa-w-9 {
    width: 1.5625em;
}
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
.scrollclasstable2{
    height: 229px;
    overflow-y: scroll;
    overflow-y: auto;
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
    name: "leadsdt",
    components: {
        Datepicker
    },
    props: [],
    json_data: [],
    data(){
        return{
            f:{},
            page:1,
            pagelength:50,
            leng:0,
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            leads:[],
            leadsR:[],
            leadsM: [],
            barcode:'',
            memberid:'',
            cnic:'',
            contact:'',
            city:'',
            name:'',
            mog:2,
            searchId:null,
            stati:[],
            status:[],
            fkey:-1,
            ffkey:0,
            showModal: false,
            showCallTime: false,
            showVisits: false,
            users:[],
            user:[],
            lead_source:[],
            assigned_to:'0',
            assignthisid:'',
            call_time:'',
            visit_time:'',
            follow_up:'',
            visit_date:'',
            membership_amount:'',
            advance_amount:0,
            remaining_amount:0,
            next_visit:'',

            remarks:'',
            visit_remarks:'',
            call_status:'1',
            callthisid:'',
            visitthisid:'',
            selected_items:[],
            selected_visits:[],
            start_date:'',
            end_date:'',
            sources:[],
            json_data: [],
            responses:[],
            response:[],
            disableds:false,
            exported:'',
            deletethisid:'',
            DeleteTheInvoice:false,
            remark:'',
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
                remark:this.remark
            };
            let url='/crm/leads/delete/'+this.deletethisid;
            if(this.validation(data,['remark'])==0){
                this.DeleteTheInvoice=false;
                this.$http.post(url,data).then(result=> {
                    this.init();
                });
            }
        },
        deleteme: function (k,com) {
            this.DeleteTheInvoice=true;
            this.deletethisid=k;
            this.remark=com;
        },
        filterData(leads){

            let   x=leads;
return x;
            if(this.memberid){

                x=x.filter((a)=>{
                    let self = this;
                    return (String(a.id)).startsWith(self.memberid)});
            }
            /*if(this.memberid){
                x=x.filter((a)=>{return a.id==this.memberid});
            }*/

            if(this.start_date){

                x=x.filter((a)=>{return moment(a.lead_date,'YYYY-MM-DD').format('x')>=moment(moment(this.start_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }
            if(this.end_date){

                x=x.filter((a)=>{return moment(a.lead_date,'YYYY-MM-DD').format('x')<=moment(moment(this.end_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }

            if(this.name){

               x=x.filter((a)=>{
                   let self = this;
                   return (String(a.name)).toLowerCase().startsWith(self.name.toLowerCase())});
             /*  x=x.filter((a)=>{return a.name==this.name});*/
            }

            if(this.contact){
                x=x.filter((a)=>{
                    let self = this;
                    return (String(a.contact)).startsWith(self.contact)});
              /*  x=x.filter((a)=>{return a.contact==this.contact});*/
            }

            if(this.city){

                x=x.filter((a)=>{
                    let self = this;
                    return (String(a.city)).toLowerCase().startsWith(self.city.toLowerCase())});

            }

            if(this.searchId){

                x=x.filter((a)=>{return a.id==this.searchId});
            }

            if(this.status.length>0){

                x=x.filter((a)=>{return this.status.filter((m)=>{
                    return a.status==m.name;
                }).length>0});
            }

            if(this.response.length>0){

                x=x.filter((a)=>{return this.response.filter((m)=>{
                    console.log( a.call_status);
                    console.log(m.id);
                    return a.call_status==m.id;
                }).length>0});
            }

            if(this.lead_source.length>0){

                x=x.filter((a)=>{return this.lead_source.filter((m)=>{
                    return a.source==m.id;
                }).length>0});
            }

            if(this.user.length>0){

                x=x.filter((a)=>{return this.user.filter((m)=>{
                    return a.created_by==m.id;
                }).length>0});
            }

            return x;
        },
        amIOnline(e) {
            this.onLine = e;
        },
        sliceP(leads){
            // console.log(123);
            this.leadsM=leads;
            return  leads.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },
        callModal:function (idd){
            this.showModal=true;
            this.assignthisid=idd;
        },
        callTimeModal:function (idd){
            this.onlySubs(idd);
            this.showCallTime=true;
            this.callthisid=idd;

        },
        visitsModal:function (idd){
            this.onlySubs2(idd);
            this.showVisits=true;
            this.visitthisid=idd;
        },

        /* FOR DATE PICKER*/

        /*  customFormatter(date) {
            return moment(date).format('MMMM Do YYYY, h:mm:ss a');
          //  use as :format="customFormatter"
        },*/
        assign:function(){
            let data={
                assigned_to:this.assigned_to,
            };
            let url='/crm/leads/leads-aeu/assignlead/'+this.assignthisid;

            if(this.validation(data,['assigned_to'])==0){
                this.$http.post(url,data).then(result=> {
                    /*window.location.href = "/crm/leads-vue";*/
                    this.init();
                    this.showModal=false;
                    this.assigned_to='0';
                    this.assignthisid='';
                });
            }
        },
        call:function(){
           /* let clone = (JSON.parse(JSON.stringify(this.selected_items)));*/
            let dd={
                lead_id:this.callthisid,
                call_status:this.call_status,
                call_time:moment().format("DD/MM/YYYY HH:mm:ss"),
                follow_up:this.follow_up,
                remarks:this.remarks,
            }
            if(this.follow_up=='' && (this.call_status==1 || this.call_status==3 || this.call_status==6 || this.call_status==7))
                 { alert('Please select Follow Up Date first !'); return 0 }
            else {
                this.disableds=true;
                this.selected_items.push(dd);// use push if you want it in ASC order in array and unshift for DESC


            // this.selected_items.push(dd);//=this.call_status;
            // this.selected_items.call_time=this.call_time;
            // this.selected_items.follow_up=this.follow_up;
            // this.selected_items.remarks=this.remarks;
            let data={
                call_status:this.call_status,
                follow_up:this.follow_up,
                call_time: moment().format("DD/MM/YYYY HH:mm:ss"),
                remarks:this.remarks,
              //  selected_items:this.selected_items,
            };
            let url='/crm/leads/leads-aeu/calldetails/'+this.callthisid;

                this.$http.post(url,data).then(result=> {
                    this.call_status='1';
                    this.call_time='';
                    this.follow_up='';
                  /*  this.$refs.dateandtime.clearDate();
                    this.$refs.dateandtime.hideCal=true;*/
                    this.remarks='';
                    this.disableds=false;
/*                    this.showCallTime=false;*/
                   /* this.init();*/

                });
          }
        },
        visit:function(){
            /*  let clone = (JSON.parse(JSON.stringify(this.selected_visits)));*/
            let dd={
                visit_time:moment().format("DD/MM/YYYY HH:mm:ss"),
                lead_id:this.visitthisid,
                visit_date:this.visit_date,
                membership_amount:this.membership_amount,
                advance_amount:this.advance_amount,
                remaining_amount:parseInt(this.membership_amount)-parseInt(this.advance_amount),
                next_visit:this.next_visit,
                visit_remarks:this.visit_remarks,
            }
          /*  console.log(dd);*/
            if(this.visit_date=='')
            { alert('Please select Visit Date first !'); return 0 }
           /* else if(this.next_visit=='')
            { alert('Please select Next Visit Date first !'); return 0 }*/
            else {
                this.disableds=true;
                this.selected_visits.push(dd);// use push if you want it in ASC order in array and unshift for DESC

                let data={
                    visit_time: moment().format("DD/MM/YYYY HH:mm:ss"),
                    visit_date:this.visit_date,
                    membership_amount:this.membership_amount,
                    advance_amount:this.advance_amount,
                    remaining_amount:parseInt(this.membership_amount)-parseInt(this.advance_amount),
                    next_visit:this.next_visit,
                    visit_remarks:this.visit_remarks,
                  /*  selected_visits:this.selected_visits,*/
                };
                let url='/crm/leads/leads-aeu/visitdetails/'+this.visitthisid;

                this.$http.post(url,data).then(result=> {
                    this.membership_amount=0;
                    this.advance_amount=0;
                    this.remaining_amount=0;

                    this.visit_time='';
                    this.visit_date='';
                    this.visit_remarks='';
                    /*this.$refs.visitdate.clearDate();
                    this.$refs.visitdate.hideCal=true;*/
                    this.next_visit='';
                    this.disableds=false;
                   /* this.$refs.nextvisit.clearDate();
                    this.$refs.nextvisit.hideCal=true;*/

                /*    this.showVisits=false;*/
                   /* this.init();*/
                });
            }
        },
        init:function () {
let search='';
            if(this.f.memberid){
                search=search+'&memberid='+this.f.memberid;
            }
            if(this.f.start_date){
    search=search+'&start_date='+moment(this.f.start_date).format('YYYY-MM-DD');
}
    if(this.f.end_date){
        search=search+'&end_date='+moment(this.f.end_date).format('YYYY-MM-DD');

    }
        if(this.f.name){
            search=search+'&name='+this.f.name;

        }
            if(this.f.contact){
                search=search+'&contact='+this.f.contact;

            }
            if(this.f.city){
                search=search+'&city='+this.f.city;

            }
                if(this.f.searchId){
                    search=search+'&searchId='+this.f.searchId;

                }

                        if((this.f.response) && this.f.response.length>0){

                            search=search+'&response='+this.pluck(this.f.response,'id').join();

                        }
                            if((this.f.lead_source) && this.f.lead_source.length>0){
                                search=search+'&lead_source='+this.pluck(this.f.lead_source,'id').join();

                            }
                                if((this.f.user) && this.f.user.length>0){
                                    search=search+'&user='+this.pluck(this.f.user,'id').join();

                                }
            this.$http.get('/crm/leads/leads_init_vue?page='+this.page+'&len='+this.pagelength+search).then(result=>{
                let data=result.data;

                this.leads=data.leads;
                this.leadsR=data.leads;
                //this.leng=data.leads.length;
             //   this.json_data=data.leads;
                this.users=data.users;

                this.disableds=false;
            })

        },
        refreshData:function () {

        this.$http.get('/crm/leads/leads_init_vue?last_id='+this.leads[0].id+'&page='+this.page+'&len='+this.pagelength).then(result=>{
                let data=result.data;
if(data.leads && data.leads.length>0){
    data.leads.forEach((a)=> {
        this.leads.unshift(a);
    })

}

               // this.leadsR=data.leads;
               // this.leadsR=data.leads;
                //this.leng=data.leads.length;
             //   this.json_data=data.leads;

            //    this.disableds=false;
            })

        },
        getCo:function (){
            let search='';
            if(this.f.memberid){
                search=search+'&memberid='+this.f.memberid;
            }  if(this.f.start_date){
                search=search+'&start_date='+moment(this.f.start_date).format('YYYY-MM-DD');
            }
            if(this.f.end_date){
                search=search+'&end_date='+moment(this.f.end_date).format('YYYY-MM-DD');

            }
            if(this.f.name){
                search=search+'&name='+this.f.name;

            }
            if(this.f.contact){
                search=search+'&contact='+this.f.contact;

            }
            if(this.f.city){
                search=search+'&city='+this.f.city;

            }
            if(this.f.searchId){
                search=search+'&searchId='+this.f.searchId;

            }

            if((this.f.response) && this.f.response.length>0){

                search=search+'&response='+this.pluck(this.f.response,'id').join();

            }
            if((this.f.lead_source) && this.f.lead_source.length>0){
                search=search+'&lead_source='+this.pluck(this.f.lead_source,'id').join();

            }
            if((this.f.user) && this.f.user.length>0){
                search=search+'&user='+this.pluck(this.f.user,'id').join();

            }
            this.$http.get('/crm/leads/leads_init_vue?countOnly=1'+search).then(result=>{

                this.leng=result.data;
                //   this.json_data=data.leads;

            })
        },getOthers:function (){
            this.$http.get('/crm/leads/leads_init_vue?others=1').then(result=>{
                let data=result.data;

                this.stati=data.stati;
                this.exported=data.exported;
                this.sources=data.sources;
                this.responses=data.responses;
                this.selected_items=data.selected_items;
                this.selected_visits=data.selected_visits;
                this.responses.unshift({
                    desc:'Open',
                    id:'null'
                })
                //   this.json_data=data.leads;

            })
        },onlySubs:function (a){
            this.$http.get('/crm/leads/leads_init_vue?onlySubs=1&lead_id='+a).then(result=>{
                let data=result.data;

              //  this.stati=data.stati;
               // this.users=data.users;
                //this.sources=data.sources;
                //this.responses=data.responses;
                this.selected_items=data.selected_items;
                // this.selected_visits=data.selected_visits;
                // this.responses.unshift({
                //     desc:'Open',
                //     id:'null'
                // })
                //   this.json_data=data.leads;

            })
        },onlySubs2:function (a){
            this.$http.get('/crm/leads/leads_init_vue?onlySubs2=1&lead_id='+a).then(result=>{
                let data=result.data;

              //  this.stati=data.stati;
               // this.users=data.users;
                //this.sources=data.sources;
                //this.responses=data.responses;
                // this.selected_items=data.selected_items;
                this.selected_visits=data.selected_visits;
                // this.responses.unshift({
                //     desc:'Open',
                //     id:'null'
                // })
                //   this.json_data=data.leads;

            })
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
        f:{
            handler(){
                this.init();
                this.getCo();
                this.page=1;
            },
            deep: true
        },
        leadsM:function(){
            console.log(1);
        },
        page:function(){
          this.init();
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
            this.getCo();
            this.getOthers();
            // this.init(id.id);

        }
        else{
            this.init();
           this.getCo();
            this.getOthers();
        }


    }
}
</script>

