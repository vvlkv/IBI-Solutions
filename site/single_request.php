<?php 
include("auth.php"); 
include("header.php"); 
include("restapi/request.php");
include("restapi/comment.php");
$user_id = $_SESSION['UID'];
$request_id = isset($_GET['id']) ? $_GET['id'] : die();

$requests = $db->query("SELECT r.*, rc.name as rc_category, concat(u.name, ' ', u.lastname) as executer_name, 
                               concat(uu.name, ' ', uu.lastname) as creator_name, rs.name as req_state, jt.name as job,
					           a.name as area_name
                          FROM requests r,
                               request_categories rc,
                               users u,
                               users uu,
                               request_states rs,
                               job_types jt,
					           areas a
                         WHERE r.creator = uu.id 
                           AND coalesce(r.executer, '-1') = u.id
                           AND r.category = rc.id
                           AND r.job_type = jt.id
                           AND r.state = rs.id
				           AND coalesce(r.location, '-1') = a.id
				           AND r.id = $request_id");  
				 
$comments = $db->query("SELECT c.*, concat(u.name, ' ', u.lastname) as creator_name
                          FROM comments c,
                               users u
                         WHERE c.creator = u.id 
                           AND c.request = $request_id
						   ORDER BY c.id DESC");
 
while($row = $requests->fetch(PDO::FETCH_ASSOC)) 
{ 
	$req_id = $row['id'];
	$req_cat = $row['rc_category'];
	$req_executer = $row['executer_name'];
	$req_creator = $row['creator_name'];
	$req_state = $row['req_state'];
	$job = $row['job'];
	$req_remark = $row['remark'];
	$req_create_date = $row['create_date'];
	$area_name = $row['area_name'];	
}
?>
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">		
        <div class="header-body">
          <!-- Card stats -->
          <div class="row"> 
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
          <div class="card card-profile shadow">
            <div class="card-body pt-0 pt-md-4" style="padding: 0 !important;">
              <div class="row">
                <div class="col">
                  <div class="card-profile-stats d-flex justify-content-center mt-md-5" style="margin-top: 0 !important;">
                    <div>
                      <span class="font-weight-light">Срочность</span>
                      <span class="description"><?php echo $req_cat; ?></span>
                    </div>
                    <div>
                      <span class="font-weight-light">Категория</span>
                      <span class="description"><?php echo $job; ?></span>
                    </div>
                    <div>
                      <span class="font-weight-light">Состояние</span>
                      <span class="description"><?php echo $req_state; ?></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="text-center">
                <h3>
                  Дата создания:<span class="font-weight-light"><?php echo " $req_create_date"; ?></span>
                </h3>
               
				<h3>
                  Создатель:<span class="font-weight-light"><?php echo " $req_creator"; ?></span>
                </h3>
				<h3>
                  Исполнитель:<span class="font-weight-light"><?php echo " $req_executer"; ?></span>
                </h3>
                
                <div>
                  <i class="ni education_hat mr-2"></i><?php echo "Где: $area_name"; ?> 
                </div>
                <hr class="my-4" />
                <p><?php echo $req_remark; ?> </p>
				<hr class="my-4" />
              </div>
            </div>
			<div class="card-header text-center border-0 ">
              <div class="d-flex justify-content-between">
                <form>
                <div class="pl-lg-4">
                  <div class="form-group">
                    <select id="assign_val" name='executer'>
								<?php  $execs = $db->query("SELECT id, concat(u.name, ' ', u.lastname) as executer_name FROM users u"); 
								 while($exec = $execs->fetch(PDO::FETCH_ASSOC)) 
									{ 
										$name = $exec['executer_name']; 
										$id = $exec['id'];
										echo "<option value=\"$id\">$name</option>";
									} 
								?>
					</select>
					<button id="<?php echo $request_id;?>"class="btn btn-sm btn-primary btn-assign">Назначить</button>
                  </div>
                </div>
              </form>
              </div>
			  <div class="d-flex justify-content-between">
			   <form>
                <div class="pl-lg-4">
                  <div class="form-group">
                    <select id="state_val" name='executer'>
								<?php  $states = $db->query("SELECT id, name FROM request_states"); 
								 while($state = $states->fetch(PDO::FETCH_ASSOC)) 
									{ 
										$name = $state['name']; 
										$id = $state['id'];
										echo "<option value=\"$id\">$name</option>";
									} 
								?>
					</select>
					<button id="<?php echo $request_id;?>"class="btn btn-sm btn-primary btn-change-state">Изменить состояние</button>
                  </div>
                </div>
              </form>
			  </div>
            </div>
          </div>
        </div>
        <div class="col-xl-8 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Оставить комментарий к заявке №<?php echo $request_id;?></h3>
                </div>
                <div class="col-4 text-right">
                  <button id="<?php echo $request_id;?>"class="btn btn-sm btn-primary btn-add-comment">Отправить</button>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form>
                <h6 class="heading-small text-muted mb-4">Комментарий</h6>
                <div class="pl-lg-4">
                  <div class="form-group">
                    <textarea rows="11" id="comment_txt" class="form-control form-control-alternative" placeholder="Комментарий">Введите сообщение</textarea>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
	  
	    <!-- Table -->
     
        <div class="col-xl-8 order-xl-1">
          <div class="card shadow">
            <div class="card-header border-0">
              <h3 class="mb-0">Комментарии к заявке №<?php echo $request_id;?></h3>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Дата</th>
                    <th scope="col">Автор</th>
                    <th scope="col">Комментарий</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
				<?php while($row = $comments->fetch(PDO::FETCH_ASSOC)) 
                { 
	               $com_remark = $row['remark'];
	               $com_creator = $row['creator_name'];
	               $com_create_date = $row['create_date'];
				?>
                  <tr>
                    <th scope="row">
                      <div class="media align-items-center">
                       <!-- <a href="#" class="avatar rounded-circle mr-3">
                          <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fas fa-tag"></i>
                      </div>
                        </a>-->
                        <div class="media-body">
                          <span class="mb-0 text-sm"><?php echo $com_create_date;?></span>
                        </div>
                      </div>
                    </th>
                    <td>
                      <?php echo $com_creator;?>
                    </td>
                    <td>
                      <span class="badge badge-dot mr-4">
                        <?php echo $com_remark;?>
                      </span>
                    </td>
                  </tr>
				 <?php } ?>
                </tbody>
              </table>
            </div>

          </div>
       
</div>
<?php	
include("footer.php");
?>