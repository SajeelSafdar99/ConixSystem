<template>
    <div>
        <link rel="stylesheet" href="/assets/plugins/bootstrap/dist/css/bootstrap.min.css" type="text/css"/>

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
                    <label>Code</label>
                    <input type="text" v-model="codel4Ac" class="form-control">
                    <br>
                    <label>Group Name</label>
                    <input type="text" v-model="l4Ac" class="form-control">
                    <br>
                    <label>Remarks</label>
                    <textarea v-model="remarksl4Ac" class="form-control"></textarea>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                    <label>Mark as Main Account</label>
                    <input type="checkbox"  v-model="subaccount"  >
                        </div>
                        <div class="col-sm-6">
                    <label>Show in Dropdown</label>
                    <input type="checkbox"  v-model="dropdown"  >
                        </div>
                    </div>
                    <br>
                    <template v-if="dropdown==true">
                     <select v-model="cost_center" id="cost_center" name="cost_center" class="form-control input-height select2">
                         <option value="0">Choose Option</option>
                         <option v-for="cc in cost_centers" :value="cc.id">
                                {{cc.name}}
                            </option>
                     </select>
<!--                    <div class="form-group has-search"  v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">
                        <input type="text" class="form-control typeahead" autocomplete="off" v-model="search"  tabindex="1" name="search" placeholder="Search by Unit...">
                        <input type="hidden" v-model="cost_center" name="cost_center" >
                        <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.search && searchedunits.length>0">

                            <li  :class="'fbb fba'+key" @click="unitdatavalue(itd.id)" v-for="(itd,key) in searchedunits">
                                <a href="javascript:void(0)">{{itd.code}} - {{itd.name}} (<template v-if="ccs.filter(function(a){return a.code==itd.desc})[0]">{{ccs.filter(function(a){return a.code==itd.desc})[0].name}}</template>)</a>
                            </li>
                        </ul>
                    </div>-->
                    </template>
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
                    <label>Code</label>
                    <input type="text" v-model="updatedl4code" class="form-control">
                    <br>
                    <label>Group Name</label>
                    <input type="text" v-model="updatedl4Ac" class="form-control">
                    <br>
                    <label>Remarks</label>
                    <textarea v-model="updatedl4remarks" class="form-control"></textarea>
                    <br>
                    <div class="row">
                        <template v-if="this.mains!=1">
                        <div class="col-sm-6">
                                <label>Mark as Main Account</label>
                                <input type="checkbox"  v-model="updatedl4desc"  >
                        </div>
                        </template>
                        <div class="col-sm-6">
                            <label>Show in Dropdown</label>
                            <input type="checkbox"  v-model="updatedl4show"  >
                        </div>
                    </div>

                    <br>
                    <template v-if="updatedl4show==true">
                        <select v-model="cost_center" id="cost_center" name="cost_center" class="form-control input-height select2">
                            <option value="0">Choose Option</option>
                            <option v-for="cc in cost_centers" :value="cc.id">
                                {{cc.name}}
                            </option>
                        </select>
<!--                        <div class="form-group has-search"  v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">
                            <input type="text" class="form-control typeahead" autocomplete="off" v-model="search"  tabindex="1" name="search" placeholder="Search by Unit...">
                            <input type="hidden" v-model="cost_center" name="cost_center" >
                            <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.search && searchedunits.length>0">

                                <li  :class="'fbb fba'+key" @click="unitdatavalue(itd.id)" v-for="(itd,key) in searchedunits">
                                    <a href="javascript:void(0)">{{itd.code}} - {{itd.name}} (<template v-if="ccs.filter(function(a){return a.code==itd.desc})[0]">{{ccs.filter(function(a){return a.code==itd.desc})[0].name}}</template>)</a>
                                </li>
                            </ul>
                        </div>-->
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
<div class="row">
    <div class="col-sm-6"><label>Code</label>
        <template v-if="childl5Ac==0">
            <input type="text" v-model="codel5Ac" class="form-control">
        </template>
        <template v-else>
            <input type="text" readonly v-model="childl5Ac" class="form-control">
        </template>
    </div>
    <div class="col-sm-6"><label>Parent</label>
        <input type="text" readonly v-model="parentl5Ac" class="form-control"></div>
</div>
                    <br>
                    <label>Control Name</label>
                    <input type="text" v-model="l5Ac" class="form-control">
                    <br>
                    <label>Remarks</label>
                    <textarea v-model="remarksl5Ac" class="form-control"></textarea>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Mark as Main Account</label>
                            <input type="checkbox"  v-model="subaccount"  >
                        </div>
                        <div class="col-sm-6">
                            <label>Show in Dropdown</label>
                            <input type="checkbox"  v-model="dropdown"  >
                        </div>
                    </div>
                    <br>
                    <template v-if="dropdown==true">
                        <select v-model="cost_center" id="cost_center" name="cost_center" class="form-control input-height select2">
                            <option value="0">Choose Option</option>
                            <option v-for="cc in cost_centers" :value="cc.id">
                                {{cc.name}}
                            </option>
                        </select>
<!--                        <div class="form-group has-search"  v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">
                            <input type="text" class="form-control typeahead" autocomplete="off" v-model="search"  tabindex="1" name="search" placeholder="Search by Unit...">
                            <input type="hidden" v-model="cost_center" name="cost_center" >
                            <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.search && searchedunits.length>0">

                                <li  :class="'fbb fba'+key" @click="unitdatavalue(itd.id)" v-for="(itd,key) in searchedunits">
                                    <a href="javascript:void(0)">{{itd.code}} - {{itd.name}} (<template v-if="ccs.filter(function(a){return a.code==itd.desc})[0]">{{ccs.filter(function(a){return a.code==itd.desc})[0].name}}</template>)</a>
                                </li>
                            </ul>
                        </div>-->
                    </template>
                </div>
            </div>
            <div slot="footer">
                <button class="btn btn-outline-danger" @click="addl5 = false; ">
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

                    <div class="row">
                        <div class="col-sm-6"><label>Code</label>
                            <input type="text" v-model="updatedl5code" class="form-control"></div>
                        <div class="col-sm-6"><label>Parent</label>
                            <input type="text" readonly v-model="parent" class="form-control"></div>
                    </div>
                    <br>
                    <label>Control Name</label>
                    <input type="text" v-model="updatedl5Ac" class="form-control">
                    <br>
                    <label>Remarks</label>
                    <textarea v-model="updatedl5remarks" class="form-control"></textarea>
                    <br>
                    <div class="row">
                        <template v-if="this.mids!=1">
                        <div class="col-sm-6">
                                <label>Mark as Main Account</label>
                                <input type="checkbox"  v-model="updatedl5desc"  >
                        </div>
                        </template>
                        <div class="col-sm-6">
                            <label>Show in Dropdown</label>
                            <input type="checkbox"  v-model="updatedl5show"  >
                        </div>
                    </div>
                    <br>
                    <template v-if="updatedl5show==true">
                        <select v-model="cost_center" id="cost_center" name="cost_center" class="form-control input-height select2">
                            <option value="0">Choose Option</option>
                            <option v-for="cc in cost_centers" :value="cc.id">
                                {{cc.name}}
                            </option>
                        </select>
<!--                        <div class="form-group has-search"  v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">
                            <input type="text" class="form-control typeahead" autocomplete="off" v-model="search"  tabindex="1" name="search" placeholder="Search by Unit...">
                            <input type="hidden" v-model="cost_center" name="cost_center" >
                            <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.search && searchedunits.length>0">

                                <li  :class="'fbb fba'+key" @click="unitdatavalue(itd.id)" v-for="(itd,key) in searchedunits">
                                    <a href="javascript:void(0)">{{itd.code}} - {{itd.name}} (<template v-if="ccs.filter(function(a){return a.code==itd.desc})[0]">{{ccs.filter(function(a){return a.code==itd.desc})[0].name}}</template>)</a>
                                </li>
                            </ul>
                        </div>-->
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
                    <div class="row">
                        <div class="col-sm-6"><label>Code</label>
                            <template v-if="childl6Ac==0">
                                <input type="text" v-model="codel6Ac" class="form-control">
                            </template>
                            <template v-else>
                                <input type="text" readonly v-model="childl6Ac" class="form-control">
                            </template>
                        </div>
                        <div class="col-sm-6"><label>Parent</label>
                            <input type="text" readonly v-model="parentl6Ac" class="form-control"></div>
                    </div>

                    <br>

                    <label>Sub Control Name</label>
                    <input type="text" v-model="l6Ac" class="form-control">
                    <br>
                    <label>Remarks</label>
                    <textarea v-model="remarksl6Ac" class="form-control"></textarea>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Mark as Main Account</label>
                            <input type="checkbox"  v-model="subaccount"  >
                        </div>
                        <div class="col-sm-6">
                            <label>Show in Dropdown</label>
                            <input type="checkbox"  v-model="dropdown"  >
                        </div>
                    </div>
                    <br>
                    <template v-if="dropdown==true">
                        <select v-model="cost_center" id="cost_center" name="cost_center" class="form-control input-height select2">
                            <option value="0">Choose Option</option>
                            <option v-for="cc in cost_centers" :value="cc.id">
                                {{cc.name}}
                            </option>
                        </select>
<!--                        <div class="form-group has-search"  v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">
                            <input type="text" class="form-control typeahead" autocomplete="off" v-model="search"  tabindex="1" name="search" placeholder="Search by Unit...">
                            <input type="hidden" v-model="cost_center" name="cost_center" >
                            <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.search && searchedunits.length>0">

                                <li  :class="'fbb fba'+key" @click="unitdatavalue(itd.id)" v-for="(itd,key) in searchedunits">
                                    <a href="javascript:void(0)">{{itd.code}} - {{itd.name}} (<template v-if="ccs.filter(function(a){return a.code==itd.desc})[0]">{{ccs.filter(function(a){return a.code==itd.desc})[0].name}}</template>)</a>
                                </li>
                            </ul>
                        </div>-->
                    </template>
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
                    <div class="row">
                        <div class="col-sm-6"><label>Code</label>
                            <input type="text" v-model="updatedl6code" class="form-control">
                        </div>
                        <div class="col-sm-6"><label>Parent</label>
                            <input type="text" readonly v-model="parent" class="form-control"></div>
                    </div>
                    <br>
                    <label>Sub Control Name</label>
                    <input type="text" v-model="updatedl6Ac" class="form-control">
                    <br>
                    <label>Remarks</label>
                    <textarea v-model="updatedl6remarks" class="form-control"></textarea>
                    <br>
                    <div class="row">
                        <template v-if="this.subs!=1">
                        <div class="col-sm-6">
                                <label>Mark as Main Account</label>
                                <input type="checkbox"  v-model="updatedl6desc"  >
                        </div>
                        </template>
                        <div class="col-sm-6">
                            <label>Show in Dropdown</label>
                            <input type="checkbox"  v-model="updatedl6show"  >
                        </div>
                    </div>
                    <br>
                    <template v-if="updatedl6show==true">
                        <select v-model="cost_center" id="cost_center" name="cost_center" class="form-control input-height select2">
                            <option value="0">Choose Option</option>
                            <option v-for="cc in cost_centers" :value="cc.id">
                                {{cc.name}}
                            </option>
                        </select>
<!--                        <div class="form-group has-search"  v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">
                            <input type="text" class="form-control typeahead" autocomplete="off" v-model="search"  tabindex="1" name="search" placeholder="Search by Unit...">
                            <input type="hidden" v-model="cost_center" name="cost_center" >
                            <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.search && searchedunits.length>0">

                                <li  :class="'fbb fba'+key" @click="unitdatavalue(itd.id)" v-for="(itd,key) in searchedunits">
                                    <a href="javascript:void(0)">{{itd.code}} - {{itd.name}} (<template v-if="ccs.filter(function(a){return a.code==itd.desc})[0]">{{ccs.filter(function(a){return a.code==itd.desc})[0].name}}</template>)</a>
                                </li>
                            </ul>
                        </div>-->
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
                    <div class="row">
                        <div class="col-sm-6"><label>Code</label>
                            <template v-if="childl7Ac==0">
                                <input type="text" v-model="codel7Ac" class="form-control">
                            </template>
                            <template v-else>
                                <input type="text" readonly v-model="childl7Ac" class="form-control">
                            </template>
                        </div>
                        <div class="col-sm-6"><label>Parent</label>
                            <input type="text" readonly v-model="parentl7Ac" class="form-control"></div>
                    </div>

                    <br>
                    <label>Account Name</label>
                    <input type="text" v-model="l7Ac" class="form-control">
                    <br>
                    <label>Remarks</label>
                    <textarea v-model="remarksl7Ac" class="form-control"></textarea>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Mark as Main Account</label>
                            <input type="checkbox"  v-model="subaccount"  >
                        </div>
                        <div class="col-sm-6">
                            <label>Show in Dropdown</label>
                            <input type="checkbox"  v-model="dropdown"  >
                        </div>
                    </div>
                    <br>
                    <template v-if="dropdown==true">
                        <select v-model="cost_center" id="cost_center" name="cost_center" class="form-control input-height select2">
                            <option value="0">Choose Option</option>
                            <option v-for="cc in cost_centers" :value="cc.id">
                                {{cc.name}}
                            </option>
                        </select>
<!--                        <div class="form-group has-search"  v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">
                            <input type="text" class="form-control typeahead" autocomplete="off" v-model="search"  tabindex="1" name="search" placeholder="Search by Unit...">
                            <input type="hidden" v-model="cost_center" name="cost_center" >
                            <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.search && searchedunits.length>0">

                                <li  :class="'fbb fba'+key" @click="unitdatavalue(itd.id)" v-for="(itd,key) in searchedunits">
                                    <a href="javascript:void(0)">{{itd.code}} - {{itd.name}} (<template v-if="ccs.filter(function(a){return a.code==itd.desc})[0]">{{ccs.filter(function(a){return a.code==itd.desc})[0].name}}</template>)</a>
                                </li>
                            </ul>
                        </div>-->
                    </template>
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
                    <div class="row">
                        <div class="col-sm-6"><label>Code</label>
                            <input type="text" v-model="updatedl7code" class="form-control"></div>
                        <div class="col-sm-6"><label>Parent</label>
                            <input type="text" readonly v-model="parent" class="form-control"></div>
                    </div>
                    <br>
                    <label>Sub Account Name</label>
                    <input type="text" v-model="updatedl7Ac" class="form-control">
                    <br>
                    <label>Remarks</label>
                    <textarea v-model="updatedl7remarks" class="form-control"></textarea>
                    <br>
                    <div class="row">
                        <template v-if="this.accs!=1">
                        <div class="col-sm-6">
                                <label>Mark as Main Account</label>
                                <input type="checkbox"  v-model="updatedl7desc"  >
                        </div>
                        </template>
                        <div class="col-sm-6">
                            <label>Show in Dropdown</label>
                            <input type="checkbox"  v-model="updatedl7show"  >
                        </div>
                    </div>
                    <br>
                    <template v-if="updatedl7show==true">
                        <select v-model="cost_center" id="cost_center" name="cost_center" class="form-control input-height select2">
                            <option value="0">Choose Option</option>
                            <option v-for="cc in cost_centers" :value="cc.id">
                                {{cc.name}}
                            </option>
                        </select>
<!--                        <div class="form-group has-search"  v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">
                            <input type="text" class="form-control typeahead" autocomplete="off" v-model="search"  tabindex="1" name="search" placeholder="Search by Unit...">
                            <input type="hidden" v-model="cost_center" name="cost_center" >
                            <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.search && searchedunits.length>0">

                                <li  :class="'fbb fba'+key" @click="unitdatavalue(itd.id)" v-for="(itd,key) in searchedunits">
                                    <a href="javascript:void(0)">{{itd.code}} - {{itd.name}} (<template v-if="ccs.filter(function(a){return a.code==itd.desc})[0]">{{ccs.filter(function(a){return a.code==itd.desc})[0].name}}</template>)</a>
                                </li>
                            </ul>
                        </div>-->
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
                    <div class="row">
                        <div class="col-sm-6"><label>Code</label>
                            <template v-if="childl8Ac==0">
                                <input type="text" v-model="codel8Ac" class="form-control">
                            </template>
                            <template v-else>
                                <input type="text" readonly v-model="childl8Ac" class="form-control">
                            </template>
                        </div>
                        <div class="col-sm-6"><label>Parent</label>
                            <input type="text" readonly v-model="parentl8Ac" class="form-control"></div>
                    </div>

                    <br>
                    <label>Sub Account Name</label>
                    <input type="text" v-model="l8Ac" class="form-control">
                    <br>
                    <label>Remarks</label>
                    <textarea v-model="remarksl8Ac" class="form-control"></textarea>
<!--                        <br>
                        <label>Mark as Main Account</label>
                        <input type="checkbox"  v-model="subaccount"  >-->
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Show in Dropdown</label>
                            <input type="checkbox"  v-model="dropdown"  >
                        </div>
                        <div class="col-sm-6">

                        </div>
                    </div>
                    <br>
                    <template v-if="dropdown==true">
                        <select v-model="cost_center" id="cost_center" name="cost_center" class="form-control input-height select2">
                            <option value="0">Choose Option</option>
                            <option v-for="cc in cost_centers" :value="cc.id">
                                {{cc.name}}
                            </option>
                        </select>
<!--                        <div class="form-group has-search"  v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">
                            <input type="text" class="form-control typeahead" autocomplete="off" v-model="search"  tabindex="1" name="search" placeholder="Search by Unit...">
                            <input type="hidden" v-model="cost_center" name="cost_center" >
                            <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.search && searchedunits.length>0">

                                <li  :class="'fbb fba'+key" @click="unitdatavalue(itd.id)" v-for="(itd,key) in searchedunits">
                                    <a href="javascript:void(0)">{{itd.code}} - {{itd.name}} (<template v-if="ccs.filter(function(a){return a.code==itd.desc})[0]">{{ccs.filter(function(a){return a.code==itd.desc})[0].name}}</template>)</a>
                                </li>
                            </ul>
                        </div>-->
                    </template>
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
                    <div class="row">
                        <div class="col-sm-6"><label>Code</label>
                            <input type="text" v-model="updatedl8code" class="form-control"></div>
                        <div class="col-sm-6"><label>Parent</label>
                            <input type="text" readonly v-model="parent" class="form-control"></div>
                    </div>
                    <br>
                    <label>Sub Account Name</label>
                    <input type="text" v-model="updatedl8Ac" class="form-control">
                    <br>
                    <label>Remarks</label>
                    <textarea v-model="updatedl8remarks" class="form-control"></textarea>
<!--                    <template v-if="this.subaccs!=1">
                        <br>
                        <label>Mark as Main Account</label>

                        <input type="checkbox" v-model="updatedl8desc"  >

                    </template>-->
                    <br>
                    <label>Show in Dropdown</label>
                    <input type="checkbox"  v-model="updatedl8show"  >
                    <br>
                    <template v-if="updatedl8show==true">
                        <select v-model="cost_center" id="cost_center" name="cost_center" class="form-control input-height select2">
                            <option value="0">Choose Option</option>
                            <option v-for="cc in cost_centers" :value="cc.id">
                                {{cc.name}}
                            </option>
                        </select>
<!--                        <div class="form-group has-search"  v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">
                            <input type="text" class="form-control typeahead" autocomplete="off" v-model="search"  tabindex="1" name="search" placeholder="Search by Unit...">
                            <input type="hidden" v-model="cost_center" name="cost_center" >
                            <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.search && searchedunits.length>0">

                                <li  :class="'fbb fba'+key" @click="unitdatavalue(itd.id)" v-for="(itd,key) in searchedunits">
                                    <a href="javascript:void(0)">{{itd.code}} - {{itd.name}} (<template v-if="ccs.filter(function(a){return a.code==itd.desc})[0]">{{ccs.filter(function(a){return a.code==itd.desc})[0].name}}</template>)</a>
                                </li>
                            </ul>
                        </div>-->
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
                                    <a  @click="openEditSubCompany(cs.name,cs.code,c.code);selectedl.l1=cs.code"><i class="fas fa-edit"></i></a>
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
                                <div class="panel-heading">{{n.code}} - {{n.name}} <template v-if="cost_centers.filter(function(a){return a.id==n.cost_center})[0]">({{cost_centers.filter(function(a){return a.id==n.cost_center})[0].name}})</template>
<!--                                    <template v-if="cn.desc!=1">-->
                                        <button v-on:click=toggle(index)>   <b class="caret"></b></button>
<!--                                    </template>-->
                                    <div style="float:right;">
                                    <a @click="parent=''; openEditMainControl(n);"><i class="fas fa-edit"></i></a>
                                    <a  @click="parent=''; deleteMainControl(n.name,n.code);"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div>
                                <div class=" panel-body"  v-if="n.visible==true">
                                    <ul class="list-unstyled" >
                                        <li>
                                            <template v-if="n.desc!=1">
                                            <button type="button" class="btn btn-default" @click="parent=n.code; openSaveControl(n.code,0);">Add Control</button>
                                            </template>
                                            <template v-else>
                                             <button type="button" class="btn btn-default" @click="parent=n.code; openSaveControl(n.code,1);">Add Control</button>
                                            </template>
                                        </li>
                                        <li v-for="(cn,sindex) in controls.filter((a)=>{return a.parent==n.code})">{{cn.code}} - {{cn.name}} <template v-if="cost_centers.filter(function(a){return a.id==cn.cost_center})[0]">({{cost_centers.filter(function(a){return a.id==cn.cost_center})[0].name}})</template>

                                            <template v-if="cn.desc!=3">
                                                <button v-on:click=ttoggle(sindex,n)>  <b class="caret"></b></button>
                                            </template>
                                            <a  @click="parent=n.code; deleteMainControl(cn.name,cn.code);"><i class="fas fa-trash"></i></a>
                                            <a @click="parent=n.code; openEditControl(cn);"><i class="fas fa-edit"></i></a>

                                            <template v-if="cn.desc!=3">
                                            <template v-if="cn.desc!=1">
                                                <button style="float:right; line-height: 0.9;" type="button" class="btn btn-sm btn-default" @click.prevent="parent=cn.code; openSaveSubControl(cn.code,0);">Add Sub Control</button>
                                            </template>
                                            <template v-else>
                                                <button style="float:right; line-height: 0.9;" type="button" class="btn btn-sm btn-default" @click.prevent="parent=cn.code; openSaveSubControl(cn.code,1);">Add Sub Control</button>
                                            </template>
                                            </template>
                                             <!-- <a href="#"  @click.prevent="parent=cn.code;addl6=!addl6">Add Sub Control</a>-->
                                        <ul v-if="controls.filter((a)=>{return a.parent==cn.code}) && cn.vvisible==true">
                                            <li v-for="(cnc,xindex) in controls.filter((a)=>{return a.parent==cn.code})">
                                                {{cnc.code}} - {{cnc.name}} <template v-if="cost_centers.filter(function(a){return a.id==cnc.cost_center})[0]">({{cost_centers.filter(function(a){return a.id==cnc.cost_center})[0].name}})</template>

                                                <template v-if="cnc.desc!=3">
                                                <button v-on:click=tttoggle(xindex,cn)>   <b style="color: black;" class="caret"></b></button>
                                                </template>
                                                <a style="color:black;" @click="parent=cn.code; deleteMainControl(cnc.name,cnc.code);"><i class="fas fa-trash"></i></a>
                                                <a style="color:black;" @click="parent=cn.code; openEditSubControl(cnc);"><i class="fas fa-edit"></i></a>
                                                <template v-if="cnc.desc!=3">
                                                    <template v-if="cnc.desc!=1">
                                                        <button style="float:right; line-height: 0.9;" type="button" class="btn btn-sm btn-default" @click.prevent="parent=cnc.code; openSaveAccount(cnc.code,0);">Add Account</button>
                                                    </template>
                                                    <template v-else>
                                                        <button style="float:right; line-height: 0.9;" type="button" class="btn btn-sm btn-default" @click.prevent="parent=cnc.code; openSaveAccount(cnc.code,1);">Add Account</button>
                                                    </template>
                                                  <!-- <a href="#"  @click.prevent="parent=cnc.code;addl7=!addl7">Add Sub Account</a>-->
                                                </template>
                                                <ul v-if="controls.filter((a)=>{return a.parent==cnc.code}) && cnc.vvvisible==true">
                                                    <li v-for="(cncc,xindex) in controls.filter((a)=>{return a.parent==cnc.code})">{{cncc.code}} - {{cncc.name}} <template v-if="cost_centers.filter(function(a){return a.id==cncc.cost_center})[0]">({{cost_centers.filter(function(a){return a.id==cncc.cost_center})[0].name}})</template>

                                                        <template v-if="cncc.desc!=3">
                                                            <button v-on:click=ttttoggle(xindex,cnc)>   <b style="color: black;" class="caret"></b></button>
                                                        </template>
                                                        <a  @click="parent=cnc.code; deleteMainControl(cncc.name,cncc.code);"><i class="fas fa-trash"></i></a>
                                                        <a @click="parent=cnc.code; openEditAccount(cncc);"><i class="fas fa-edit"></i></a>


                                                        <template v-if="cncc.desc!=3">
                                                            <template v-if="cncc.desc!=1">
                                                                <button style="float:right; line-height: 0.9;" type="button" class="btn btn-sm btn-default" @click.prevent="parent=cncc.code; openSaveSubAccount(cncc.code,0);">Add Sub Account</button>
                                                            </template>
                                                            <template v-else>
                                                                <button style="float:right; line-height: 0.9;" type="button" class="btn btn-sm btn-default" @click.prevent="parent=cncc.code; openSaveSubAccount(cncc.code,1);">Add Sub Account</button>
                                                            </template>
                                                        </template>
                                                    <ul v-if="controls.filter((a)=>{return a.parent==cncc.code}) && cncc.vvvvisible==true">
                                                        <li v-for="cnccc in controls.filter((a)=>{return a.parent==cncc.code})">{{cnccc.code}} - {{cnccc.name}} <template v-if="cost_centers.filter(function(a){return a.id==cnccc.cost_center})[0]">({{cost_centers.filter(function(a){return a.id==cnccc.cost_center})[0].name}})</template>

                                                            <a  @click="parent=cncc.code; deleteMainControl(cnccc.name,cnccc.code);"><i class="fas fa-trash"></i></a>
                                                            <a @click="parent=cncc.code; openEditSubAccount(cnccc);"><i class="fas fa-edit"></i></a> </li>

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
<style scoped>
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
.fbb{
    padding: 0!important;
    border: none!important;
    border-bottom: 1px solid #e7e7e7!important;
}
.fbb a{
    opacity: 1;
    background: #fdf7f7;
    text-decoration: none !important;
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
    padding:0!important;

}
</style>
<script>
import Datepicker from 'vuejs-datepicker';
import modal from "./modal";

export default {
    name: "COAnew",
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
            codel6Ac:'',
            codel7Ac:'',
            codel8Ac:'',
            l7Ac:'',
            l8Ac:'',
            l5Ac:'',
            codel5Ac:'',
            codel4Ac:'',
            remarksl4Ac:'',
            remarksl5Ac:'',
            remarksl6Ac:'',
            remarksl7Ac:'',
            remarksl8Ac:'',
            l4Ac:'',
            l3Ac:'',

            updatedl4Ac:'',
            updatedl4code:'',
            updatedl4desc:false,
            updatedl4show:false,
            updatedl4remarks:'',

            updatedl5Ac:'',
            updatedl5code:'',
            updatedl5desc:false,
            updatedl5show:false,
            parentl5Ac:'',
            childl5Ac:'',
            updatedl5remarks:'',

            updatedl6Ac:'',
            updatedl6code:'',
            updatedl6desc:false,
            updatedl6show:false,
            parentl6Ac:'',
            childl6Ac:'',
            updatedl6remarks:'',

            updatedl7Ac:'',
            updatedl7code:'',
            updatedl7desc:false,
            updatedl7show:false,
            parentl7Ac:'',
            childl7Ac:'',
            updatedl7remarks:'',

            updatedl8Ac:'',
            updatedl8code:'',
            updatedl8desc:false,
            updatedl8show:false,
            parentl8Ac:'',
            childl8Ac:'',
            updatedl8remarks:'',

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
            updatedsubparent:'',
            organization:'',
            visible: true,
            vvisible: true,
            vvvisible: true,
            vvvvisible: true,
            subaccount:false,
            dropdown:false,
            mains:'',
            mids:'',
            subs:'',
            accs:'',
            subaccs:'',
            searchedunits:[],
            search:'',
            cost_center:0,
            unitalreadySearched:false,
            fkey:-1,
            ffkey:0,
            ccs:[],
            ide:'',
        }
    },
    computed: {},
    methods: {
        fup(){

        },fdown(){
            console.log(1)

        },udf(event){

            if(event==0){
                if(this.fkey!=this.searchedunits.length){

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
        unitsdata(){
            this.$http.post('/search/coa/unitsdatalike',{searchid:this.search}).then(result=>{
                let data =result.data;
                console.log(result.data);
                data.filter((a)=>{a.search=a.name})

                if(data){

                    this.searchedunits=data;

                }
            });
        },
        unitdatavalue(val,m){
            this.searchedunits=[];
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/coa/unitdata?MOC='+r,{theid:val}).then(result=>{
                let data =result.data;
                if(data){
                    this.unitalreadySearched=true;
                    this.search = data.code + ' ' + '-' + ' ' + data.name;
                    this.cost_center = data.code;

                }
            });
        },
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
            this.$http.post('coa-new/save/level/1', {'name': this.company}).then((r) => {
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
            this.$http.post('coa-new/update/level/1', {'name': this.updatedcompany, 'code':this.updatedcode}).then((r) => {
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
                this.$http.post('coa-new/delete/level/1', {'name': name, 'code':code}).then((r) => {
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
        openEditSubCompany: function (name,code,parent) {
            this.editSubCompany = true;
            this.updatedsubcompany=name;
            this.updatedsubparent=parent;
            this.updatedsubcode=code;
        } ,
        saveSubCompany: function () {
            this.$http.post('coa-new/save/level/2', {'name': this.scompany,'level':this.selectedl.l1}).then((r) => {
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
            this.$http.post('coa-new/update/level/2', {'name': this.updatedsubcompany,'code':this.updatedsubcode,'parent':this.updatedsubparent}).then((r) => {
                if (r.status == 200) {
                    this.editSubCompany = false;
                    this.updatedsubcompany='';
                    this.updatedsubcode='';
                    this.updatedsubparent='';
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
                this.$http.post('coa-new/delete/level/2', {'name': name, 'code':code}).then((r) => {
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
            this.$http.post('coa-new/save/level/3', {'name': this.l3Ac,'level':this.selectedl.l2}).then((r) => {
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
        openEditMainControl: function (n) {

            this.updatedl4Ac=n.name;
            this.updatedl4code=n.code;
            this.updatedl4remarks=n.remarks;
            this.search=n.cost_center;
            this.cost_center=n.cost_center;
            this.unitalreadySearched=true;
            this.ide=n.id;
            if(n.desc==0){
                this.updatedl4desc=false;
            }else{
                this.updatedl4desc=true;
            }
            if(n.show==0){
                this.updatedl4show=false;
            }else{
                this.updatedl4show=true;
            }

            this.$http.post('coa-new/checkmaincontrol', {'code':n.code}).then((r) => {
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
            this.$http.post('coa-new/saveAccount', {'cost_center':this.cost_center,'code': this.codel4Ac,'name': this.l4Ac,'parent':this.parent,'category':this.category,'desc':0, 'subaccount':this.subaccount, 'dropdown':this.dropdown,'remarks':this.remarksl4Ac}).then((r) => {
                if (r.status == 200) {
                    this.addl4 = false;


                    this.controls =  this.controls.concat(r.data);

                    this.l4Ac='';
                    this.codel4Ac='';
                    this.remarksl4Ac='';
                    this.cost_center=0;
                    this.search='';
                    this.subaccount=false;
                    this.dropdown=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            }).catch(error=> {
                this.$snotify.error('Oops! Something went wrong. Try saving again.');
            });
        },
        savel4more:function(){
            this.$http.post('coa-new/saveAccount', {'cost_center':this.cost_center,'code': this.codel4Ac,'name': this.l4Ac,'parent':this.parent,'category':this.category,'desc':0, 'subaccount':this.subaccount, 'dropdown':this.dropdown,'remarks':this.remarksl4Ac}).then((r) => {
                if (r.status == 200) {

                    this.controls =  this.controls.concat(r.data);

                    this.l4Ac='';
                    this.codel4Ac='';
                    this.remarksl4Ac='';
                    this.cost_center=0;
                    this.search='';
                    this.subaccount=false;
                    this.dropdown=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            }).catch(error=> {
                this.$snotify.error('Oops! Something went wrong. Try saving again.');
            });
        },
        updatel4:function(){
            this.$http.post('coa-new/updateAccount', {'idd':this.ide,'cost_center':this.cost_center,'code': this.updatedl4code,'name': this.updatedl4Ac,'parent':this.parent,'remarks':this.updatedl4remarks,'category':this.category,'desc':this.updatedl4desc==false?0:1,'show':this.updatedl4show==false?0:1}).then((r) => {
                if (r.status == 200) {
                    this.editl4 = false;

                    this.controls=r.data;
                    this.ide='';
                    this.updatedl4code='';
                    this.updatedl4Ac='';
                    this.updatedl4remarks='';
                    this.cost_center=0;
                    this.search='';
                    this.updatedl4desc=false;
                    this.updatedl4show=false;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            }).catch(error=> {
                this.$snotify.error('Oops! Something went wrong. Try saving again.');
            });
        },

        deleteMainControl: function (name,code) {

    this.$http.post('coa-new/checkmaincontrol', {'code':code}).then((r) => {
        if (r.status == 200 && r.data==1) {
            this.$snotify.error('This Level of Account cannot be deleted.');
        }
        else if(r.data!=1){
            if(confirm("Are you sure ?")){
                this.$http.post('coa-new/deleteAccount', {'name': name, 'code':code,'parent':this.parent,'category':this.category,'desc':0}).then((r) => {
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
        openSaveControl: function (parent,child) {
            this.parentl5Ac=parent;
            if(child==1){
                this.$http.post('coa-new/checkchildren', {'parent':parent}).then((r) => {
                    if (r.status == 200) {
                        this.childl5Ac=parent+'-'+r.data;
                    }
                    else{
                        this.$snotify.error('Something went wrong with request.');
                    }
                })
            }
            else{
                this.childl5Ac=0;
            }
            this.addl5 = true;
        } ,
        openSaveSubControl: function (parent,child) {
            this.parentl6Ac=parent;
            if(child==1){
                this.$http.post('coa-new/checkchildren', {'parent':parent}).then((r) => {
                    if (r.status == 200) {
                        this.childl6Ac=parent+'-'+r.data;
                    }
                    else{
                        this.$snotify.error('Something went wrong with request.');
                    }
                })
            }
            else{
                this.childl6Ac=0;
            }
            this.addl6 = true;
        },
        openSaveAccount: function (parent,child) {
            this.parentl7Ac=parent;
            if(child==1){
                this.$http.post('coa-new/checkchildren', {'parent':parent}).then((r) => {
                    if (r.status == 200) {
                        this.childl7Ac=parent+'-'+r.data;
                    }
                    else{
                        this.$snotify.error('Something went wrong with request.');
                    }
                })
            }
            else{
                this.childl7Ac=0;
            }
            this.addl7 = true;
        },
        openSaveSubAccount: function (parent,child) {
            this.parentl8Ac=parent;
            if(child==1){
                this.$http.post('coa-new/checkchildren', {'parent':parent}).then((r) => {
                    if (r.status == 200) {
                        this.childl8Ac=parent+'-'+r.data;
                    }
                    else{
                        this.$snotify.error('Something went wrong with request.');
                    }
                })
            }
            else{
                this.childl8Ac=0;
            }
            this.addl8 = true;
        },
        openEditControl: function (n) {


            this.unitalreadySearched=true;
            this.ide=n.id;

            this.$http.post('coa-new/checkcontrol', {'idd':n.id}).then((r) => {
                console.log(r.data[0].code)
                let mamm =r.data[0];
                if (r.status == 200) {

                    this.$http.post('coa-new/checkmaincontrol', {'code':mamm.code}).then((c) => {
                        if (c.status == 200) {
                            this.mids=c.data;
                        }
                        else{
                            this.$snotify.error('Something went wrong with request.');
                        }
                    })

                    this.updatedl5Ac=mamm.name;
                    this.updatedl5code=mamm.code;
                    this.updatedl5remarks=mamm.remarks;
                    this.search=mamm.cost_center;
                    this.cost_center=mamm.cost_center;


                    if(mamm.desc==0){
                        this.updatedl5desc=false;
                    }else{
                        this.updatedl5desc=true;
                    }
                    if(mamm.show==0){
                        this.updatedl5show=false;
                    }else{
                        this.updatedl5show=true;
                    }
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })

            this.editl5 = true;
        } ,
        savel5:function(){
            this.$http.post('coa-new/saveAccount', {'cost_center':this.cost_center,'name': this.l5Ac,'code': this.childl5Ac==0?this.codel5Ac:this.childl5Ac,'parent':this.parent,'remarks':this.remarksl5Ac,'category':this.category,'desc':this.childl5Ac==0?0:3, 'subaccount':this.subaccount, 'dropdown':this.dropdown}).then((r) => {
                if (r.status == 200) {
                    this.addl5 = false;
                    this.controls =  this.controls.concat(r.data);
                    this.l5Ac=''
                    this.codel5Ac=''
                    this.remarksl5Ac=''
                    this.parentl5Ac=''
                    this.childl5Ac=''
                    this.cost_center=''
                    this.search=''
                    this.subaccount=false;
                    this.dropdown=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            }).catch(error=> {
                this.$snotify.error('Oops! Something went wrong. Try saving again.');
            });
        },
        savel5more:function(){
            this.$http.post('coa-new/saveAccount', {'cost_center':this.cost_center,'name': this.l5Ac,'code': this.childl5Ac==0?this.codel5Ac:this.childl5Ac,'parent':this.parent,'remarks':this.remarksl5Ac,'category':this.category,'desc':this.childl5Ac==0?0:3, 'subaccount':this.subaccount, 'dropdown':this.dropdown}).then((r) => {
                if (r.status == 200) {

                    this.controls =  this.controls.concat(r.data);
                    this.l5Ac=''
                    this.codel5Ac=''
                    this.remarksl5Ac=''
                 //   this.parentl5Ac=''
                    this.childl5Ac=''
                    this.cost_center=''
                    this.search=''
                    this.subaccount=false;
                    this.dropdown=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            }).catch(error=> {
                this.$snotify.error('Oops! Something went wrong. Try saving again.');
            });
        },  shuffleArray: function (arr) {
            var newArr = arr.slice();

            for (var i = newArr.length - 1; i > 0; i--) {
                var j = Math.floor(Math.random() * (i + 1));
                var temp = newArr[i];
                newArr[i] = newArr[j];
                newArr[j] = temp;
            }

            return newArr;
        },

        updatel5:function(){
            this.$http.post('coa-new/updateAccount', {'idd':this.ide,'cost_center':this.cost_center,'code': this.updatedl5code,'name': this.updatedl5Ac,'remarks':this.updatedl5remarks,'parent':this.parent,'category':this.category,'desc':this.updatedl5desc==false?0:1,'show':this.updatedl5show==false?0:1}).then((r) => {
                if (r.status == 200) {
                    this.editl5 = false;


                    this.ide='';
                    this.updatedl5code='';
                    this.updatedl5Ac='';
                    this.updatedl5remarks='';
                    this.cost_center=0;
                    this.search='';
                    this.updatedl5desc=false;
                    this.updatedl5show=false;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            }).catch(error=> {
                this.$snotify.error('Oops! Something went wrong. Try saving again.');
            });
        },
       /* openEditSubControl: function (n) {
            this.updatedl6Ac=n.name;
            this.updatedl6code=n.code;
            this.updatedl6remarks=n.remarks;
            this.search=n.cost_center;
            this.cost_center=n.cost_center;
            this.unitalreadySearched=true;
            if(n.desc==0){
                this.updatedl6desc=false;
            }else{
                this.updatedl6desc=true;
            }
            if(n.show==0){
                this.updatedl6show=false;
            }else{
                this.updatedl6show=true;
            }

            this.$http.post('coa-new/checkmaincontrol', {'code':n.code}).then((r) => {
                if (r.status == 200) {
                    this.subs=r.data;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
            this.editl6 = true;
        } ,*/
        openEditSubControl: function (n) {

            this.unitalreadySearched=true;
            this.ide=n.id;

            this.$http.post('coa-new/checkcontrol', {'idd':n.id}).then((r) => {

                let mamm =r.data[0];
                if (r.status == 200) {

                    this.$http.post('coa-new/checkmaincontrol', {'code':mamm.code}).then((c) => {
                        if (c.status == 200) {
                            this.subs=c.data;
                        }
                        else{
                            this.$snotify.error('Something went wrong with request.');
                        }
                    })

                    this.updatedl6Ac=mamm.name;
                    this.updatedl6code=mamm.code;
                    this.updatedl6remarks=mamm.remarks;
                    this.search=mamm.cost_center;
                    this.cost_center=mamm.cost_center;

                    if(mamm.desc==0){
                        this.updatedl6desc=false;
                    }else{
                        this.updatedl6desc=true;
                    }
                    if(mamm.show==0){
                        this.updatedl6show=false;
                    }else{
                        this.updatedl6show=true;
                    }
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })

            this.editl6 = true;
        } ,
        savel6:function(){
            this.$http.post('coa-new/saveAccount', {'cost_center':this.cost_center,'code': this.childl6Ac==0?this.codel6Ac:this.childl6Ac,'name': this.l6Ac,'remarks':this.remarksl6Ac,'parent':this.parent,'category':this.category,'desc':this.childl6Ac==0?0:3, 'subaccount':this.subaccount,'dropdown':this.dropdown}).then((r) => {
                if (r.status == 200) {
                    this.addl6 = false;
                    this.controls =  this.controls.concat(r.data);
                    this.l6Ac='';
                    this.codel6Ac=''
                    this.parentl6Ac=''
                    this.childl6Ac=''
                    this.remarksl6Ac=''
                    this.cost_center=''
                    this.search=''
                    this.subaccount=false;
                    this.dropdown=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            }).catch(error=> {
                this.$snotify.error('Oops! Something went wrong. Try saving again.');
            });
        },
        savel6more:function(){
            this.$http.post('coa-new/saveAccount', {'cost_center':this.cost_center,'code': this.childl6Ac==0?this.codel6Ac:this.childl6Ac,'name': this.l6Ac,'remarks':this.remarksl6Ac,'parent':this.parent,'category':this.category,'desc':this.childl6Ac==0?0:3, 'subaccount':this.subaccount,'dropdown':this.dropdown}).then((r) => {
                if (r.status == 200) {

                    this.controls =  this.controls.concat(r.data);
                    this.l6Ac='';
                    this.codel6Ac=''
                   // this.parentl6Ac=''
                    this.childl6Ac=''
                    this.remarksl6Ac=''
                    this.cost_center=''
                    this.search=''
                    this.subaccount=false;
                    this.dropdown=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            }).catch(error=> {
                this.$snotify.error('Oops! Something went wrong. Try saving again.');
            });
        },
        updatel6:function(){
            this.$http.post('coa-new/updateAccount', {'idd':this.ide,'cost_center':this.cost_center,'code': this.updatedl6code,'name': this.updatedl6Ac,'parent':this.parent,'remarks':this.updatedl6remarks,'category':this.category,'desc':this.updatedl6desc==false?0:1,'show':this.updatedl6show==false?0:1}).then((r) => {
                if (r.status == 200) {
                    this.editl6 = false;
                   /* this.controls=r.data;*/
                    this.ide='';
                    this.updatedl6code='';
                    this.updatedl6Ac='';
                    this.updatedl6remarks='';
                    this.cost_center=0;
                    this.search='';
                    this.updatedl6desc=false;
                    this.updatedl6show=false;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            }).catch(error=> {
                this.$snotify.error('Oops! Something went wrong. Try saving again.');
            });
        },
        openEditAccount: function (n) {

            this.unitalreadySearched=true;
            this.ide=n.id;

            this.$http.post('coa-new/checkcontrol', {'idd':n.id}).then((r) => {

                let mamm =r.data[0];
                if (r.status == 200) {

                    this.$http.post('coa-new/checkmaincontrol', {'code':mamm.code}).then((c) => {
                        if (c.status == 200) {
                            this.accs=c.data;
                        }
                        else{
                            this.$snotify.error('Something went wrong with request.');
                        }
                    })

                    this.updatedl7Ac=mamm.name;
                    this.updatedl7code=mamm.code;
                    this.updatedl7remarks=mamm.remarks;
                    this.search=mamm.cost_center;
                    this.cost_center=mamm.cost_center;

                    if(mamm.desc==0){
                        this.updatedl7desc=false;
                    }else{
                        this.updatedl7desc=true;
                    }
                    if(mamm.show==0){
                        this.updatedl7show=false;
                    }else{
                        this.updatedl7show=true;
                    }
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })

            this.editl7 = true;
        } ,
        openEditSubAccount: function (n) {

            this.unitalreadySearched=true;
            this.ide=n.id;

            this.$http.post('coa-new/checkcontrol', {'idd':n.id}).then((r) => {

                let mamm =r.data[0];
                if (r.status == 200) {

                    this.$http.post('coa-new/checkmaincontrol', {'code':mamm.code}).then((c) => {
                        if (c.status == 200) {
                            this.subaccs=c.data;
                        }
                        else{
                            this.$snotify.error('Something went wrong with request.');
                        }
                    })

                    this.updatedl8Ac=mamm.name;
                    this.updatedl8code=mamm.code;
                    this.updatedl8remarks=mamm.remarks;
                    this.search=mamm.cost_center;
                    this.cost_center=mamm.cost_center;

                    if(mamm.desc==0){
                        this.updatedl8desc=false;
                    }else{
                        this.updatedl8desc=true;
                    }
                    if(mamm.show==0){
                        this.updatedl8show=false;
                    }else{
                        this.updatedl8show=true;
                    }
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })

            this.editl8 = true;
        } ,
        savel7:function(){
            this.$http.post('coa-new/saveAccount', {'cost_center':this.cost_center,'code': this.childl7Ac==0?this.codel7Ac:this.childl7Ac,'remarks':this.remarksl7Ac,'name': this.l7Ac,'parent':this.parent,'category':this.category,'desc':this.childl7Ac==0?0:3, 'subaccount':this.subaccount, 'dropdown':this.dropdown}).then((r) => {
                if (r.status == 200) {
                    this.addl7 = false;
                    this.controls =  this.controls.concat(r.data);
                    this.l7Ac=''
                    this.codel7Ac=''
                    this.parentl7Ac=''
                    this.childl7Ac=''
                    this.remarksl7Ac=''
                    this.cost_center=''
                    this.search=''
                    this.subaccount=false;
                    this.dropdown=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            }).catch(error=> {
                this.$snotify.error('Oops! Something went wrong. Try saving again.');
            });
        },
        savel7more:function(){
            this.$http.post('coa-new/saveAccount', {'cost_center':this.cost_center,'code': this.childl7Ac==0?this.codel7Ac:this.childl7Ac,'remarks':this.remarksl7Ac,'name': this.l7Ac,'parent':this.parent,'category':this.category,'desc':this.childl7Ac==0?0:3, 'subaccount':this.subaccount, 'dropdown':this.dropdown}).then((r) => {
                if (r.status == 200) {

                    this.controls =  this.controls.concat(r.data);
                    this.l7Ac=''
                    this.codel7Ac=''
                  //  this.parentl7Ac=''
                    this.childl7Ac=''
                    this.remarksl7Ac=''
                    this.cost_center=''
                    this.search=''
                    this.subaccount=false;
                    this.dropdown=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            }).catch(error=> {
                this.$snotify.error('Oops! Something went wrong. Try saving again.');
            });
        },
        updatel7:function(){
            this.$http.post('coa-new/updateAccount', {'idd':this.ide,'cost_center':this.cost_center,'code': this.updatedl7code,'name': this.updatedl7Ac,'remarks':this.updatedl7remarks,'parent':this.parent,'category':this.category,'desc':this.updatedl7desc==false?0:1,'show':this.updatedl7show==false?0:1}).then((r) => {
                if (r.status == 200) {
                    this.editl7 = false;
                    this.ide='';
                    this.updatedl7code='';
                    this.updatedl7Ac='';
                    this.updatedl7remarks='';
                    this.cost_center=0;
                    this.search='';
                    this.updatedl7desc=false;
                    this.updatedl7show=false;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            }).catch(error=> {
                this.$snotify.error('Oops! Something went wrong. Try saving again.');
            });
        },

        savel8:function(){
            this.$http.post('coa-new/saveAccount', {'cost_center':this.cost_center,'code': this.childl8Ac==0?this.codel8Ac:this.childl8Ac,'remarks':this.remarksl8Ac,'name': this.l8Ac,'parent':this.parent,'category':this.category,'desc':this.childl8Ac==0?0:3, 'subaccount':this.subaccount,'dropdown':this.dropdown}).then((r) => {
                if (r.status == 200) {
                    this.addl8 = false;
                    this.controls =  this.controls.concat(r.data);
                    this.l8Ac=''
                    this.codel8Ac=''
                    this.childl8Ac=''
                    this.remarksl8Ac=''
                    this.cost_center=''
                    this.search=''
                    this.subaccount=false;
                    this.dropdown=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            }).catch(error=> {
                this.$snotify.error('Oops! Something went wrong. Try saving again.');
            });
        },
        savel8more:function(){
            this.$http.post('coa-new/saveAccount', {'cost_center':this.cost_center,'code': this.childl8Ac==0?this.codel8Ac:this.childl8Ac,'remarks':this.remarksl8Ac,'name': this.l8Ac,'parent':this.parent,'category':this.category,'desc':this.childl8Ac==0?0:3, 'subaccount':this.subaccount,'dropdown':this.dropdown}).then((r) => {
                if (r.status == 200) {

                    this.controls =  this.controls.concat(r.data);
                    this.l8Ac=''
                    this.codel8Ac=''
                    this.childl8Ac=''
                    this.remarksl8Ac=''
                    this.cost_center=''
                    this.search=''
                    this.subaccount=false;
                    this.dropdown=false;
                    // this.selectedl.l2=0;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            }).catch(error=> {
                this.$snotify.error('Oops! Something went wrong. Try saving again.');
            });
        },
        updatel8:function(){
            this.$http.post('coa-new/updateAccount', {'idd':this.ide,'cost_center':this.cost_center,'code': this.updatedl8code,'name': this.updatedl8Ac,'remarks':this.updatedl8remarks,'parent':this.parent,'category':this.category,'desc':this.updatedl8desc==false?0:1,'show':this.updatedl8show==false?0:1}).then((r) => {
                if (r.status == 200) {
                    this.editl8 = false;
                    this.ide='';
                    this.updatedl8code='';
                    this.updatedl8Ac='';
                    this.cost_center=0;
                    this.search='';
                    this.updatedl8desc=false;
                    this.updatedl8remarks='';
                    this.updatedl8show=false;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            }).catch(error=> {
                this.$snotify.error('Oops! Something went wrong. Try saving again.');
            });
        },

        loadl3:function(){

            this.$http.get('coa-new/loadCategory').then((r) => {
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
            this.$http.get('coa-new/loadCompany').then((r) => {
                if (r.status == 200) {
                    this.organization=r.data[0];
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },
        loadunits:function(){
            this.$http.get('coa-new/loadUnits').then((r) => {
                if (r.status == 200) {
                    this.ccs=r.data.ccs;
                    this.cost_centers=r.data.cost_centers;
                }
                else{
                    this.$snotify.error('Something went wrong with request.');
                }
            })
        },
        loadLevel12:function(){
            this.$http.get('coa-new/get/level/1,2').then((r) => {
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
            this.$http.get('coa-new/loadAccounts?cat='+this.category).then((r) => {
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
            this.$http.get('coa-new/default/l/'+this.selectedl.l2).then((r) => {
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
        search:function(){
            if(this.search && this.search.length==0){
                this.unitalreadySearched=false;
            }
            if(this.search && this.search.length>2 && !this.unitalreadySearched){
                this.unitsdata();
            }
        },
    },
    mounted() {
    this.loadLevel12();
    this.loadl3();
    this.loadcompany();
    this.loadunits();

    }
}
</script>

