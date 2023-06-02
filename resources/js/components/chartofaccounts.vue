<template>
    <div>
        <vue-snotify></vue-snotify>

        <template v-if="showFilters">
            <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <div class="form-layout form-layout-4 blackcolor headingsetting hidden-print">
                        <div class="row">
                            <label class="col-sm-2 form-control-label">LEVEL 1:</label>
                            <div class="col-sm-10">
                                <select class="form-control" v-model="one" name="one" id="one">
                                    <option value="0">All</option>
                                    <option v-for="one in ones" :value="one.id">
                                        {{one.desc}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-2 form-control-label">LEVEL 2:</label>
                            <div class="col-sm-10">
                                <select class="form-control" v-model="two" name="two" id="two">
                                    <option value="0">All</option>
                                    <option v-for="two in twos.filter((a)=>{return a.level_one==this.one})" :value="two.id">
                                        {{two.desc}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-2 form-control-label">LEVEL 3:</label>
                            <div class="col-sm-10">
                                <select class="form-control" v-model="three" name="three" id="three">
                                    <option value="0">All</option>
                                    <option v-for="three in threes.filter((a)=>{return a.level_two==this.two})" :value="three.id">
                                        {{three.desc}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-2 form-control-label">LEVEL 4:</label>
                            <div class="col-sm-10">
                                <select class="form-control" v-model="four" name="four" id="four">
                                    <option value="0">All</option>
                                    <option v-for="four in fours.filter((a)=>{return a.level_three==this.three})"  :value="four.id">
                                        {{four.desc}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <br>
            <div class="row">
                <label class="col-sm-2 form-control-label">LEVEL 5:</label>
                <div class="col-sm-10">
                    <select class="form-control" v-model="filter" name="filter" id="filter">
                        <option value="0">All</option>
                        <option v-for="f in filters.filter((a)=>{return a.desc==this.four})" :value="f.id">
                            {{f.type}}
                        </option>
                    </select>
                </div>
            </div>
            <br>

            <div class="row">
                <label class="col-sm-2 form-control-label"></label>
                <div class="col-sm-10">
                    <button type="button" @click="init(); showTable=true; showFilters=false; " class="btn btn-success">Search</button>
                </div>
            </div>

                    </div>
                </div>
                <div class="col-sm-4"></div>
            </div>
        </template>


        <div class="row hidden-print">
            <div class="col-lg">
                <div>
                    <datepicker placeholder="From (dd/mm/yyyy)"   v-model="start_date" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>
                </div>
            </div>
            <div class="col-lg">
                <div>
                    <datepicker placeholder="To (dd/mm/yyyy)"   v-model="end_date" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
                </div>
            </div>

            <div class="col-lg">
                <div class="form-group has-search"  v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">
                    <input  type="text" class="form-control typeahead" autocomplete="off" v-model="accsearch"    name="accsearch" id="accsearch" placeholder="Search COA...">

                    <input  type="hidden" class="form-control typeahead" autocomplete="off" v-model="accsearchid"   tabindex="2" name="accsearchid" id="accsearchid" placeholder="Search COA...">

                    <ul id="areabox3" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.accsearch && searchedaccounts.length>0">

                        <li class="fbb" :class="'ccs'+key" @click="accountdatavalue(itd.id)" v-for="(itd,key) in searchedaccounts">
                            <a href="javascript:void(0)">{{itd.code}} - {{itd.name}}</a>
                        </li>
                    </ul>

                </div>
            </div>


            <div class="col-lg">
                <div class="form-group has-search"  v-on:keydown.up.prevent="udf2(1)" v-on:keydown.down.prevent="udf2(0)">
                    <input  type="text" class="form-control typeahead" autocomplete="off" v-model="paccsearch"  name="paccsearch" id="paccsearch" placeholder="Search Parent...">

                    <input  type="hidden" class="form-control typeahead" autocomplete="off" v-model="accsearchpid"   tabindex="2" name="accsearchpid" id="accsearchpid" placeholder="Search Parent...">

                    <ul id="areabox3" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.paccsearch && psearchedaccounts.length>0">

                        <li class="fbb" :class="'ccs'+key" @click="paccountdatavalue(itd.id)" v-for="(itd,key) in psearchedaccounts">
                            <a href="javascript:void(0)">{{itd.code}} - {{itd.name}}</a>
                        </li>
                    </ul>

                </div>
            </div>

            <div class="col-xs">
                <div>

                    <button type="button" class="btn btn-success" v-on:click="init">Search</button>

                </div>
            </div>
        </div>


<br>


            <template v-if="showTable">
            <div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
                <h5>AFOHS <br>GENERAL LEDGER </h5>

            </div>

            <div class="scrollclasstable1">
            <div>

                <table class="table-striped  table-hover">
                    <thead :style="'font-size:15px'">
                    <tr>


                        <th class="wd-10p">COA CODE</th>
                        <th class="wd-35p">COA NAME</th>
                        <th class="wd-10p">PARENT CODE</th>
                        <th class="wd-25p">PARENT NAME</th>

                        <th class="wd-15p">OPENING DEBIT</th>
                        <th class="wd-15p">OPENING CREDIT</th>
                        <th class="wd-10p">BALANCE</th>


                    </tr>
                    </thead>

                    <tbody :style="'font-size:15px'">



                    <template v-for="(ta,key) in trials">

                        <tr v-if="(key==0) || trials[key-1].category_id!=ta.category_id">
                            <td colspan="4" class="sub"><u style="text-transform: uppercase;"><strong>{{ta.category}}</strong></u></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
<!--                            <td>{{ta.catd?ta.catd:0}}</td>
                            <td>{{ta.catc?ta.catc:0}}</td>-->
                        </tr>

                        <tr v-if="ta.parentcode==null" >

                            <td>{{ta.code}}</td>
                            <td>{{ta.name}}</td>

                            <td>{{ta.parentcode}}</td>
                            <td>{{ta.parent}}</td>
                            <td>{{ta.maind?ta.maind:0}}</td>
                            <td>{{ta.mainc?ta.mainc:0}}</td>
                            <td>{{ parseInt(ta.mainc?ta.mainc:0)-parseInt(ta.maind?ta.maind:0)}}</td>
                        </tr>
                        <template  v-if="ta.parentcode==null" v-for="(tb,key) in trials.filter((a)=>{return a.parentcode==ta.code})">
                            <tr  >

                                <td>{{tb.code}}</td>
                                <td  ><span  :style="'margin-left:'+20+'px'">&nbsp;</span> {{tb.name}}</td>

                                <td>{{tb.parentcode}}</td>
                                <td>{{tb.parent}}</td>
                                <td>{{tb.cond?tb.cond:0}}</td>
                                <td>{{tb.conc?tb.conc:0}}</td>
                                <td>{{ parseInt(tb.conc?tb.conc:0)-parseInt(tb.cond?tb.cond:0)}}</td>
                            </tr>
                            <template v-for="(tc,key) in trials.filter((a)=>{return a.parentcode==tb.code})">
                                <tr  >

                                    <td>{{tc.code}}</td>
                                    <td  ><span  :style="'margin-left:'+40+'px'">&nbsp;</span> {{tc.name}}</td>

                                    <td>{{tc.parentcode}}</td>
                                    <td>{{tc.parent}}</td>
                                    <td>{{tc.subcond?tc.subcond:0}}</td>
                                    <td>{{tc.subconc?tc.subconc:0}}</td>
                                    <td>{{ parseInt(tc.subconc?tc.subconc:0)-parseInt(tc.subcond?tc.subcond:0)}}</td>
                                </tr>
                                <template v-for="(td,key) in trials.filter((a)=>{return a.parentcode==tc.code})">
                                    <tr  >

                                        <td>{{td.code}}</td>
                                        <td  ><span  :style="'margin-left:'+60+'px'">&nbsp;</span> {{td.name}}</td>

                                        <td>{{td.parentcode}}</td>
                                        <td>{{td.parent}}</td>
                                        <td>{{ td.accd?td.accd:0 }}</td>
                                        <td>{{ td.acc?td.acc:0 }}</td>
                                        <td>{{ parseInt(td.acc?td.acc:0)-parseInt(td.accd?td.accd:0) }}</td>
                                    </tr>
                                    <template v-for="(te,key) in trials.filter((a)=>{return a.parentcode==td.code})">
                                        <tr  >

                                            <td>{{te.code}}</td>
                                            <td><span  :style="'margin-left:'+80+'px'">&nbsp;</span> {{te.name}}</td>

                                            <td>{{te.parentcode}}</td>
                                            <td>{{te.parent}}</td>
                                            <td>{{te.debit}}</td>
                                            <td>{{te.credit}}</td>
                                            <td>{{ parseInt(te.credit?te.credit:0)-parseInt(te.debit?te.debit:0)}}</td>
                                        </tr>
                                    </template>
                                </template>
                            </template>
                        </template>
                    </template>

                    </tbody>



<!--                    <tbody :style="'font-size:15px'">
                    <tr v-for="(tr,key) in

                sliceP(
                     (()=>{
                      let  x=filterData(trials);

                   leng=x.length;
                  if(parseInt(leng/pagelength)+((leng%pagelength)>0?1:0)<page){
                      page=1;
                  }

                      //

                     return x;
                    })()

                    )" >
                        <td>{{ ((page-1)*pagelength)+(key+1)}}</td>
                        <td>{{tr.code}}</td>
                        <template v-if="!tr.parentcode">
                            <td  >{{tr.name}}</td>
                        </template>
                        <template v-else>
                            <template v-if="tr.parentcode && trials[key-1] && trials[key-1].code && trials[key-1]!=0 && tr.parentcode==trials[key-1].code">
                                <td>
                                    <span  :style="'margin-left:'+((tr.parentcode/100)/100)*10+'px'">&nbsp;</span>
                                    {{tr.name}}</td>
                            </template>
                            <template v-else-if="tr.parentcode && trials[key-1] && trials[key-1].code && trials[key-1]!=0">
                                <td>
                                    <span  :style="'margin-left:'+(((tr.parentcode/100)/100)*11)+'px'">&nbsp;</span>
                                    {{tr.name}}</td>

                            </template>
                            <template v-else>
                                <td  >{{tr.name}}</td>
                            </template>

                        </template>

                        <td>{{tr.parentcode}}</td>
                        <td>{{tr.parent}}</td>
                        <td>{{tr.debit}}</td>
                        <td>{{tr.credit}}</td>




                    </tr>

                    </tbody>-->
<!--                    <tr v-for="(tr,key) in

                sliceP(
                     (()=>{
                      let  x=filterData(trials);

                   leng=x.length;
                  if(parseInt(leng/pagelength)+((leng%pagelength)>0?1:0)<page){
                      page=1;
                  }

                      //

                     return x;
                    })()

                    )" >
                        <td>{{ ((page-1)*pagelength)+(key+1)}}</td>
                        <td>{{tr.level}}</td>
                        <td>
                            <span style="margin-left: 20px"  v-for="a in (tr.level?(tr.level.split('-').length-1):0)">&nbsp;</span>
                            {{tr.desc}}</td>
                        <td>{{tr.accty}}</td>
                        <td>{{tr.ttype}}</td>
                        <td>{{parseInt(tr.debit)+(()=>{
                            let k=key;
                            let c=0;
                            if(trials[k+1]){

                            while(trials[k+1].level.substring(0,trials[k+1].level.length-2) == tr.level || trials[k+1].level.substring(0,trials[k+1].level.length-2) == trials[k].level){
                            c=c+parseInt(trials[k+1].debit)

                            // console.log(trials[k])
                            k=k+1;
                            }

                            }
                            return c
                        })() }}</td>
                        <td>{{parseInt(tr.credit)+(()=>{
                            let k=key;
                            let c=0;
                            if(trials[k+1]){

                            while(trials[k+1].level.substring(0,trials[k+1].level.length-2) == tr.level || trials[k+1].level.substring(0,trials[k+1].level.length-2) == trials[k].level){
                            c=c+parseInt(trials[k+1].credit)

                            // console.log(trials[k])
                            k=k+1;
                            }

                            }
                            return c
                            })()}}</td>
                        <td>1</td>

                        </tr>-->


                </table>
<!--                <div class="hidden-print">
                <ul class="pagination">
                    <li :class="page==n?'active':''"  v-for="n in (parseInt(leng/pagelength)+((leng%pagelength)>0?1:0))" @click="page=n"><span  >{{n}} </span></li>
                    <li>
                        <select  v-model="pagelength" class="">
                            <option value="30" >30</option>
                            <option value="50" >50</option>
                            <option value="100" >100</option>
                            <option value="150" >150</option>
                            <option :value="trials.length" >ALL</option>
                        </select>
                    </li>  </ul>
                </div>-->

            </div>
        </div>

</template>
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
<style scoped>

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
.table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
    background-color:#bcd3e3;
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
.modal-dialog{
    overflow-y: initial !important;
    max-width: 975px !important;
}
.modal-content{
    width: 1065px !important;
}
.modal-body{
    height: 80vh;
    overflow-y: auto;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
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
table th{
    background:#0c3661;
    height: 50px !important;
}

</style>
<script>
import Datepicker from 'vuejs-datepicker';
export default {
    name: "chartofaccounts",
    components: {
        Datepicker
    },
    data(){
        return{
            accountalreadySearched:false,
            accountalreadySearchedP:false,
            searchedaccounts:[],
            accsearch:'',
            accsearchid:'',
            psearchedaccounts:[],
            paccsearch:'',
            accsearchpid:'',
            showModal: false,
            fkey:-1,
            ffkey:0,
            filters:[],
            filter:'0',
            ones:[],
            one:'0',
            twos:[],
            two:'0',
            threes:[],
            three:'0',
            fours:[],
            four:'0',
            page:1,
            pagelength:50,
            leng:0,
            sign:0,
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            trials:[],
            trialsR:[],
            trialsM: [],
            invoice_no:'',
            start_date:'',
            end_date:'',
            customers:[],
            customer:'',
            mains:[],
            charges:[],
            subscriptions:[],
            details:'0',
            invoice_Date:'',
            searchId:null,
            mog:5,
            k:0,
            ssdata:false,
            showFilters:false,
            showTable:true,

        }
    },
    computed: {
       /* totals() {
            let  x=this.trials;

            let subacc=0;
            let subaccd=0;
            let acc=0;
            let accd=0;
            let subcond=0;
            let subconc=0;
            let conc=0;
            let cond=0;
            let mainc=0;
            let maind=0;

            x.filter((a)=>{return a.parentcode==null}).forEach(function (item) {

                mainc=mainc + parseInt(item.debit?item.debit:0);
                maind=maind + parseInt(item.credit?item.credit:0);

                x.filter((a)=>{return a.parentcode==item.code}).forEach(function (items) {

                    conc=conc + parseInt(items.debit?items.debit:0);
                    cond=cond + parseInt(items.credit?items.credit:0);

                    x.filter((a)=>{return a.parentcode==items.code}).forEach(function (itemss) {



                        subcond=subcond + parseInt(itemss.debit?itemss.debit:0);
                        subconc=subconc + parseInt(itemss.credit?itemss.credit:0);

                        x.filter((a)=>{return a.parentcode==itemss.code}).forEach(function (itemsss) {

                            accd=accd + parseInt(itemsss.debit?itemsss.debit:0);
                            acc=acc + parseInt(itemsss.credit?itemsss.credit:0);

                            x.filter((a)=>{return a.parentcode==itemsss.code}).forEach(function (itemsssz) {

                                subaccd=subaccd + parseInt(itemsssz.debit?itemsssz.debit:0);
                                subacc=subacc + parseInt(itemsssz.credit?itemsssz.credit:0);
                            })
                        })
                    })
                })

            })
            return {
                subacc:subacc,
                subaccd:subaccd,
                acc:acc,
                accd:accd,
                subcond:subcond,
                subconc:subconc,
                conc:conc,
                cond:cond,
                mainc:mainc,
                maind:maind,
            }
        }*/
    },
    methods:{
        accountdata(){
            this.$http.post('/search/coa/coaaccountdatalike',{searchid:this.accsearch}).then(result=>{
                let data =result.data;
                console.log(result.data);
                data.filter((a)=>{a.accsearch=a.name})

                if(data){

                    this.searchedaccounts=data;

                }
            });
        },
        accountdatavalue(val,m){
            this.searchedaccounts=[];
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/coa/coaaccountdata?balance=1&MOC='+r,{theid:val}).then(result=>{
                let data =result.data;
                if(data){
                    this.accountalreadySearched=true;
                    this.accsearch=data.name;
                    this.accsearchid=data.code;


                }
            });
        },
        paccountdata(){
            this.$http.post('/search/coa/coaaccountdatalike',{searchid:this.paccsearch}).then(result=>{
                let data =result.data;
                console.log(result.data);
                data.filter((a)=>{a.paccsearch=a.name})

                if(data){

                    this.psearchedaccounts=data;

                }
            });
        },
        paccountdatavalue(val,m){
            this.psearchedaccounts=[];
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/coa/coaaccountdata?balance=1&MOC='+r,{theid:val}).then(result=>{
                let data =result.data;
                if(data){
                    this.accountalreadySearchedP=true;
                    this.paccsearch=data.name;
                    this.accsearchpid=data.code;


                }
            });
        },
        updatesdata(d){
            this.ssdata={
                start_date:this.start_date,
                end_date:this.end_date,
                mog:d.type,
                searchId:d.id,
                filter:this.filter,
                one:this.one,
            }
            this.k=this.k+1;
            this.showModal=true;
        },
        filterData(trials){
            let   x=trials;





            if (this.searchId){
                    x=x.filter((a)=>{return a.id==this.searchId});
            }if (this.sign!=0){
                    x=x.filter((a)=>{if(this.sign==1){
                       return a.debit-a.credit>0
                    }
                    else if(this.sign==2){
                            return a.debit-a.credit<0
                        }});
            }
            if(this.mog!=5) {

                x=x.filter((a)=>{

                   return  a.type==this.mog;
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
        sliceP(trials){
            // console.log(123);
            this.trialsM=trials;
            return  trials.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },
        fup(){

        },fdown(){
            console.log(1)

        },
        udf(event){

            if(event==0){
                if(this.ffkey!=this.searchedaccounts.length-1){

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
        udf2(event){

            if(event==0){
                if(this.ffkey!=this.psearchedaccounts.length-1){

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
        init:function () {

            this.$http.get('/finance-and-management/general-ledger/list_init_vue?start_date='+(this.start_date?moment(this.start_date).format('YYYY-MM-DD'):'')+'&end_date='+(this.end_date?moment(this.end_date).format('YYYY-MM-DD'):'')+'&accsearchid='+(this.accsearch?this.accsearchid:'')+'&accsearchpid='+(this.paccsearch?this.accsearchpid:'')).then(result=>{
                let data=result.data;

                this.filters=data.filters;
                this.ones=data.ones;
                this.twos=data.twos;
                this.threes=data.threes;
                this.fours=data.fours;
                this.trials=data.trials;
                this.trialsR=data.trials;
                this.leng=data.trials.length;

                let x=data.trials;
                x.filter((a)=>{return a.parentcode==null}).forEach((a,key)=>{
//

                    let mainc=0;
                    let maind=0;

                    let catd=0;
                    let catc=0;
                    let subacc=0;
                    let subaccd=0;
                    let acc=0;
                    let accd=0;
                    let conc=0;
                    let cond=0;
                    let subcond=0;
                    let subconc=0;

                       maind=maind+parseInt(a.debit?a.debit:0);
                        mainc=mainc+parseInt(a.credit?a.credit:0);


                    /*a.maind=maind;
                    a.mainc=mainc;*/

                  /*  if((key==0) || x[key-1].category_id!=a.category_id){
                        catd=catd+parseInt(a.maind?a.maind:0);
                        catc=catc+parseInt(a.mainc?a.mainc:0);


                    }
                    a.catd=catd;
                    a.catc=catc;*/



                    a.maind=parseInt(maind?maind:0);
                    a.mainc=parseInt(mainc?mainc:0);


                    x.filter((b)=>{return b.parentcode==a.code}).forEach((b)=>{




                            cond = cond + parseInt(b.debit ? b.debit : 0);
                            conc = conc + parseInt(b.credit ? b.credit : 0);

                       /* b.cond=cond;
                        b.conc=conc;*/

                        b.cond=parseInt(cond?cond:0) ;
                        b.conc=parseInt(conc?conc:0) ;

                        a.maind=parseInt(maind?maind:0) + parseInt(cond?cond:0) ;
                        a.mainc=parseInt(mainc?mainc:0) + parseInt(conc?conc:0);


                        x.filter((c)=>{return c.parentcode==b.code}).forEach((c)=>{


                            subcond=subcond+parseInt(c.debit?c.debit:0);
                            subconc=subconc+parseInt(c.credit?c.credit:0);

                          /*  c.subcond=subcond;
                            c.subconc=subconc;*/




                            c.subcond=parseInt(subcond?subcond:0);
                            c.subconc=parseInt(subconc?subconc:0);


                            b.cond=parseInt(cond?cond:0) + parseInt(subcond?subcond:0);
                            b.conc=parseInt(conc?conc:0) + parseInt(subconc?subconc:0);

                            a.maind=parseInt(maind?maind:0) + parseInt(cond?cond:0) + parseInt(subcond?subcond:0);
                            a.mainc=parseInt(mainc?mainc:0) + parseInt(conc?conc:0) + parseInt(subconc?subconc:0);


                            x.filter((d)=>{return d.parentcode==c.code}).forEach((d)=>{




                                accd=accd+parseInt(d.debit?d.debit:0);
                                acc=acc+parseInt(d.credit?d.credit:0);

                              /*  d.accd=accd;
                                d.acc=acc;*/

                                d.accd=parseInt(accd?accd:0);
                                d.acc=parseInt(acc?acc:0);

                                c.subcond=parseInt(subcond?subcond:0) + parseInt(accd?accd:0);
                                c.subconc=parseInt(subconc?subconc:0) + parseInt(acc?acc:0);


                                b.cond=parseInt(cond?cond:0) + parseInt(subcond?subcond:0) + parseInt(accd?accd:0);
                                b.conc=parseInt(conc?conc:0) + parseInt(subconc?subconc:0) + parseInt(acc?acc:0);

                                a.maind=parseInt(maind?maind:0) + parseInt(cond?cond:0) + parseInt(subcond?subcond:0) + parseInt(accd?accd:0);
                                a.mainc=parseInt(mainc?mainc:0) + parseInt(conc?conc:0) + parseInt(subconc?subconc:0) + parseInt(acc?acc:0);


                                x.filter((e)=>{return e.parentcode==d.code}).forEach((e)=>{



                                    subaccd=subaccd+parseInt(e.debit?e.debit:0);
                                    subacc=subacc+parseInt(e.credit?e.credit:0);

                                   e.subaccd=subaccd;
                                    e.subacc=subacc;

                                    d.accd=parseInt(accd?accd:0)+parseInt(subaccd?subaccd:0);
                                    d.acc=parseInt(acc?acc:0)+parseInt( subacc?subacc:0);

                                    c.subcond=parseInt(subcond?subcond:0) + parseInt(accd?accd:0)+parseInt(subaccd?subaccd:0);
                                    c.subconc=parseInt(subconc?subconc:0) + parseInt(acc?acc:0)+parseInt( subacc?subacc:0);


                                    b.cond=parseInt(cond?cond:0) + parseInt(subcond?subcond:0) + parseInt(accd?accd:0)+parseInt(subaccd?subaccd:0);
                                    b.conc=parseInt(conc?conc:0) + parseInt(subconc?subconc:0) + parseInt(acc?acc:0)+parseInt( subacc?subacc:0);

                                    a.maind=parseInt(maind?maind:0) + parseInt(cond?cond:0) + parseInt(subcond?subcond:0) + parseInt(accd?accd:0)+parseInt(subaccd?subaccd:0);
                                    a.mainc=parseInt(mainc?mainc:0) + parseInt(conc?conc:0) + parseInt(subconc?subconc:0) + parseInt(acc?acc:0)+parseInt( subacc?subacc:0);


                                 /*   a.catd=parseInt(catd?catd:0) + parseInt(cond?cond:0) + parseInt(subcond?subcond:0) + parseInt(accd?accd:0)+parseInt(subaccd?subaccd:0);
                                    a.catc=parseInt(catc?catc:0) + parseInt(conc?conc:0) + parseInt(subconc?subconc:0) + parseInt(acc?acc:0)+parseInt( subacc?subacc:0);
console.log( a.catd);*/
                                })

                            })


                        })

                    })

                })
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

                        if(a.active==1){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Active' + ')'
                        }
                        else if(a.active==2){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Expired' + ')'
                        }
                        else if(a.active==3){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Suspended' + ')'
                        }
                        else if(a.active==4){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Terminated' + ')'
                        }
                        else if(a.active==5){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Absent' + ')'
                        }
                        else if(a.active==6){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Cancelled' + ')'
                        }
                        else if(a.active==7){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Not Assigned' + ')'
                        }
                    })
                }
                else if(v==1){
                    data.filter((a)=>{a.name=a.customer_name + ' ' + a.id})
                }
                else if(v==3){
                    data.filter((a)=>{a.name=a.name + ' ' + '('+ a.barcode +')'})
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
            this.$http.post('/search/customerdata?MOC='+v+r,{customerid:val}).then(result=>{
                let data =result.data;

                if(data){
                    this.searchId
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
                    else if (v == 1) {
                        this.customer_id = data.id;
                        this.customer = data.customer_name;
                        this.guest_contact = data.customer_contact;

                    }
                    else if (v == 3) {
                        this.employee_id = data.id;
                        this.customer = data.name;
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
                this.trials[k].p=e.target.max;
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
        accsearch:function(){
            if(this.accsearch.length==0){
                this.accountalreadySearched=false;
            }
            if( !this.accountalreadySearched){
                this.accountdata();
            }
        },
        paccsearch:function(){
            if(this.paccsearch.length==0){
                this.accountalreadySearchedP=false;
            }
            if( !this.accountalreadySearchedP){
                this.paccountdata();
            }
        },
        trialsM:function(){
            console.log(1);
        },
        customer:function(){
            if(this.customer.length==0){
                this.alreadySearched=false;
                this.searchId=null
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

