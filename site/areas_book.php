<?php 
include("auth.php"); 
include("header.php"); 
include("restapi/request.php");
include("restapi/comment.php");
$user_id = $_SESSION['UID'];

$books = $db->query("SELECT ab.*, a.name as area_name, concat(u.name, ' ', u.lastname) as book_name, 
                               jt.name as job
                          FROM areas_book ab,
                               areas a,
                               job_types jt,
                               users u
                         WHERE ab.area = a.id 
                           AND ab.creator = u.id
                           AND ab.job_type = jt.id
                        ");  				 
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

        <div class="col-xl-8 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Бронь помещений</h3>
                </div>
                <div class="col-4 text-right">
                  <button id="<?php echo $request_id;?>"class="btn btn-sm btn-primary btn-book">Забронировать</button>
                </div>
              </div>
            </div>
            <div class="card-body">
              <h6 class="heading-small text-muted mb-4">Справочная информация</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-area">Локация заявки</label>
                        <select id="input-area" name='area'>
								<?php  $areas = $db->query("SELECT id, concat(id, ' - ', name) as a_name FROM areas"); 
								 while($area = $areas->fetch(PDO::FETCH_ASSOC)) 
									{ 
										$name = $area['a_name']; 
										$id = $area['id'];
										echo "<option value=\"$id\">$name</option>";
									} 
								?>
					    </select>
                      </div>
                    </div>
				    <div class="col-md-2"></div>
					<div class="col-md-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-job-type">Тип работы заявки</label>
                        <select id="input-job-type" name='job-type'>
								<?php  $job_types = $db->query("SELECT id, name FROM job_types"); 
								 while($job = $job_types->fetch(PDO::FETCH_ASSOC)) 
									{ 
										$name = $job['name']; 
										$id = $job['id'];
										echo "<option value=\"$id\">$name</option>";
									} 
								?>
					    </select>
                      </div>
                    </div>
                  </div>
            </div>
			<div class="pl-lg-4">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-begin">Начало работ</label> 
                        <input type="text" id="input-begin" class="form-control form-control-alternative" placeholder="1900-12-31" value="">						
                      </div>
                    </div>
				    <div class="col-md-2"></div>
					<div class="col-md-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-end">Конец работ</label> 
                        <input type="text" id="input-end" class="form-control form-control-alternative" placeholder="1900-12-31" value="">						
                      </div>
                    </div>
                  </div>
            </div>
			
          </div>
        </div>
      </div>
	  </div>
	    <!-- Table -->
     
        <div class="col-xl-8 order-xl-1">
          <div class="card shadow">
            <div class="card-header border-0">
              <h3 class="mb-0">Бронь на помещения</h3>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Дата</th>
					<th scope="col">Помещение</th>
                    <th scope="col">Заказчик</th>
                    <th scope="col">Тип работы</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
				<?php while($row = $books->fetch(PDO::FETCH_ASSOC)) 
                { 
	               $begin_dt = $row['begin_dt'];
				   $end_dt = $row['end_dt'];
	               $area_name = $row['area_name'];
				   $job = $row['job'];
	               $creator_name = $row['creator_name'];
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
                          <span class="mb-0 text-sm"><?php echo "$begin_dt - $end_dt";?></span>
                        </div>
                      </div>
                    </th>
                    <td>
                      <?php echo $area_name;?>
                    </td>
                    <td>
                      <span class="badge badge-dot mr-4">
                        <?php echo $creator_name;?>
                      </span>
                    </td>
					<td>
                      <?php echo $job;?>
                    </td>
                  </tr>
				 <?php } ?>
                </tbody>
              </table>
            </div>

          </div>
       </div>
</div>
<?php	
include("footer.php");
?>