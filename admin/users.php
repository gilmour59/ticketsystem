<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Users</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../datatables/datatables.min.css">
    </head>
    <body>
        <div class="container">     
            <div class="row my-3">
                <div class="col-md-8">
                    <h2>Users</h2>
                </div>                                      
                <div class="col-md-4">                    
                    <button type="button" class="float-right btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                        Add User
                    </button>
                </div>      
            </div>
            <!-- Modal -->
            <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add User</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="addUserForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" value="">
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" class="form-control">
                                        <option value="normal">Normal</option>
                                        <option value="admin">Admin</option>
                                    </select>                                    
                                </div>
                                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" value="">
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                    <label>Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control" value="">
                                    <span class="help-block"></span>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" form="addUserForm" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <table id="userTable" class="table table-striped table-sm table-hover">
                <thead>
                    <th width="10%">Division</th>
                    <th width="10%">Username</th>
                    <th width="5%">Role</th>
                    <th width="10%">Created At</th>
                    <th width="5%"></th>
                </thead>            
            </table>
        </div>
        <script src="../js/jquery-3.4.1.min.js"></script>
        <script src="../js/popper.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../datatables/datatables.min.js"></script>
        <script src="../js/users.js"></script>
    </body>
</html>