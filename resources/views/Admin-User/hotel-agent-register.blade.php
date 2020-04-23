@extends("layouts.admin-master")

@section("title","Admin|Hotel-Agent-Register")


@section("content")
 <!-- template form div -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header text-uppercase">
                            <h2>
                                Hotel-Agent-Register
                            </h2>
                        </div>
                        <div class="body">
                            <button class="btn bg-cyan waves-effect m-b-15" type="button" data-toggle="collapse" data-target="#open" aria-expanded="false" aria-controls="collapseExample" id="form-open-btn">
                             Add Hotel-Agent-Register
                            </button>
                            <div class="collapse" id="open">
                              <div class="w-100">
                              <form id="form_validation">
                               <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Hotel Owner Name" name="hotelowner" id="hotelowner"/>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="email" class="form-control" placeholder="Hotel Owner Email" name="hotelowneremail" id="hotelowneremail"/>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Hotel Owner Contact" name="hotelownercontact" id="hotelownercontact"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Hotel Name" name="hotelname" id="hotelname"/>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="email" class="form-control" placeholder="Hotel Email" name="hotelemail" id="hotelemail"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Hotel Contact-1" name="hotelcontact1" id="hotelcontact1"/>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Hotel Contact-2" name="hotelcontact2" id="hotelcontact2"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Hotel License" name="hoteltradelicense" id="hoteltradelicense"/>
                                        </div>
                                    </div>
                                </div>
                                
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Street Address" name="streetaddress" id="streetaddress"/>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="City" name="city" id="city"/>
                                        </div>
                                    </div>
                                </div>

                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                             <input type="text" class="form-control" placeholder="State / Province" name="state" id="state"/>
                                           
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Post Code" name="postcode" id="postcode"/>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                             <input type="text" class="form-control" placeholder="Country" name="country" id="country"/>
                                         <input type="hidden" name="id" id="id">
                                        </div>
                                    </div>
                                </div>
                                        
                                        <p id="status-msg"></p>
                                        <button class="btn btn-primary waves-effect" id="action-btn" type="submit">Add</button>
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
                              Hotel-Agent-Register
                            </h2>
                            <br>
                            <div class="form-line" style="width: 50%">
                            <input type="text" class="form-control" placeholder="Search by Name/email/contact/owner/license" name="search_key" id="search_key">
                            </div>
                        </div>
                        <div class="body">

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Hotel Name</th>
                                            <th>Hotel Detail</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Hotel Name</th>
                                            <th>Hotel Detail</th>
                                            <th>Action</th>
                                           
                                        </tr>
                                    </tfoot>
                                    <tbody id="table-data">
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

          <!-- end of data show table -->

        
<script type="text/javascript" src="{{url('adminjs/hotel-agent-register.js')}}"></script>
@endsection
