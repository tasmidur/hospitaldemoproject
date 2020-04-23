@extends('layouts.admin-master')
@section('content')
<style>
  select {
     -webkit-appearance: none;
     -moz-appearance: none;
     appearance: none;       /* Remove default arrow */
     background-image: url(...);   /* Add custom arrow */
  }
  </style>
   <!-- template form div -->
   <div class="row clearfix">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="card">
                  <div class="header text-uppercase">
                    <h2>
                        @auth
                        {{auth()->user()->name}}
                        @endauth
                    </h2>
                      
                  </div>
                  <div class="body">
                      <div class="collapse" id="open">
                        <div class="w-100">
                        <form id="actionform">
                             
                           <div class="col-sm-6">
                              <div class="form-group">
                                  <div class="form-line">
                                    <label>Hotel Room Category Wise Service Charge</label>
                                    <input type="text" class="form-control required" tabindex="1" 
                                    required="" name="service_charge" id="service_charge">
                                </div>
                              </div>
                          </div>
                         
                         

                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="alert alert-info" id="msg">
                                    <span id="msa_data"></span>
                                </div>
                            </div>
                        </div>
                        
                       

                            <input type="hidden" name="user_id" id="user_id" />
                            <input type="hidden" name="action" id="action"/>
                            <input type="hidden" name="op" id="op"/>
                            <button type="submit" class="btn btn-success btn-sm" id="operation" name="operation">Save</button>
                            <button type="button" class="btn btn-danger btn-sm" id="close" name="close">Close</button>
                        </form>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    <!-- end of form div -->
  
    <!-- data show table -->
      <div class="row clearfix">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="card">
                  <div class="header text-uppercase">
                    <h2>
                        @auth
                        {{auth()->user()->name}}
                        @endauth
                       </h2>
                      {{-- <br>
                      <div class="form-line" style="width: 50%">
                      <input type="text" class="form-control" placeholder="Search by Name/email/contact/owner/license" name="search_key" id="search_key">
                      </div> --}}
                  </div>
                  <div class="body">
                      <div class="table-responsive">
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                  <th class="text-center">Hotel Name</th>
                                  <th class="text-center">Room Category Name</th>
                                  <th class="text-center">Room Category Cost</th>
                                  <th class="text-center">Service Charge</th>
                                  <th class="text-center">Action</th>
                              </tr>
                            </thead>
                              <tbody id="table-data">
                              </tbody>
                             
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
<script src="{{url('adminjs/servicechargeadd.js')}}"></script> 
@endsection