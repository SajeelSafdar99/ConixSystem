<template>
    <div>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

        <vue-snotify></vue-snotify>
        <modal v-if="addCompany" @save="saveCompany" @close="addCompany=!addCompany">
            <h3 slot="header">
                Add Unit
            </h3>
            <div slot="body">
                <div class="from-group">
                    <label>Unit Name</label>
                    <input type="text" v-model="company" class="form-control">
                </div>
            </div>
        </modal>
        <modal v-if="editCompany" @save="updateCompany" @close="editCompany=!editCompany">
            <h3 slot="header">
                Edit Unit
            </h3>
            <div slot="body">
                <div class="from-group">
                    <label>Unit Name</label>
                    <input type="text" v-model="updatedcompany" class="form-control">
                </div>
            </div>
        </modal>
        <modal v-if="addSubCompany" @save="saveSubCompany" @close="addSubCompany=!addSubCompany">
            <h3 slot="header">
                Add Cost Center
            </h3>
            <div slot="body">
                <div class="from-group">
                    <label>Cost Center Name</label>
                    <input type="text" v-model="scompany" class="form-control">
                </div>
            </div>
        </modal>
        <modal v-if="editSubCompany" @save="updateSubCompany" @close="editSubCompany=!editSubCompany">
            <h3 slot="header">
                Edit Cost Center
            </h3>
            <div slot="body">
                <div class="from-group">
                    <label>Cost Center Name</label>
                    <input type="text" v-model="updatedsubcompany" class="form-control">
                </div>
            </div>
        </modal>
        <modal v-if="addl3" @save="savel3" @close="addl3=!addl3">
            <h3 slot="header">

            </h3>
            <div slot="body">
                <div class="from-group">
                    <label>Account Name</label>
                    <input type="text" v-model="l3Ac" class="form-control">
                </div>
            </div>
        </modal>
        <modal v-if="addl4">
            <h3 slot="header">
                Add Main Control
            </h3>
            <div slot="body">
                <div class="from-group">
                    <label>Group Name</label>
                    <input type="text" v-model="l4Ac" class="form-control">

<br>
                        <label>Mark as Main Account</label>
                        <input type="checkbox"  v-model="subaccount"  >


                </div>
            </div>
            <div slot="footer">
                <button class="btn btn-outline-danger" @click="addl4 = false;">
                    Close
                </button>
                <button class="btn btn-outline-success" @click="savel4()">
                    Save
                </button>
                <button class="btn btn-outline-success" @click="savel4more();">
                    Save & Add More
                </button>
            </div>
        </modal>
        <modal v-if="editl4" @save="updatel4" @close="editl4=!editl4">
            <h3 slot="header">
                Edit Main Control
            </h3>
            <div slot="body">
                <div class="from-group">
                    <label>Group Name</label>
                    <input type="text" v-model="updatedl4Ac" class="form-control">
                    <template v-if="!this.mains==1">
                    <br>
                    <label>Mark as Main Account</label>
                    <input type="checkbox"  v-model="updatedl4desc"  >
                    </template>
                </div>
            </div>
        </modal>
        <modal v-if="addl5">
            <h3 slot="header">
                Add Control
            </h3>
            <div slot="body">
                <div class="from-group">
                    <label>Control Name</label>
                    <input type="text" v-model="l5Ac" class="form-control">

                    <br>
                    <label>Mark as Main Account</label>
                    <input type="checkbox"  v-model="subaccount"  >
                </div>
            </div>
            <div slot="footer">
                <button class="btn btn-outline-danger" @click="addl5 = false;">
                    Close
                </button>
                <button class="btn btn-outline-success" @click="savel5()">
                    Save
                </button>
                <button class="btn btn-outline-success" @click="savel5more();">
                    Save & Add More
                </button>
            </div>
        </modal>
        <modal v-if="editl5" @save="updatel5" @close="editl5=!editl5">
            <h3 slot="header">
                Edit Control
            </h3>
            <div slot="body">
                <div class="from-group">
                    <label>Control Name</label>
                    <input type="text" v-model="updatedl5Ac" class="form-control">
                    <template v-if="!this.mids==1">
                    <br>
                    <label>Mark as Main Account</label>
                    <input type="checkbox"  v-model="updatedl5desc"  >
                    </template>
                </div>
            </div>
        </modal>
        <modal v-if="addl6">
            <h3 slot="header">
                Add Sub Control
            </h3>
            <div slot="body">
                <div class="from-group">
                    <label>Sub Control Name</label>
                    <input type="text" v-model="l6Ac" class="form-control">
                    <br>
                    <label>Mark as Main Account</label>
                    <input type="checkbox"  v-model="subaccount"  >
                </div>
            </div>
            <div slot="footer">
                <button class="btn btn-outline-danger" @click="addl6 = false;">
                    Close
                </button>
                <button class="btn btn-outline-success" @click="savel6()">
                    Save
                </button>
                <button class="btn btn-outline-success" @click="savel6more();">
                    Save & Add More
                </button>
            </div>
        </modal>
        <modal v-if="editl6" @save="updatel6" @close="editl6=!editl6">
            <h3 slot="header">
                Edit Sub Control
            </h3>
            <div slot="body">
                <div class="from-group">
                    <label>Sub Control Name</label>
                    <input type="text" v-model="updatedl6Ac" class="form-control">
                    <template v-if="!this.subs==1">
                    <br>
                    <label>Mark as Main Account</label>
                    <input type="checkbox"  v-model="updatedl6desc"  >
                    </template>
                </div>
            </div>
        </modal>
        <modal v-if="addl7">
            <h3 slot="header">
                Add Account
            </h3>
            <div slot="body">
                <div class="from-group">
                    <label>Account Name</label>
                    <input type="text" v-model="l7Ac" class="form-control">
                    <br>
                    <label>Mark as Main Account</label>
                    <input type="checkbox"  v-model="subaccount"  >
                </div>
            </div>
            <div slot="footer">
                <button class="btn btn-outline-danger" @click="addl7 = false;">
                    Close
                </button>
                <button class="btn btn-outline-success" @click="savel7()">
                    Save
                </button>
                <button class="btn btn-outline-success" @click="savel7more();">
                    Save & Add More
                </button>
            </div>
        </modal>
        <modal v-if="editl7" @save="updatel7" @close="editl7=!editl7">
            <h3 slot="header">
                Edit Account
            </h3>
            <div slot="body">
                <div class="from-group">
                    <label>Sub Account Name</label>
                    <input type="text" v-model="updatedl7Ac" class="form-control">
                    <template v-if="!this.accs==1">
                        <br>
                        <label>Mark as Main Account</label>
                        <input type="checkbox"  v-model="updatedl7desc"  >
                    </template>
                </div>
            </div>
        </modal>
        <modal v-if="addl8">
            <h3 slot="header">
                Add Sub Account
            </h3>
            <div slot="body">
                <div class="from-group">
                    <label>Sub Account Name</label>
                    <input type="text" v-model="l8Ac" class="form-control">
                        <br>
                        <label>Mark as Main Account</label>
                        <input type="checkbox"  v-model="subaccount"  >
                </div>
            </div>
            <div slot="footer">
                <button class="btn btn-outline-danger" @click="addl8 = false;">
                    Close
                </button>
                <button class="btn btn-outline-success" @click="savel8()">
                    Save
                </button>
                <button class="btn btn-outline-success" @click="savel8more();">
                    Save & Add More
                </button>
            </div>
        </modal>
        <modal v-if="editl8" @save="updatel8" @close="editl8=!editl8">
            <h3 slot="header">
                Edit Sub Account
            </h3>
            <div slot="body">
                <div class="from-group">
                    <label>Sub Account Name</label>
                    <input type="text" v-model="updatedl8Ac" class="form-control">
                    <template v-if="!this.subaccs==1">
                        <br>
                        <label>Mark as Main Account</label>
                        <input type="checkbox"  v-model="updatedl8desc"  >
                    </template>
                </div>
            </div>
        </modal>
        <div id="wrapper">
            <div id="sidebar-wrapper">
                <aside id="sidebar">
                    <div class="sidebar-titlex" style="font-size: 15px;">{{this.organization}}</div>
                    <ul id="sidemenu" class="sidebar-nav">
                        <li v-for="c in level.l1">
                            <div class="row" style="background: #0a2c50!important;">
                            <a class="accordion-toggle collapsed toggle-switch" data-toggle="collapse" :href="'#com'+c.code">
                                <span style="    text-indent: 16px;" class="sidebar-icon">{{c.code}}</span>

                                <span class="sidebar-title">{{c.name}}</span>

                                <b class="caret"></b>
                            </a>
&nbsp&nbsp
                            <a  @click="openEditCompany(c.name,c.code)"><i class="fas fa-edit"></i></a>
                                &nbsp
                            <a  @click="deleteCompany(c.name,c.code)"><i class="fas fa-trash"></i></a></div>

                            <ul :id="'com'+c.code" class="panel-collapse collapse panel-switch" role="menu">

                                <li v-for="cs in level.l2.filter((a)=>{return a.code.split('-')[0]==c.code})">
                                    <div class="row" style="background: #024828!important; ">
                                    <a href="#" @click.prevent="selectedl.l2=cs.code;loadl3()" >
                                    <small class="">({{cs.code}})</small>

                                        {{cs.name}}
                                    </a>
                                    <a  @click="openEditSubCompany(cs.name,cs.code);selectedl.l1=cs.code"><i class="fas fa-edit"></i></a>
                                    <a  @click="deleteSubCompany(cs.name,cs.code);selectedl.l1=cs.code"><i class="fas fa-trash"></i></a>
                                    </div>
                                </li>
                                <li>
                                    <a @click.prevent="addSubCompany=!addSubCompany;selectedl.l1=c.code" href="#"
                                      >
                                        <span class="sidebar-icon"><i class="fas fa-plus"></i></span>
                                        <span class="sidebar-title">Add New Cost Center</span>

                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li>
                            <a class="accordion-toggle collapsed toggle-switch" @click.prevent="addCompany=!addCompany"
                               data-toggle="collapse" href="#">
                                <span class="sidebar-icon"><i class="fas fa-plus"></i></span>
                                <span class="sidebar-title">Add New Unit</span>

                            </a>

                        </li>

                    </ul>
                </aside>
            </div>
            <template v-if="">
            <div v-if="categories.length>0" class="panel with-nav-tabs panel-info">
                <div class="panel-heading">
                    <ul class="nav nav-tabs">
                        <li v-for="a in categories" :class="{'active':a.id==category}"><a @click.prevent="category=a.id;loadLevel45()"  data-toggle="tab">{{a.id}} - {{a.name}}  </a></li>

                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div v-for="a in categories" :class="{'in active':a.id==category}" class="tab-pane fade" >
                            <div>                  <div class="panel panel-default">

                                <div class="panel-body">
                                    <button type="button" class="btn btn-default" @click="parent=''; addl4=!addl4">Add Main Control</button>

                                </div>
                            </div>    </div>
                            <div class="panel panel-default" v-for="(n,index) in controls.filter((a)=>{return a.parent==null})">
                                <div class="panel-heading">{{n.code}} - {{n.name}}
                                    <template v-if="n.desc==1">

                                    </template>
                                    <template v-else>
                                        <button v-on:click=toggle(index)>   <b class="caret"></b></button>
                                    </template>
                                    <div style="float:right;">
                                    <a @click="parent=''; openEditMainControl(n.name,n.code,n.desc);"><i class="fas fa-edit"></i></a>
                                    <a  @click="parent=''; deleteMainControl(n.name,n.code);"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div>
                                <div class=" panel-body"  v-if="n.visible==true">
                                    <ul class="list-unstyled" >
                                        <li>  <button type="button" class="btn btn-default" @click="parent=n.code; addl5=!addl5">Add Control</button></li>
                                        <li v-for="(cn,sindex) in controls.filter((a)=>{return a.parent==n.code})">{{cn.code}} - {{cn.name}}
                                            <template v-if="cn.desc==1">

                                            </template>
                                            <template v-else>
                                                <button v-on:click=ttoggle(sindex,n)>  <b class="caret"></b></button>
                                            </template>
                                            <a  @click="parent=n.code; deleteMainControl(cn.name,cn.code);"><i class="fas fa-trash"></i></a>
                                            <a @click="parent=n.code; openEditControl(cn.name,cn.code,cn.desc);"><i class="fas fa-edit"></i></a>

                                            <template v-if="!cn.desc==1">
                                                <button style="float:right; line-height: 0.9;" type="button" class="btn btn-sm btn-default" @click.prevent="parent=cn.code;addl6=!addl6">Add Sub Control</button>
                                            </template>
                                             <!-- <a href="#"  @click.prevent="parent=cn.code;addl6=!addl6">Add Sub Control</a>-->
                                        <ul v-if="controls.filter((a)=>{return a.parent==cn.code}) && cn.vvisible==true">
                                            <li v-for="(cnc,xindex) in controls.filter((a)=>{return a.parent==cn.code})">
                                                {{cnc.code}} - {{cnc.name}}
                                                <template v-if="cnc.desc==1">

                                                </template>
                                                <template v-else>
                                                <button v-on:click=tttoggle(xindex,cn)>   <b style="color: black;" class="caret"></b></button>
                                                </template>
                                                <a style="color:black;" @click="parent=cn.code; deleteMainControl(cnc.name,cnc.code);"><i class="fas fa-trash"></i></a>
                                                <a style="color:black;" @click="parent=cn.code; openEditSubControl(cnc.name,cnc.code,cnc.desc);"><i class="fas fa-edit"></i></a>
                                                <template v-if="!cnc.desc==1">
                                                <button style="float:right; line-height: 0.9;" type="button" class="btn btn-sm btn-default" @click.prevent="parent=cnc.code;addl7=!addl7">Add Account</button>  <!-- <a href="#"  @click.prevent="parent=cnc.code;addl7=!addl7">Add Sub Account</a>-->
                                                </template>
                                                <ul v-if="controls.filter((a)=>{return a.parent==cnc.code}) && cnc.vvvisible==true">
                                                    <li v-for="(cncc,xindex) in controls.filter((a)=>{return a.parent==cnc.code})">{{cncc.code}} - {{cncc.name}}
                                                        <template v-if="cncc.desc==1">

                                                        </template>
                                                        <template v-else>
                                                            <button v-on:click=ttttoggle(xindex,cnc)>   <b style="color: black;" class="caret"></b></button>
                                                        </template>
                                                        <a  @click="parent=cnc.code; deleteMainControl(cncc.name,cncc.code);"><i class="fas fa-trash"></i></a>
                                                        <a @click="parent=cnc.code; openEditAccount(cncc.name,cncc.code,cncc.desc);"><i class="fas fa-edit"></i></a>



                                                    <template v-if="!cncc.desc==1">
                                                        <button style="float:right; line-height: 0.9;" type="button" class="btn btn-sm btn-default" @click.prevent="parent=cncc.code;addl8=!addl8">Add Sub Account</button>  <!-- <a href="#"  @click.prevent="parent=cnc.code;addl7=!addl7">Add Sub Account</a>-->
                                                    </template>
                                                    <ul v-if="controls.filter((a)=>{return a.parent==cncc.code}) && cncc.vvvvisible==true">
                                                        <li v-for="cnccc in controls.filter((a)=>{return a.parent==cncc.code})">{{cnccc.code}} - {{cnccc.name}}

                                                            <a  @click="parent=cncc.code; deleteMainControl(cnccc.name,cnccc.code);"><i class="fas fa-trash"></i></a>
                                                            <a @click="parent=cncc.code; openEditSubAccount(cnccc.name,cnccc.code,cnccc.desc);"><i class="fas fa-edit"></i></a> </li>


                                                    </ul>
                                                    </li>
                                                </ul>
                                            </li>

                                        </ul>

                                        </li>



                                    </ul>
                                </div>
                            </div>


                        </div>
                         </div>
                </div>
            </div>

        </template>
        </div>
    </div>

</template>
<style>
#sidebar-wrapper {
    border-right: 1px solid #e7e7e7;
}

#sidebar-wrapper {
    z-index: 1000;
    position: fixed;
    left: 225px;
    width: 0;
    height: 100%;
    margin-left: -225px;
    overflow-y: auto;
    background: #f8f8f8;
    -webkit-transition: all .5s ease;
    -moz-transition: all .5s ease;
    -o-transition: all .5s ease;
    transition: all .5s ease;
}

#sidebar-wrapper .sidebar-nav {
    position: absolute;
    top: 0;

    font-size: 14px;
    margin: 0;
    padding: 0;
    list-style: none;
    width: 250px;
}

#sidebar-wrapper .sidebar-nav li {
    text-indent: 0;
    line-height: 45px;
}

#sidebar-wrapper .sidebar-nav li a {
    display: block;
    text-decoration: none;
    color: #428bca;
}

.sidebar-nav li:first-child a {
    background: #92bce0 !important;
    color: #fff !important;
}
.panel-body>ul>li{
    display:block;
    background:#c6d02b;
    margin-bottom:10px;
    border:1px solid #ddd;
    padding:10px 20px;
    font-size:18px;
    color:#000;
}
.panel-body>ul>li a{
    float:right;
    text-decoration:none;
    color:#000;
}
.panel-body>ul>li>ul>li{
    list-style:none;
    background:#94390d;
    border:1px solid red;
    margin-bottom:10px;
    padding:10px 20px;
    color:#fff;
}
.panel-body>ul>li>ul>li>a{
    color:#fff;
}
.panel-body>ul>li>ul>li>ul>li{

    list-style:none;
    background:#4b41ea;
    border:1px solid red;
    margin-bottom:10px;
    padding:10px 20px;
    color:#000;
}
.panel-body>ul>li>ul>li>ul>li>ul>li{

    list-style:none;
    background:#0ac308;
    border:1px solid blue;
    margin-bottom:10px;
    padding:10px 20px;
    color:#000;
}
#sidebar-wrapper .sidebar-nav li a .sidebar-icon {
    width: 45px;
    height: 45px;
    font-size: 14px;
    padding: 0 2px;
    display: inline-block;
    text-indent: 7px;
    margin-right: 10px;
    color: #fff;
    float: left;
}

#sidebar-wrapper .sidebar-nav li a .caret {
    position: absolute;
    right: 23px;
    top: auto;
    margin-top: 20px;
}

#sidebar-wrapper .sidebar-nav li ul.panel-collapse {
    list-style: none;
    -moz-padding-start: 0;
    -webkit-padding-start: 0;
    -khtml-padding-start: 0;
    -o-padding-start: 0;
    padding-start: 0;
    padding: 0;
}

#sidebar-wrapper .sidebar-nav li ul.panel-collapse li i {
    margin-right: 10px;
}

#sidebar-wrapper .sidebar-nav li ul.panel-collapse li {
    text-indent: 15px;
}


.sidebar-nav li:first-child a {
    background: #92bce0 !important;
    color: #fff !important;
}

.sidebar-nav li:nth-child(2) a {
    background: #6aa3d5 !important;
    color: #fff !important;
}

.sidebar-nav li:nth-child(3) a {
    background: #428bca !important;
    color: #fff !important;
}

.sidebar-nav li:nth-child(4) a {
    background: #3071a9 !important;
    color: #fff !important;
}

.sidebar-nav li:nth-child(5) a {
    background: #245682 !important;
    color: #fff !important;
}
.sidebar-titlex{
    position: absolute;
    top: 0;
    z-index: 999;
    font-size: 20px;
    color: #fff;
    width: 100%;
    background: #000;
}
#wrapper {
    padding-top: 50px;
    padding-left: 0;
    -webkit-transition: all .5s ease;
    -moz-transition: all .5s ease;
    -o-transition: all .5s ease;
    transition: all .5s ease;
}

@media (min-width: 992px) {
    #wrapper {
        padding-left: 225px;
    }
}

@media (min-width: 992px) {
    #wrapper #sidebar-wrapper {
        width: 250px;
    }
}

@media (max-width: 992px) {
    #wrapper #sidebar-wrapper {
        width: 45px;
    }

    #wrapper #sidebar-wrapper #sidebar #sidemenu li ul {
        position: fixed;
        left: 45px;
        margin-top: -45px;
        z-index: 1000;
        width: 200px;
        height: 0;
    }
}
#sidebar-wrapper .sidebar-nav li ul li a {
    background: #024828!important;
    border-bottom: 1px solid #02270e;
}
#sidebar-wrapper .sidebar-nav li a {
    display: block;
    text-decoration: none;
    color: #428bca;
    background: #0a2c50!important;
}
#sidebar-wrapper .sidebar-nav{
    padding-top:26px
}
</style>
<script>
import Datepicker from 'vuejs-datepicker';
import modal from "./modal";

export default {
    name: "COA",
    components: {
        Datepicker, modal
    },
    data() {
        return {
            parent:'',
            category:0,
            addCompany: false,
            editCompany: false,
            addl3: false,
            addl4: false,
            editl4: false,
            addl5: false,
            editl5: false,
            addl6: false,
            editl6: false,
            addl7: false,
            editl7: false,
            addl8: false,
            editl8: false,
            l6Ac:'',
            l7Ac:'',
            l8Ac:'',
            l5Ac:'',
            l4Ac:'',
            l3Ac:'',

            updatedl4Ac:'',
            updatedl4code:'',
            updatedl4desc:'',

            updatedl5Ac:'',
            updatedl5code:'',
            updatedl5desc:'',

            updatedl6Ac:'',
            updatedl6code:'',
            updatedl6desc:'',

            updatedl7Ac:'',
            updatedl7code:'',
            updatedl7desc:'',

            updatedl8Ac:'',
            updatedl8code:'',
            updatedl8desc:'',

            addSubCompany: false,
            editSubCompany: false,
            company: '',
            scompany: '',
            actab:0,
            categories:[],
            accounts:[],
            controls:[],

            level:{
                l1:[],
                l2:[],

            },
            selectedl: {
                l1: 0,
                l2: 0,
             },
            updatedcompany:'',
            updatedcode:'',
            updatedsubcompany:'',
            updatedsubcode:'',
            organization:'',
            visible: true,
            vvisible: true,
            vvvisible: true,
            vvvvisible: true,
            subaccount:false,
            mains:'',
            mids:'',
            subs:'',
            accs:'',
            subaccs:'',
        }
    },
    computed: {},
    methods: {
        toggle(key) {
            console.log("HI");
            var vm = this;
            if (!vm.controls.filter((a)=>{return a.parent==null})[key].visible) {
                vm.controls.filter((a)=>{return a.parent==null})[key].visible = true;
            } else  {
                vm.controls.filter((a)=>{return a.parent==null})[key].visible = false;
            }
        },
        ttoggle(key,n) {
            console.log("HII");
            var vm = this;
            if (!vm.controls.filter((a)=>{return a.parent==n.code})[key].vvisible) {
                vm.controls.filter((a)=>{return a.parent==n.code})[key].vvisible = true;
            } else  {
                vm.controls.filter((a)=>{return a.parent==n.code})[key].vvisible = false;
            }
        },
        tttoggle(key,cn) {
            console.log("HIII");
            var vm = this;
            if (!vm.controls.filter((a)=>{return a.parent==cn.code})[key].vvvisible) {
                vm.controls.filter((a)=>{return a.parent==cn.code})[key].vvvisible = true;
            } else  {
                vm.controls.filter((a)=>{return a.parent==cn.code})[key].vvvisible = false;
            }
        },
        ttttoggle(key,cnc) {
            console.log("HIIII");
            var vm = this;
            if (!vm.controls.filter((a)=>{return a.parent==cnc.code})[key].vvvvisible) {
                vm.controls.filter((a)=>{return a.parent==cnc.code})[key].vvvvisible = true;
            } else  {
                vm.controls.filter((a)=>{return a.parent==cnc.code})[key].vvvvisible = false;
            }
        },
        saveCompany: function () {
            this.$http.post('coa/save/level/1', {'name': this.company}).then((r) => {
                if (r.status == 200) {
                    this.addCompany = false;
                    this.level.l1=r.data;
                    this.company=''
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        } ,
        openEditCompany: function (name,code) {
            this.editCompany = true;
            this.updatedcompany=name;
            this.updatedcode=code;
        } ,
        updateCompany: function () {
            this.$http.post('coa/update/level/1', {'name': this.updatedcompany, 'code':this.updatedcode}).then((r) => {
                if (r.status == 200) {
                    this.editCompany = false;
                    this.updatedcompany='';
                    this.updatedcode='';
                    this.level.l1=r.data;
                    this.company=''
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        } ,
        deleteCompany: function (name,code) {
            if(confirm("Are you sure ?")){
                this.$http.post('coa/delete/level/1', {'name': name, 'code':code}).then((r) => {
                    if (r.status == 200) {
                        this.company=''
                        this.level.l1=r.data;
                    }
                    else{
                        this.$snotify.error('Something went wrong with request.');
                    }
                })
            }

        } ,
        openEditSubCompany: function (name,code) {
            this.editSubCompany = true;
            this.updatedsubcompany=name;
            this.updatedsubcode=code;
        } ,
        saveSubCompany: function () {
            this.$http.post('coa/save/level/2', {'name': this.scompany,'level':this.selectedl.l1}).then((r) => {
                if (r.status == 200) {
                    this.addSubCompany = false;
                    this.level.l2=r.data;
                    this.scompany=''
                    this.selectedl.l1=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },
        updateSubCompany: function () {
            this.$http.post('coa/update/level/2', {'name': this.updatedsubcompany,'code':this.updatedsubcode}).then((r) => {
                if (r.status == 200) {
                    this.editSubCompany = false;
                    this.updatedsubcompany='';
                    this.updatedsubcode='';
                    this.level.l2=r.data;
                    this.scompany=''
                    this.selectedl.l1=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        } ,
        deleteSubCompany: function (name,code) {
            if(confirm("Are you sure ?")){
                this.$http.post('coa/delete/level/2', {'name': name, 'code':code}).then((r) => {
                    if (r.status == 200) {
                        this.scompany=''
                        this.level.l2=r.data;
                    }
                    else{
                        this.$snotify.error('Something went wrong with request.');
                    }
                })
            }

        } ,
        savel3:function(){
            this.$http.post('coa/save/level/3', {'name': this.l3Ac,'level':this.selectedl.l2}).then((r) => {
                if (r.status == 200) {
                    this.add3 = false;
                    this.level.l3=r.data;
                    this.l3Ac=''
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },
        openEditMainControl: function (name,code,desc) {

            this.updatedl4Ac=name;
            this.updatedl4code=code;
            this.updatedl4desc=desc;

            this.$http.post('coa/checkmaincontrol', {'code':code}).then((r) => {
                if (r.status == 200) {
                    this.mains=r.data;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })

            this.editl4 = true;
        } ,
        savel4:function(){
            this.$http.post('coa/saveAccount', {'name': this.l4Ac,'parent':this.parent,'category':this.category,'desc':0, 'subaccount':this.subaccount}).then((r) => {
                if (r.status == 200) {
                    this.addl4 = false;
                    this.controls=r.data;

                    this.l4Ac='';
                    this.subaccount=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        }, savel4more:function(){
            this.$http.post('coa/saveAccount', {'name': this.l4Ac,'parent':this.parent,'category':this.category,'desc':0, 'subaccount':this.subaccount}).then((r) => {
                if (r.status == 200) {
                    this.controls=r.data;

                    this.l4Ac='';
                    this.subaccount=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },

        updatel4:function(){
            this.$http.post('coa/updateAccount', {'code': this.updatedl4code,'name': this.updatedl4Ac,'parent':this.parent,'category':this.category,'desc':this.updatedl4desc}).then((r) => {
                if (r.status == 200) {
                    this.editl4 = false;
                    this.controls=r.data;
                    this.updatedl4code='';
                    this.updatedl4Ac='';
                    this.updatedl4desc='';
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },

        deleteMainControl: function (name,code) {

    this.$http.post('coa/checkmaincontrol', {'code':code}).then((r) => {
        if (r.status == 200 && r.data==1) {
            this.$snotify.error('This Level of Account cannot be deleted.');
        }
        else if(r.data!=1){
            if(confirm("Are you sure ?")){
                this.$http.post('coa/deleteAccount', {'name': name, 'code':code,'parent':this.parent,'category':this.category,'desc':0}).then((r) => {
                    if (r.status == 200) {
                        this.controls=r.data;
                    }
                    else{
                        this.$snotify.error('Something went wrong with request.');
                    }
                })
            }
        }
        else{
            this.$snotify.error('Something went wrong with request.');
        }
    })

        } ,
        openEditControl: function (name,code,desc) {

            this.updatedl5Ac=name;
            this.updatedl5code=code;
            this.updatedl5desc=desc;

            this.$http.post('coa/checkcontrol', {'code':code}).then((r) => {
                if (r.status == 200) {
                    this.mids=r.data;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })

            this.editl5 = true;
        } ,
        savel5:function(){
            this.$http.post('coa/saveAccount', {'name': this.l5Ac,'parent':this.parent,'category':this.category,'desc':0, 'subaccount':this.subaccount}).then((r) => {
                if (r.status == 200) {
                    this.addl5 = false;
                    this.controls=r.data;
                    this.l5Ac=''
                    this.subaccount=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },
        savel5more:function(){
            this.$http.post('coa/saveAccount', {'name': this.l5Ac,'parent':this.parent,'category':this.category,'desc':0, 'subaccount':this.subaccount}).then((r) => {
                if (r.status == 200) {
                    this.controls=r.data;
                    this.l5Ac=''
                    this.subaccount=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },
        updatel5:function(){
            this.$http.post('coa/updateAccount', {'code': this.updatedl5code,'name': this.updatedl5Ac,'parent':this.parent,'category':this.category,'desc':this.updatedl5desc}).then((r) => {
                if (r.status == 200) {
                    this.editl5 = false;
                    this.controls=r.data;
                    this.updatedl5code='';
                    this.updatedl5Ac='';
                    this.updatedl5desc='';
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },
        openEditSubControl: function (name,code,desc) {
            this.updatedl6Ac=name;
            this.updatedl6code=code;
            this.updatedl6desc=desc;

            this.$http.post('coa/checksubcontrol', {'code':code}).then((r) => {
                if (r.status == 200) {
                    this.subs=r.data;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
            this.editl6 = true;
        } ,
        savel6:function(){
            this.$http.post('coa/saveAccount', {'name': this.l6Ac,'parent':this.parent,'category':this.category,'desc':0, 'subaccount':this.subaccount}).then((r) => {
                if (r.status == 200) {
                    this.addl6 = false;
                    this.controls=r.data;
                    this.l6Ac=''
                    this.subaccount=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },
        savel6more:function(){
            this.$http.post('coa/saveAccount', {'name': this.l6Ac,'parent':this.parent,'category':this.category,'desc':0, 'subaccount':this.subaccount}).then((r) => {
                if (r.status == 200) {
                    this.controls=r.data;
                    this.l6Ac=''
                    this.subaccount=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },
        updatel6:function(){
            this.$http.post('coa/updateAccount', {'code': this.updatedl6code,'name': this.updatedl6Ac,'parent':this.parent,'category':this.category,'desc':this.updatedl6desc}).then((r) => {
                if (r.status == 200) {
                    this.editl6 = false;
                    this.controls=r.data;
                    this.updatedl6code='';
                    this.updatedl6Ac='';
                    this.updatedl6desc='';
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },
        openEditAccount: function (name,code,desc) {
            this.updatedl7Ac=name;
            this.updatedl7code=code;
            this.updatedl7desc=desc;

            this.$http.post('coa/checkaccount', {'code':code}).then((r) => {
                if (r.status == 200) {
                    this.accs=r.data;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
            this.editl7 = true;
        } ,
        openEditSubAccount: function (name,code,desc) {
            this.updatedl8Ac=name;
            this.updatedl8code=code;
            this.updatedl8desc=desc;

            this.$http.post('coa/checksubaccount', {'code':code}).then((r) => {
                if (r.status == 200) {
                    this.subaccs=r.data;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
            this.editl8 = true;
        } ,
        savel7:function(){
            this.$http.post('coa/saveAccount', {'name': this.l7Ac,'parent':this.parent,'category':this.category,'desc':0, 'subaccount':this.subaccount}).then((r) => {
                if (r.status == 200) {
                    this.addl7 = false;
                    this.controls=r.data;
                    this.l7Ac=''
                    this.subaccount=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },
        savel7more:function(){
            this.$http.post('coa/saveAccount', {'name': this.l7Ac,'parent':this.parent,'category':this.category,'desc':0, 'subaccount':this.subaccount}).then((r) => {
                if (r.status == 200) {
                    this.controls=r.data;
                    this.l7Ac=''
                    this.subaccount=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },
        updatel7:function(){
            this.$http.post('coa/updateAccount', {'code': this.updatedl7code,'name': this.updatedl7Ac,'parent':this.parent,'category':this.category,'desc':this.updatedl7desc}).then((r) => {
                if (r.status == 200) {
                    this.editl7 = false;
                    this.controls=r.data;
                    this.updatedl7code='';
                    this.updatedl7Ac='';
                    this.updatedl7desc='';
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },

        savel8:function(){
            this.$http.post('coa/saveAccount', {'name': this.l8Ac,'parent':this.parent,'category':this.category,'desc':0, 'subaccount':this.subaccount}).then((r) => {
                if (r.status == 200) {
                    this.addl8 = false;
                    this.controls=r.data;
                    this.l8Ac=''
                    this.subaccount=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },savel8more:function(){
            this.$http.post('coa/saveAccount', {'name': this.l8Ac,'parent':this.parent,'category':this.category,'desc':0, 'subaccount':this.subaccount}).then((r) => {
                if (r.status == 200) {
                    this.controls=r.data;
                    this.l8Ac=''
                    this.subaccount=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },
        updatel8:function(){
            this.$http.post('coa/updateAccount', {'code': this.updatedl8code,'name': this.updatedl8Ac,'parent':this.parent,'category':this.category,'desc':this.updatedl8desc}).then((r) => {
                if (r.status == 200) {
                    this.editl8 = false;
                    this.controls=r.data;
                    this.updatedl8code='';
                    this.updatedl8Ac='';
                    this.updatedl8desc='';
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },

        loadl3:function(){

            this.$http.get('coa/loadCategory').then((r) => {
                if (r.status == 200) {
                    // this.addSubCompany = false;
                    this.categories=r.data;
                    if(r.data.length>0){
                        this.category=r.data[0].id;
                     //   this.selectedl.l3=r.data[0].code;
                        this.loadLevel45()

                    }
                    // this
                    // this.scompany=''
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        }, loadcompany:function(){
            this.$http.get('coa/loadCompany').then((r) => {
                if (r.status == 200) {
                    this.organization=r.data[0];
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },
        loadLevel12:function(){
            this.$http.get('coa/get/level/1,2').then((r) => {
                if (r.status == 200) {
                    // this.addSubCompany = false;
                    this.level.l1=r.data[1];
                    this.level.l2=r.data[2];
                    // this.scompany=''
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },  loadLevel45:function(){
            this.$http.get('coa/loadAccounts?cat='+this.category).then((r) => {
                if (r.status == 200) {
                    // this.addSubCompany = false;
                    this.controls=r.data;
                    // this.scompany=''
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },
        defalutAcc:function(){
            this.$http.get('coa/default/l/'+this.selectedl.l2).then((r) => {
                if (r.status == 200) {

this.loadl3()                    // this.level.l2=r.data[2];
                    // this.scompany=''
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        }
    },
    watch: {

    },
    mounted() {
    this.loadLevel12();
    this.loadl3();
    this.loadcompany();

    }
}
</script>

