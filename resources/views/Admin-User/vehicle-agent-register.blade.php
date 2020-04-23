@extends("layouts.admin-master")

@section("title","Admin|Vehicle-Agent-Register")


@section("content")
 <!-- template form div -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header text-uppercase">
                            <h2>
                                Vehicle-Agent-Register
                            </h2>
                        </div>
                        <div class="body">
                            <button class="btn bg-cyan waves-effect m-b-15" type="button" data-toggle="collapse" data-target="#open" aria-expanded="false" aria-controls="collapseExample" id="form-open-btn">
                             Add Vehicle-Agent-Register
                            </button>
                            <div class="collapse" id="open">
                              <div class="w-100">
                              <form id="form_validation">
                               <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Vehicle Agency" name="vehicleagency_name" id="vehicleagency_name"/>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Email" name="email" id="email"/>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Contact" name="contact" id="contact"/>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder=" Contact-1" name="contact1" id="contact1"/>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Trade License" name="tradelicense" id="tradelicense"/>
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
                              Vehicle-Agent-Register
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Vehicle Agency Name</th>
                                            <th>Vehicle Agency Detail</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Vehicle Agency Name</th>
                                            <th>Vehicle Agency Detail</th>
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
<script type="text/javascript" src="{{url('adminjs/vehicle-agent-register.js')}}"></script>
@endsection

