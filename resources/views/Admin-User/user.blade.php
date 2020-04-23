@extends("layouts.admin-master")

@section("title","Admin|User")


@section("content")
 <!-- template form div -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header text-uppercase">
                            <h2>
                                User
                            </h2>
                        </div>
                        <div class="body">
                                <button class="btn bg-cyan waves-effect m-b-15" type="button" data-toggle="collapse" data-target="#open" aria-expanded="false" aria-controls="collapseExample" id="form-open-btn">
                                        Add User
                                       </button>
                            <div class="collapse" id="open">
                                <div class="w-100">
                                    <form id="form_validation" method="POST">
                                <div class="col-sm-6">
                                    <select class="form-control show-tick" id="agent-type">
                                        <option value="">-- Please select User Type--</option>
                                        <option value="1">Supper-Admin</option>
                                        <option value="2">Admin-Editor</option>
                                        <option value="3">Vehicle-Editor</option>
                                        <option value="3">Vehicle-Agent</option>
                                        <option value="4">Hotel-Editor</option>
                                        <option value="4">Hotel-Agent</option>
                                   
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <select class="form-control show-tick" id="agent-name" name="agent_name">
                                            
                                    </select>
                                </div>
                               <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Username" name="name" id="name"/>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="email" class="form-control" placeholder="User-Email " name="email" id="email" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="password" class="form-control" placeholder="Password " name="password" id="password" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="password" class="form-control" placeholder="Confirm-Password " name="password_confirmation" id="password_confirmation" />
                                            <input type="hidden" name="id" id="id" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-float col-sm-12">
                                        <div class="form-line" id="role">
                                            
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
                               User Name
                            </h2>
                            
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>User Name</th>
                                            <th>User Email</th>
                                            <th>User Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>User Name</th>
                                            <th>User Email</th>
                                            <th>User Role</th>
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
<script type="text/javascript" src="{{url('adminjs/user.js')}}"></script>
@endsection