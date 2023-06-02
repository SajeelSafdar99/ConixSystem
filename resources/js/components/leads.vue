


<template>

    <div>

        <vue-snotify></vue-snotify>

        <div class="col-xl-12 ">
            <h6 class="box-title" style="color: black; text-align: center;">LEAD'S INFORMATION</h6>
            <br>
            <div class="row">

                    <div class="col-sm-6">
                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Lead ID:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input tabindex="1" type="text" v-model="lead_id" id="lead_id" name="lead_id" class="form-control input-height" autocomplete="off"  readonly="" style="background-color: #c1c1c1">
                            </div>
                        </div>


                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Name:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input tabindex="3" type="text" v-model="name" placeholder="Enter Name" name="name" id="name" class="form-control input-height" >

                            </div>
                        </div>

                        <div class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Contact: <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <!--                            <div  class="col-sm-1 mg-t-10 mg-sm-t-0">
                                                            <input class="form-control input-height" value="+92" name="code" id="code" type="text" readonly style="width: 70px;">
                                                        </div>-->
                            <div  class="col-sm-7 mg-t-10 mg-sm-t-0">
                                <input tabindex="5" class="form-control input-height" placeholder="Enter Contact" v-model="contact" name="contact" id="contact" type="text">
                            </div>
                            <div  class="col-sm-2 mg-t-10 mg-sm-t-0">
                                <button tabindex="6" @click="checker(id)" :class="'btn btn-sm btn-warning'" >Check</button>
                            </div>
                        </div>



                        <div class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Company / Other Number:
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input tabindex="8" class="form-control input-height" placeholder="Enter Contact" v-model="company_number" name="company_number" id="company_number" type="text">
                            </div>
                        </div>

                        <div class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Lead Source:
                                <span class="tx-danger">
                                *
                            </span>
                            </label><div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <select tabindex="10" id="source" v-model="source" name="source" class="form-control input-height select2" >
                                <option :value="s.id" v-for="s in sources">
                                    {{ s.desc }}
                                </option>

                            </select>  </div>
                        </div>

                        <div class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Reason / Remark:
                            </label><div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <select tabindex="12" id="reason" v-model="reason" name="reason" class="form-control input-height select2" >
                                <option value="">Choose Option</option>
                                <option :value="r.id" v-for="r in reasons">
                                    {{ r.desc }}
                                </option>

                            </select>  </div>

                        </div>

                        <br><br><br><br>

                        <!--// BUTTONS-->
                        <input tabindex="14" @click="save_sales(id)" :disabled="disableds"  :class="id?'btn-info':'btn-info'" type="submit" name="save" class="btn" :value="id?'Update':'Save'">
                        <input tabindex="15" v-if="!this.id" @click="save_add_more(id)" :disabled="disableds"  :class="id?'btn-warning':'btn-warning'" type="submit" name="save" class="btn" :value="id?'Update & Add More':'Save & Add More'">
                    <!--    <template v-if="!this.id">
                        <input @click="save_sales_datatable(id)"  :class="'btn-primary'" type="submit" name="save" class="btn" :value="'Save & Receive'">
                        </template>-->

                                <a href="/crm/leads-vue"><button tabindex="16" class="btn btn-secondary">Cancel</button></a>

                        <!--// BUTTONS-->
                        <br><br><br>
                    </div>
                    <div class="col-sm-6">

                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Lead Date:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input tabindex="2" type="text" v-model="lead_date" id="lead_date" class="form-control input-height" autocomplete="off" value="" readonly="" style="background-color: #c1c1c1">
                            </div>
                        </div>

                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Email:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input tabindex="4" type="text" v-model="email" placeholder="Enter Email" name="email" id="email" class="form-control input-height" >

                            </div>
                        </div>

                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Company / Department Name:
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input tabindex="7"  type="text" v-model="company" placeholder="Enter Name of Company" name="company" id="company" class="form-control input-height" >

                            </div>
                        </div>


                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Designation / Job Title:
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input tabindex="9"  type="text" v-model="designation" placeholder="Enter Designation" name="designation" id="designation" class="form-control input-height" >

                            </div>
                        </div>

                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                City:
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input tabindex="11" type="text" v-model="city" placeholder="Enter City" name="city" id="city" class="form-control input-height" >
                            </div>
                        </div>


                        <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                            Status:
                            <span class="tx-danger">
                                *
                            </span>
                        </label><div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                        <select tabindex="13" id="status" v-model="status" name="status" class="form-control input-height select2" >
                            <option :value="s.id" v-for="s in stati">
                                {{ s.desc }}
                            </option>

                        </select>  </div>
                        </div>


                    </div>
        </div>
    </div>


</div>

</template>

<script>
    export default {
        name: "leads",
        props: ['idm','datatableid'],
        data(){
            let s=this.idm;
          return  {
              lead_date:'',
              name:'',
              email:'',
              city:'',
              code:'',
              contact:'',
              designation:'',
              company:'',
              company_number:'',
              status:'1',
              stati:[],

              source:'1',
              sources:[],

              fkey:-1,
              ffkey:0,

              disableds:false,
              id:s,
              onLine: null,
              onlineSlot: 'online',
              offlineSlot: 'offline',
              increment_number:'',
              shouldiappear:'',
              refreshmyinterval:false,
              reason:'',
              reasons:[],
              lead_id:'',
          }
        },

        watch:{

        },

        methods: {
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

            amIOnline(e) {
                this.onLine = e;
            },
            slideright: function () {
                $('.scrollclass').addClass('slideright');

            },
            validation: function (data, valid) {
                let self = this;
                let mm = 0;
                valid.forEach((a) => {
                    if (data[a] == '' || data[a] == null) {
                        self.$snotify.error(a + ' is required!');
                        mm++
                    }

                })
                return mm;
            },

            save_sales:function(m){

                this.refreshmyinterval=true;

                let data={
                    lead_date:this.lead_date,
                    name:this.name,
                    city:this.city,
                    email:this.email,
                    contact:this.contact,
                    designation:this.designation,
                    company:this.company,
                    company_number:this.company_number,
                    status:this.status,
                    source:this.source,
                    reason:this.reason,
                };
                let url='/crm/leads/leads-aeu/save';
                if(m){
                    url='/crm/leads/leads-aeu/update';
                    data.id=this.id;
                }

                if(this.contact=='' && this.company_number=='')
                { alert('Please Enter a valid Contact number !'); return 0 }
                else if((this.contact!='' && this.contact.length==13) || (this.company_number && !this.contact)){

                    this.disableds=true;
if(this.validation(data,['lead_date','name','email', 'status', 'source'])==0){
    this.$http.post(url,data).then(result=> {
if(m){
    this.init(m);
    this.$snotify.success('Data Updated Successfully !');
}else{
    window.location.href = "/crm/leads-vue";
}
    }).catch(error=> {
        this.disableds=false;
        this.$snotify.error('The Contact you entered is already taken !');
    });
}
else{
    this.disableds=false;

}

                    }
                    else{
                        this.$snotify.error('Please Enter a valid Contact number !');
                    }

            },
            save_add_more:function(m){

                this.refreshmyinterval=true;

                let data={
                    lead_date:this.lead_date,
                    name:this.name,
                    city:this.city,
                    email:this.email,
                    contact:this.contact,
                    designation:this.designation,
                    company:this.company,
                    company_number:this.company_number,
                    status:this.status,
                    source:this.source,
                    reason:this.reason,
                };
                let url='/crm/leads/leads-aeu/save';
                if(m){
                    url='/crm/leads/leads-aeu/update';
                    data.id=this.id;
                }

                if(this.contact=='' && this.company_number=='')
                { alert('Please Enter a valid Contact number !'); return 0 }
                else if((this.contact!='' && this.contact.length==13) || (this.company_number && !this.contact)){

                    this.disableds=true;
                    if(this.validation(data,['lead_date','name','email', 'status', 'source'])==0){
                        this.$http.post(url,data).then(result=> {
                           /* if(m){
                                this.init(m);
                                this.$snotify.success('Data Updated Successfully !');
                            }else{*/
                                this.init();
                            /*}*/
                            /* window.location.href = "/crm/leads-vue";*/
                        }).catch(error=> {
                            this.disableds=false;
                            this.$snotify.error('The Contact you entered is already taken !');
                        });
                    }
                    else{
                        this.disableds=false;

                    }

                }
                else{
                    this.$snotify.error('Please Enter a valid Contact number !');
                }

            },
            checker:function(m){
                let data={
                    contact:this.contact,
                };
                let url='/crm/leads/checkcontact/save';
                if(m){
                    url='/crm/leads/checkcontact/update';
                    data.id=this.id;
                }
                if(this.validation(data,['contact'])==0){
                    this.$http.post(url,data).then(result=> {
                        if(result.data==1){
                            this.$snotify.error('The Lead with this contact was deleted. Retrieve it first !');
                        }
                        else if(result.data==3){
                            this.$snotify.error('The Contact you entered is already taken !');
                        }
                        else if(result.data==2){
                            this.$snotify.success('Good to Go !');
                        }

                    })
                }
            },
            save_sales_datatable:function(m) {
                this.FinalEditOrder = true;
            },
            modalopen:function(){
                $(this).find($.attr('#instruction')).focus();
                if(this.selected_items[this.active_el].saved!=1) {
                    if (this.selected_items[this.active_el])
                        this.showModal = true;
                    else
                        this.showModal = false;
                }
            },
            modalpaymentopen:function(){

                    this.showModalPayment = true;

            },

            modalok:function(){
                this.instruction='';
                this.showModal=false;
            },

            scroll_left() {
                let content = document.querySelector(".wrapper-box");
                content.scrollLeft -= 50;
            },
            scroll_right() {
                let content = document.querySelector(".wrapper-box");
                content.scrollLeft += 50;
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
            init:function (m) {
                for (var i = 1; i < 9999; i++) {
                    window.clearInterval(i);
                }
                let r='';
                if(m){
                    r='?r='+m;
                }
                this.$http.get('/crm/leads/leads-aeu/init'+r).then(result=>{
                    let data =result.data;
                    this.refreshmyinterval=false;
                    if(m && this.datatableid==m) {
                        this.shouldiappear=1;
                        this.id=data.id;
                        this.lead_id=data.increment_number;

                        this.lead_date=moment(data.lead_date).format('DD/MM/YYYY');
                        this.name=data.name;
                        this.contact=data.contact;
                      /*  this.contact=data.contact.slice(3);*/
                        this.email=data.email;
                        this.city=data.city;
                        this.designation=data.designation;
                        this.company=data.company;
                        this.company_number=data.company_number;
                        this.status=data.status;
                        this.source=data.source;
                        this.reason=data.reason;
                    }
                    else if(m && this.datatableid!=m) {
                        this.lead_id=data.increment_number;
                        this.shouldiappear=0;
                        this.lead_date=moment(data.lead_date).format('DD/MM/YYYY');
                        this.name=data.name;
                        this.contact=data.contact;
                       /* this.contact=data.contact.slice(3);*/
                        this.email=data.email;
                        this.city=data.city;
                        this.designation=data.designation;
                        this.company=data.company;
                        this.company_number=data.company_number;
                        this.status=data.status;
                        this.source=data.source;
                        this.reason=data.reason;
                        this.id=data.id;
                    }
                    else{
                        this.shouldiappear=0;
                        this.id='';
                        this.lead_date=moment().format('DD/MM/YYYY');
                        this.name='';
                        this.contact='';
                        this.email='';
                        this.city='';
                        this.designation='';
                        this.company='';
                        this.company_number='';
                        this.status='1';
                        this.source='1';
                        this.reason='';

                    }
                    this.lead_id=data.increment_number;
                    this.stati=data.stati;
                    this.sources=data.sources;
                    this.reasons=data.reasons;
                    this.disableds=false;

                })

            },
        },

        mounted() {
            setInterval(()=>{
                this.$forceUpdate();
            },500)


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

<style scoped>

.active{
    /*background: green;*/
    background-color: #23BF08 !important;
    color: white !important;
}
.booked{
    background-color: red;
    color: white;
}
.printed{
    background-color: blue;
    color: white;
}
.ractive{
    border-radius: 25px;
    background-color: #23BF08;
    border: 2px solid #23BF08;
    color: white;
}
.ractive3{
    background-color: #23BF08;
   /* border: 2px solid #23BF08;*/
    color: white;
}
    td{border: 1px solid #f1f1f1;white-space: nowrap; }

th {

    background-color: #49a2fb;
    color: white;
    width: auto;
    border-right: 2px solid #fff;
    font-size: 13px;
    padding: 0px 2px;
    min-width: 33px;
}

    .cursor{cursor: pointer;}
.scrollclass {
    vertical-align: middle;
    overflow-x: scroll;
    overflow: hidden;/* new*/
    height:50px;/* new*/
}

.scrollclasscategory {
    vertical-align: middle;
    overflow-x: scroll;
    overflow: hidden;/* new*/
    height:100px;/* new*/
}
.scrollclasscategory .scrollsub{
    display: inline-block;
    vertical-align: middle;
    height: 50px;/*
    margin-right: -4px;*/
}
.scrollclasstable1{
    vertical-align: middle;
    overflow-x: scroll;
}
.scrollclasstable2{
    height: 229px;
    overflow-y: scroll;
    overflow-y: auto;
}
.slidedown{
    margin-top: -30px;
}

.scrollclassrests{
    vertical-align: middle;
    overflow-y: scroll;
    overflow-y: auto;
    overflow:hidden;
}
.scrollclassrests .scrollsubrests{
    display: inline-block;
    vertical-align: middle;
    text-align: center;
}

.scrollclassy {
    vertical-align: middle;
    overflow-y: scroll;
    overflow-y: auto;
}

.scrollclassy .scrollsuby2{
    display: inline-block;
    vertical-align: middle;
    margin-right: -4px;
}
.scrollclassy .scrollsuby{
    display: inline-block;
    vertical-align: middle;
    height: 50px;
    margin-right: -4px;
}
.scrollclass .scrollsub{
    display: inline-block;
    vertical-align: middle;
    height: 50px;/*
    margin-right: -4px;*/
}
.scrollclass .inner{
}

    .btnfont{
        font-size: 18px !important;
    }

tr > td:hover {
    cursor:pointer;
}

.activatedtr {
    background-color: steelblue;
}
.header
{background-color: cadetblue;}

.slideright{
    margin-left: -200px;
}
.hideShow{
    font-size: 20px;
    top: -33px;
    position: absolute;
    right: 14px;
    background: #7b1c1c;
    height: 30px;
    width: 30px;
    text-align: center;
    padding-top: 3px;
    border-radius: 50%;
    color: #fff;
}
.form-layout-4{
    padding: 8px;
}
.tabledefs {
    border: 2px solid #f1f1f1;
    padding: 12px;
    width: 47px;
    height: 30px;
    cursor: pointer;
    font-size: 13px;
    font-weight: bold;
    padding: 3px;
}
.btn-xsss{
    padding: 0;
    font-size: 10px;
    padding: 3px 4px;
    /* float: right; */
    background: transparent;
    color: #000;
    border: 1px solid #ccc;
    border-radius: 0;
    border: none;
    float: right;
}
input.form-control,select.form-control{
    padding:3px
}

.form-group{
    margin-bottom:2px;
}
.btnfont{
    font-size: 16px!important;
    padding: 0;
    height: 25px;
    width: 25px;
    border-radius: 50%;
    text-align: center;
    padding: 0px;
    color: #fff;
    background: #5a5a5a;
    margin-bottom: 4px;
    margin-left: 4px;
}
.finishbuttons input, .finishbuttons button {
    height: 30px;
    width: 88px;
    padding: 1px;
    margin-bottom: 6px;
    text-align: center;
}
.finishbuttons{
    text-align: center;
}
.catdiv {
    border: 2px solid #f1f1f1;
    width: 160px;
    height: 80px;
    cursor: pointer;
    font-size: 14px;
}
.offline {
    background-color: #fc9842;
    background-image: linear-gradient(315deg, #fc9842 0%, #fe5f75 74%);
}
.online {
    background-color: #00b712;
    background-image: linear-gradient(315deg, #00b712 0%, #5aff15 74%);
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
