<a class="btn btn-success" href="{!! URL::route('users.show', array('users' => $user->id)) !!}"><i class="fa fa-file-text"></i> Show</a>
<a class="btn btn-info" href="{!! URL::route('users.edit', array('users' => $user->id)) !!}"><i class="fa fa-pencil-square-o"></i> Edit</a>
<a class="btn btn-default" href="#reset_user_{!! $user->id !!}" data-toggle="modal" data-target="#reset_user_{!! $user->id !!}"><i class="fa fa-lock"></i> Reset Password</a>
<a class="btn btn-danger" href="#delete_user_{!! $user->id !!}" data-toggle="modal" data-target="#delete_user_{!! $user->id !!}"><i class="fa fa-times"></i> Delete</a>
